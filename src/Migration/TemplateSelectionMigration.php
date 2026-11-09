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
 * Moves the legacy template selections of the elements and modules (e.g.
 * "ce_cthemes_contentbox_foo") to the core "customTpl" field and points them to
 * the corresponding Twig variant (e.g. "content_element/ct_content_box/foo").
 *
 * If the Twig variant does not exist yet, content elements keep their legacy
 * selection, so the migration runs again as soon as a theme provides its
 * variant. The modal module still supports legacy templates and therefore gets
 * the legacy template name in the "customTpl" field instead.
 */
class TemplateSelectionMigration extends AbstractMigration
{
    /**
     * Table => type => [column of the legacy selection, legacy template, Twig template, keep legacy templates].
     */
    private const TEMPLATES = [
        'tl_content' => [
            'ct_contentBox' => ['ct_contentBox_customTpl', 'ce_cthemes_contentbox', 'content_element/ct_content_box', false],
            'ct_teaserBox' => ['ct_teaserBox_customTpl', 'ce_cthemes_teaserbox', 'content_element/ct_teaser_box', false],
            'ct_priceBox' => ['ct_priceBox_customTpl', 'ce_cthemes_pricebox', 'content_element/ct_price_box', false],
            'ct_featureElement' => ['ct_featureElement_customTpl', 'ce_cthemes_feature_element', 'content_element/ct_feature_element', false],
            'ct_sliderElement' => ['customTpl', 'ce_slider_element', 'content_element/ct_slider_element', false],
        ],
        'tl_module' => [
            'ct_modal' => ['modal_customTpl', 'mod_cthemes_modal', 'frontend_module/ct_modal', true],
        ],
    ];

    public function __construct(
        private readonly Connection $connection,
        private readonly ContaoFilesystemLoader $filesystemLoader,
    ) {
    }

    public function shouldRun(): bool
    {
        return [] !== $this->getUpdates();
    }

    public function run(): MigrationResult
    {
        foreach ($this->getUpdates() as $table => $updates) {
            foreach ($updates as $id => $data) {
                $this->connection->update($table, $data, ['id' => $id]);
            }
        }

        return $this->createResult(true);
    }

    /**
     * @return array<string, array<int, array<string, string>>>
     */
    private function getUpdates(): array
    {
        $schemaManager = $this->connection->createSchemaManager();
        $updates = [];

        foreach (self::TEMPLATES as $table => $templates) {
            if (!$schemaManager->tablesExist([$table])) {
                continue;
            }

            $columns = $schemaManager->listTableColumns($table);

            if (!isset($columns['customtpl'])) {
                continue;
            }

            foreach ($templates as $type => [$column, $legacyTemplate, $template, $keepLegacy]) {
                if (!isset($columns[strtolower($column)])) {
                    continue;
                }

                $rows = $this->connection->fetchAllAssociative(
                    "SELECT id, customTpl, $column AS legacyTpl FROM $table WHERE type = ? AND $column LIKE ?",
                    [$type, $legacyTemplate.'%'],
                );

                foreach ($rows as $row) {
                    $data = $this->getUpdate($row, $column, $legacyTemplate, $template, $keepLegacy);

                    if (null !== $data) {
                        $updates[$table][(int) $row['id']] = $data;
                    }
                }
            }
        }

        return $updates;
    }

    /**
     * @param array{customTpl: string, legacyTpl: string} $row
     *
     * @return array<string, string>|null
     */
    private function getUpdate(array $row, string $column, string $legacyTemplate, string $template, bool $keepLegacy): array|null
    {
        // The default template was selected explicitly
        if ($row['legacyTpl'] === $legacyTemplate) {
            return [$column => ''];
        }

        if (!str_starts_with($row['legacyTpl'], $legacyTemplate.'_')) {
            return null;
        }

        // A template has already been selected in the core field
        if ('customTpl' !== $column && '' !== (string) $row['customTpl']) {
            return [$column => ''];
        }

        $variant = $template.'/'.substr($row['legacyTpl'], \strlen($legacyTemplate) + 1);

        if (!$this->filesystemLoader->exists("@Contao/$variant.html.twig")) {
            if (!$keepLegacy) {
                return null;
            }

            $variant = $row['legacyTpl'];
        }

        return 'customTpl' === $column ? ['customTpl' => $variant] : ['customTpl' => $variant, $column => ''];
    }
}
