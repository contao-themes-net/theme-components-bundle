<?php

declare(strict_types=1);

/*
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2026 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    LGPL-3.0+
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ContaoThemesNet\ThemeComponentsBundle\Migration;
namespace ContaoThemesNet\ThemeComponentsBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\CoreBundle\Twig\Loader\ContaoFilesystemLoader;
use Doctrine\DBAL\Connection;

/**
 * Converts the "ct_wrapperStart"/"ct_wrapperStop" pairs into core
 * "element_group" elements with nested child elements:
 *
 *  - the start element becomes the element group (CSS ID/classes, visibility
 *    and protection are kept, the name is moved to the "title" field),
 *  - the elements in between are moved into the group (nested wrappers are
 *    converted into nested groups),
 *  - the stop element is deleted.
 *
 * A start element without a stop element wraps all following elements of its
 * parent, which matches the former output. Stop elements without a start
 * element only closed a foreign tag and are deleted as well.
 */
class WrapperToElementGroupMigration extends AbstractMigration
{
    private const START = 'ct_wrapperStart';

    private const STOP = 'ct_wrapperStop';

    private const GROUP = 'element_group';

    public function __construct(
        private readonly Connection $connection,
        private readonly ContaoFilesystemLoader $filesystemLoader,
    ) {
    }

    public function getName(): string
    {
        return 'Theme components bundle: convert content wrappers into element groups';
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(['tl_content'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_content');

        foreach (['ptable', 'title', 'customtpl'] as $column) {
            if (!isset($columns[$column])) {
                return false;
            }
        }

        return false !== $this->connection->fetchOne(
            'SELECT TRUE FROM tl_content WHERE type IN (?, ?) LIMIT 1',
            [self::START, self::STOP],
        );
    }

    public function run(): MigrationResult
    {
        $hasNameColumn = isset($this->connection->createSchemaManager()->listTableColumns('tl_content')['ct_wrapper_name']);
        $groups = 0;

        $parents = $this->connection->fetchAllAssociative(
            'SELECT DISTINCT pid, ptable FROM tl_content WHERE type IN (?, ?)',
            [self::START, self::STOP],
        );

        $this->connection->transactional(
            function () use ($parents, $hasNameColumn, &$groups): void {
                foreach ($parents as $parent) {
                    $groups += $this->migrateParent((int) $parent['pid'], (string) $parent['ptable'], $hasNameColumn);
                }
            },
        );

        return $this->createResult(true, \sprintf('Converted %d content wrapper(s) into element groups.', $groups));
    }

    /**
     * Walks through the elements of one parent in their sorting order and
     * returns the number of created element groups.
     */
    private function migrateParent(int $pid, string $ptable, bool $hasNameColumn): int
    {
        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, type, customTpl, title'.($hasNameColumn ? ', ct_wrapper_name' : '').' FROM tl_content WHERE pid = ? AND ptable = ? ORDER BY sorting, id',
            [$pid, $ptable],
        );

        $time = time();
        $stack = [];
        $sorting = [];
        $updates = [];
        $deletes = [];

        foreach ($rows as $row) {
            $id = (int) $row['id'];

            if (self::STOP === $row['type']) {
                array_pop($stack);
                $deletes[] = $id;
                continue;
            }

            // Move the element into the innermost open group
            if ($groupId = end($stack)) {
                $sorting[$groupId] = ($sorting[$groupId] ?? 0) + 128;
                $updates[$id] = ['pid' => $groupId, 'ptable' => 'tl_content', 'sorting' => $sorting[$groupId], 'tstamp' => $time];
            }

            if (self::START === $row['type']) {
                $updates[$id] = [
                    ...($updates[$id] ?? []),
                    'type' => self::GROUP,
                    'title' => (string) $row['title'] ?: (string) ($row['ct_wrapper_name'] ?? ''),
                    'customTpl' => $this->getGroupTemplate((string) $row['customTpl']),
                    'tstamp' => $time,
                ];

                $stack[] = $id;
            }
        }

        foreach ($updates as $id => $data) {
            $this->connection->update('tl_content', $data, ['id' => $id]);
        }

        foreach ($deletes as $id) {
            $this->connection->delete('tl_content', ['id' => $id]);
        }

        return \count(array_filter($updates, static fn (array $data): bool => self::GROUP === ($data['type'] ?? null)));
    }

    /**
     * Maps a template selection of the start element (e.g.
     * "ce_cthemes_wrapper_start_foo") to an element group variant
     * ("content_element/element_group/foo") if it exists.
     */
    private function getGroupTemplate(string $template): string
    {
        foreach (['ce_cthemes_wrapper_start_', 'content_element/ct_wrapper_start/'] as $prefix) {
            if (!str_starts_with($template, $prefix)) {
                continue;
            }

            $variant = 'content_element/element_group/'.substr($template, \strlen($prefix));

            if ($this->filesystemLoader->exists("@Contao/$variant.html.twig")) {
                return $variant;
            }
        }

        return '';
    }
}
