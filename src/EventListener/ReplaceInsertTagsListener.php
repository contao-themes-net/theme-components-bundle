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
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;

#[AsHook('replaceInsertTags', priority: 100)]
class ReplaceInsertTagsListener
{
    // tag 'comp' means (theme) components
    public const TAG = 'comp';

    private const AssetsPath = 'bundles/themecomponents';

    private const SVG_CIRCLE_TEMPLATE = "<svg xmlns='http://www.w3.org/2000/svg' height='48' width='48' class='%s' onclick='%s'><title>%s</title><desc>%s</desc><path fill='currentColor' d='M24 44q-4.15 0-7.8-1.575-3.65-1.575-6.35-4.275-2.7-2.7-4.275-6.35Q4 28.15 4 24t1.575-7.8Q7.15 12.55 9.85 9.85q2.7-2.7 6.35-4.275Q19.85 4 24 4t7.8 1.575q3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24t-1.575 7.8q-1.575 3.65-4.275 6.35-2.7 2.7-6.35 4.275Q28.15 44 24 44Zm1-3q6.85-.5 11.425-5.3Q41 30.9 41 24q0-6.9-4.575-11.7Q31.85 7.5 25 7Z'/></svg>";
    private const SVG_SIZE_TEMPLATE = "<svg xmlns='http://www.w3.org/2000/svg' height='48' width='48' class='%s'><title>%s</title><desc>%s</desc><path fill='currentColor' d='M28.5 40V13H18V8h26v5H33.5v27Zm-18 0V23H4v-5h18v5h-6.5v17Z'/></svg>";
    /**
     * @var string contao char(1) = '1' flag to allow to switch in high contrast mode
     */
    private bool $high_contrast;

    /**
     * @var string contao char(1) = '1' flag to show a font size link
     */
    private bool $font_size;

    private $font_size_comment_page = 1;

    /**
     * Replace the icon insert tag.
     */
    public function __invoke($tag)
    {
        global $objPage;

        $chunks = explode('::', $tag);

        if (self::TAG !== $chunks[0]) {
            return false;
        }

        if (null === $objPage) {
            switch ($chunks[1]) {
                case 'contrast':
                    System::loadLanguageFile('default');
                    //[$title, $description] = $GLOBALS['TL_LANG']['WCAG']['enable_high_contrast'];
                    $tag = sprintf(
                        self::SVG_CIRCLE_TEMPLATE,
                        'wcag-square', // css class
                        '',
                        '$title',
                        '$description'
                    );
                    break;

                case 'size':
                    //[$alt, $title] = $GLOBALS['TL_LANG']['WCAG']['enable_font_size'];
                    $tag = sprintf(
                        self::SVG_SIZE_TEMPLATE,
                        'wcag-size', // css class
                        '$title'
                    );
                    break;

                case 'text-size-switcher':
                    $tag = $this->generateTextSizeSwitcherTag($chunks);
                    break;

                default:
                    // invalid tag
                    return false;
            }
        } else {
            $page = PageModel::findByPk($objPage->rootId);

            $this->high_contrast = (bool) $page->enable_high_contrast;
            $this->font_size = (bool) $page->enable_font_size;
            $this->font_size_switcher = (bool) $page->enable_font_size_switcher;
            $this->font_size_comment_page = $page->font_size_comment_page;

            switch ($chunks[1]) {
                case 'contrast':
                    $tag = $this->generateContrastTag($chunks);
                    break;

                case 'size':
                    $tag = $this->generateSizeTag($chunks);
                    break;

                case 'text-size-switcher':
                    $tag = $this->generateTextSizeSwitcherTag($chunks);
                    break;

                default:
                    // invalid tag
                    return false;
            }
        }

        return $tag;
    }

    private function generateContrastTag(array $chunks): string
    {
        [$title, $description] = $GLOBALS['TL_LANG']['WCAG']['enable_high_contrast'];

        $javascript = 'let b = document.querySelector(`body`);if(localStorage.getItem(`high-contrast`)===`on`) { localStorage.setItem(`high-contrast`, `off`);b.classList.remove(`high-contrast`); } else { localStorage.setItem(`high-contrast`, `on`);b.classList.add(`high-contrast`); };';

        $svgCircleIcon = sprintf(
            self::SVG_CIRCLE_TEMPLATE,
            'wcag-square', // css class
            $javascript,
            $title,
            $description
        );

        return $this->high_contrast ? $svgCircleIcon : '';
    }

    private function generateSizeTag(array $chunks): string
    {
        // font size is disabled
        if (!$this->font_size) {
            return '';
        }

        [$alt, $title] = $GLOBALS['TL_LANG']['WCAG']['enable_font_size'];

        $svgSizeIcon = sprintf(
            self::SVG_SIZE_TEMPLATE,
            'wcag-size', // css class
            $alt,
            $title
        );

        // handle user defined uri like comp::text::uri
        if (3 === \count($chunks)) {
            return "<a href='{$chunks[2]}' title='$alt'>$svgSizeIcon</a>";
        }

        // handle empty page selection
        if ($this->font_size_comment_page > 0) {
            $targetPage = PageModel::findBypk($this->font_size_comment_page);
            $href = $targetPage->getFrontendUrl();
        } else {
            $href = '';
        }

        return "<a href='$href' title='$title'>$svgSizeIcon</a>";
    }

    private function generateTextSizeSwitcherTag(array $chunks): string
    {
        $template = new FrontendTemplate('ce_font_size_switcher');

        $template->smallerButtonTitle = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_smaller'][0];
        $template->normalButtonTitle = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_normal'][0];
        $template->greaterButtonTitle = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_greater'][0];

        $template->smallerButtonText = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_smaller'][1];
        $template->normalButtonText = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_normal'][1];
        $template->greaterButtonText = $GLOBALS['TL_LANG']['WCAG']['font_size_switch_greater'][1];

        return $this->font_size_switcher ? $template->parse() : '';
    }
}
