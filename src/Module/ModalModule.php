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

namespace ContaoThemesNet\ThemeComponentsBundle\Module;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ModalModule.
 *
 * @author Philipp Seibt <develop@pdir.de>
 */
class ModalModule extends Module
{
    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### THEME MODAL ###';
            $objTemplate->title = $this->name;
            $objTemplate->id = $this->id;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        // set template values
        $this->Template->setName('mod_cthemes_modal');
        $this->Template->linkText = $this->modal_linkText;
        $this->Template->linkClass = '';
        $this->Template->modalClass = '';

        if ('' !== $this->modal_customTpl) {
            $this->Template->setName($this->modal_customTpl);
        }

        if ('' !== $this->modal_linkClass) {
            $this->Template->linkClass = ' '.$this->modal_linkClass;
        }

        if ('' !== $this->modal_class) {
            $this->Template->modalClass = ' '.$this->modal_class;
        }

        $this->Template->text = $this->modal_text;
    }
}
