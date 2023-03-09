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

        // get the current root page
        $page = PageModel::findByPk($objPage->rootId);

        $high_contrast = $page->enable_high_contrast;
        //$text_size = $page->enable_text_size;

        if ($high_contrast) {
            // waiting for a fe_page call
            if ('fe_page' === substr($templateName, 0, 7)) {
                $script = <<<'EOS'
                      <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                          if(localStorage.getItem('high-contrast')==='on') document.querySelector('body').classList.add('high-contrast');  
                        })
                      </script>
                    EOS;

                $buffer = preg_replace('/<\/head/', "$script$0", $buffer);
            }
        }

        return $buffer;
    }
}
