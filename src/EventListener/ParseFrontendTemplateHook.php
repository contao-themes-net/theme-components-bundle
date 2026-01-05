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

#[AsHook('parseFrontendTemplate', priority: 100)]
class ParseFrontendTemplateHook
{
    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        global $objPage;

        if ($objPage !== null && $objPage->rootId !== null) {
            // get the current root page
            $page = PageModel::findByPk($objPage->rootId);

            $high_contrast = $page->enable_high_contrast;
            $auto_high_contrast = $page->enable_auto_high_contrast;
            $font_size_switcher = $page->enable_font_size_switcher;

            if ($high_contrast && !$auto_high_contrast) {
                // waiting for a fe_page_* call
                if ('fe_page' === substr($templateName, 0, 7)) {
                    $script = <<<'EOS'
                      <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                          if(localStorage.getItem('high-contrast')==='on') {
                              document.querySelector('body').classList.add('high-contrast');
                              document.documentElement.setAttribute('data-contrast-mode', 'on');
                          }
                        })
                      </script>
                    EOS;

                    $buffer = preg_replace('/<\/head/', "$script$0", $buffer);
                }
            }

            if ($auto_high_contrast) {
                // waiting for a fe_page_* call
                if ('fe_page' === substr($templateName, 0, 7)) {
                    $script = <<<EOS
                      <script>
                        document.addEventListener('DOMContentLoaded', () => {
                          const body = document.body;
                          const root = document.documentElement;

                          // Attribut immer setzen, unabhängig von Zustand
                          root.setAttribute('data-contrast-mode', 'on');

                          const applyHighContrast = () => {
                            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                            const prefersContrast = window.matchMedia('(prefers-contrast: more)').matches;
                            const localContrast = localStorage.getItem('high-contrast') === 'on';

                            // Wenn irgendeine dieser Bedingungen zutrifft → .high-contrast hinzufügen
                            if (localContrast || prefersDark || prefersContrast) {
                              body.classList.add('high-contrast');
                            } else {
                              body.classList.remove('high-contrast');
                            }
                          };

                          // Initial prüfen
                          applyHighContrast();

                          // Änderungen an Systemmodus überwachen
                          const darkQuery = window.matchMedia('(prefers-color-scheme: dark)');
                          const contrastQuery = window.matchMedia('(prefers-contrast: more)');

                          const handleChange = () => applyHighContrast();

                          if (darkQuery.addEventListener) {
                            darkQuery.addEventListener('change', handleChange);
                            contrastQuery.addEventListener('change', handleChange);
                          } else if (darkQuery.addListener) {
                            // Fallback für ältere Browser
                            darkQuery.addListener(handleChange);
                            contrastQuery.addListener(handleChange);
                          }
                        });
                      </script>
                    EOS;

                    $buffer = preg_replace('/<\/body/', "$script$0", $buffer);
                }
            }

            if ($font_size_switcher) {
                // waiting for a fe_page_* call
                if ('fe_page' === substr($templateName, 0, 7)) {
                    $script = <<<'EOS'
                      <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                          if(localStorage.getItem('font-size')!=='') document.querySelector('body').style.fontSize = localStorage.getItem('font-size');
                        })
                      </script>
                    EOS;

                    $buffer = preg_replace('/<\/body/', "$script$0", $buffer);
                }
            }
        }

        return $buffer;
    }
}
