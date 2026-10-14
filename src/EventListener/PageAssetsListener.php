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

namespace ContaoThemesNet\ThemeComponentsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Event\LayoutEvent;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * Adds the stylesheets and scripts of the accessibility tools (high contrast,
 * font size) and the scroll animations to the page.
 *
 * Legacy page layouts trigger the "generatePage" hook, page layouts of the type
 * "modern" dispatch the LayoutEvent instead. Both layout types output the
 * $GLOBALS['TL_CSS'], ['TL_JAVASCRIPT'], ['TL_HEAD'] and ['TL_BODY'] entries.
 */
class PageAssetsListener
{
    private const ASSETS_PATH = 'bundles/themecomponents';

    private const HIGH_CONTRAST_SCRIPT = <<<'EOS'
        <script>
          document.addEventListener('DOMContentLoaded', (event) => {
            if(localStorage.getItem('high-contrast')==='on') {
                document.querySelector('body').classList.add('high-contrast');
                document.documentElement.setAttribute('data-contrast-mode', 'on');
            }
          })
        </script>
        EOS;

    private const AUTO_HIGH_CONTRAST_SCRIPT = <<<'EOS'
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const root = document.documentElement;

            // Always set the attribute, regardless of the state
            root.setAttribute('data-contrast-mode', 'on');

            const applyHighContrast = () => {
              const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
              const prefersContrast = window.matchMedia('(prefers-contrast: more)').matches;
              const localContrast = localStorage.getItem('high-contrast') === 'on';

              // Add .high-contrast if any of these conditions applies
              if (localContrast || prefersDark || prefersContrast) {
                body.classList.add('high-contrast');
              } else {
                body.classList.remove('high-contrast');
              }
            };

            // Initial check
            applyHighContrast();

            // Watch for changes of the system settings
            const darkQuery = window.matchMedia('(prefers-color-scheme: dark)');
            const contrastQuery = window.matchMedia('(prefers-contrast: more)');

            const handleChange = () => applyHighContrast();

            if (darkQuery.addEventListener) {
              darkQuery.addEventListener('change', handleChange);
              contrastQuery.addEventListener('change', handleChange);
            } else if (darkQuery.addListener) {
              // Fallback for older browsers
              darkQuery.addListener(handleChange);
              contrastQuery.addListener(handleChange);
            }
          });
        </script>
        EOS;

    private const FONT_SIZE_SCRIPT = <<<'EOS'
        <script>
          document.addEventListener('DOMContentLoaded', (event) => {
            if(localStorage.getItem('font-size')!=='') document.querySelector('body').style.fontSize = localStorage.getItem('font-size');
          })
        </script>
        EOS;

    public function __construct(private readonly ContaoFramework $framework)
    {
    }

    /**
     * Legacy page layouts.
     */
    #[AsHook('generatePage', priority: 100)]
    public function onGeneratePage(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $this->addAssets($pageModel);
    }

    /**
     * Page layouts of the type "modern".
     */
    #[AsEventListener(LayoutEvent::class)]
    public function onLayout(LayoutEvent $event): void
    {
        $this->addAssets($event->getPage());
    }

    private function addAssets(PageModel $page): void
    {
        $GLOBALS['TL_CSS']['tcb'] = self::ASSETS_PATH.'/css/theme-components.css|static';

        if (!$page->rootId || !$rootPage = $this->framework->getAdapter(PageModel::class)->findById($page->rootId)) {
            return;
        }

        if ($rootPage->animateOnScroll) {
            $GLOBALS['TL_CSS']['reveal'] = self::ASSETS_PATH.'/css/reveal.css|static';
            $GLOBALS['TL_JAVASCRIPT']['reveal'] = self::ASSETS_PATH.'/js/reveal.js|static';
        }

        if ($rootPage->enable_auto_high_contrast) {
            $GLOBALS['TL_BODY']['tcb_auto_high_contrast'] = self::AUTO_HIGH_CONTRAST_SCRIPT;
        } elseif ($rootPage->enable_high_contrast) {
            $GLOBALS['TL_HEAD']['tcb_high_contrast'] = self::HIGH_CONTRAST_SCRIPT;
        }

        if ($rootPage->enable_font_size_switcher) {
            $GLOBALS['TL_BODY']['tcb_font_size'] = self::FONT_SIZE_SCRIPT;
        }
    }
}
