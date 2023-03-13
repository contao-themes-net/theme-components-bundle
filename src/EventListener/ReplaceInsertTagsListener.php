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
    // tag 'comp' means (theme) components
    public const TAG = 'comp';

    private const AssetsPath = 'bundles/themecomponents';
    /**
     * @var string contao char(1) = '1' flag to allow to switch in high contrast mode
     */
    private bool $high_contrast;

    /**
     * @var string contao char(1) = '1' flag to show a text size link
     */
    private bool $text_size;

    private $text_size_comment_page = 1;

    /**
     * Replace the icon insert tag.
     */
    public function __invoke($tag)
    {
        global $objPage;
        // get the current root page
        $page = PageModel::findByPk($objPage->rootId);

        $this->high_contrast = (bool)$page->enable_high_contrast;
        $this->text_size = (bool)$page->enable_text_size;
        $this->text_size_comment_page = $page->text_size_comment_page;

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

    /**
     * @param array $chunks
     * @return string
     */
    private function generateContrastTag(array $chunks): string
    {
        $svgCircleIcon = self::AssetsPath.'/svg/circle_half_stroke.svg';
        [$alt, $title] = $GLOBALS['TL_LANG']['WCAG']['enable_high_contrast'];

        $javascript = <<<'EOS'
            let b = document.querySelector(`body`);if(localStorage.getItem(`high-contrast`)===`on`) { localStorage.setItem(`high-contrast`, `off`);b.classList.remove(`high-contrast`); } else { localStorage.setItem(`high-contrast`, `on`);b.classList.add(`high-contrast`); };
EOS;
        return $this->high_contrast ? "<img src='$svgCircleIcon' class='square16' alt='$alt' title='$title' onclick='$javascript'>" : "";
    }

    /**
     * @param array $chunks
     * @return string
     */
    private function generateSizeTag(array $chunks): string
    {
        // text size is disabled
        if(!$this->text_size) return '';

        $html = '';

        $svgSizeIcon = self::AssetsPath.'/svg/format_size.svg';
        [$alt, $title] = $GLOBALS['TL_LANG']['WCAG']['enable_text_size'];

        // handle user defined uri like comp::text::uri
        if(count($chunks)===3) return "<a href='{$chunks[2]}' title='$title'><img src='$svgSizeIcon' class='square16' alt='$alt'></a>";

        // handle empty page selection
        if($this->text_size_comment_page > 0) {
            $targetPage = PageModel::findBypk($this->text_size_comment_page);
            $href = $targetPage->getFrontendUrl();
        } else {
            $href = '';
        }

        return "<a href='$href' title='$title'><img src='$svgSizeIcon' class='square16' alt='$alt'></a>";
    }
}
