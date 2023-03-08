<?php

declare(strict_types=1);

/*
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2023 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    LGPL-3.0+
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoThemesNet\ThemeComponentsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Environment;
use Contao\PageModel;

#[AsHook('replaceInsertTags', priority: 100)]
class ReplaceInsertTagsListener
{
    // tag com means (theme) components
    public const TAG = 'comp';

    private const AssetsPath = 'bundles/themecomponents';
    private bool $enable_high_contrast;

    private bool $enable_text_size;

    /**
     * Replace the icon insert tag.
     */
    public function __invoke($tag)
    {
        // get the current root page
        $page = PageModel::findOneByType('root');

        $this->high_contrast = $page->enable_high_contrast;
        $this->text_size = $page->enable_text_size;

        $chunks = explode('::', $tag);

        if (self::TAG !== $chunks[0]) {
            return false;
        }

        switch ($chunks[1]) {
            case 'contrast': $tag = $this->generateContrastTag($chunks); break;

            case 'size': $tag = $this->generateSizeTag($chunks); break;

            default:
                // invalid tag
                return false;
        }

        return $tag;
    }

    private function generateContrastTag(array $chunks): string
    {
        $svgCircle = self::AssetsPath.'/svg/circle-half-stroke-solid.svg';

        $javascript = <<<'EOS'
            let b = document.querySelector(`body`);if(localStorage.getItem(`high-contrast`)===`on`) { localStorage.setItem(`high-contrast`, `off`);b.classList.remove(`high-contrast`); } else { localStorage.setItem(`high-contrast`, `on`);b.classList.add(`high-contrast`); };
            EOS;

        return $this->high_contrast ?
            "<img src='$svgCircle' class='square16' alt='Kontrast' onclick='$javascript'>" :
            "<img src='$svgCircle' class='square16' alt='Kontrast disabled'>"
        ;
    }

    private function generateSizeTag(array $chunks): string
    {
        $html = 'size';

        $targetPage = PageModel::findOneByAlias($chunks[2]);

        if ($targetPage) {
            $html .= Environment::get('requestUri');
        } else {
            $html = 'alias nicht gefunden';
        }

        return $html;
    }
}
