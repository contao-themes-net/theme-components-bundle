<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace ContaoThemesNet\ThemeComponentsBundle\Module;

/**
 * Class ModalModule
 *
 * @author Philipp Seibt <develop@pdir.de>
 */
class ModalModule extends \Module
{
    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### THEME MODAL ###';
            $objTemplate->title = $this->name;
            $objTemplate->id = $this->id;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        if($this->modal_customTpl != "") {
            $this->Template->setName($this->modal_customTpl);
        } else {
            $this->Template->setName("mod_cthemes_modal");
        }
        $this->Template->linkText = $this->modal_linkText;

        if($this->modal_linkClass != "") {
            $this->Template->linkClass = " ".$this->modal_linkClass;
        } else {
            $this->Template->linkClass = "";
        }

        if($this->modal_class != "") {
            $this->Template->modalClass = " ".$this->modal_class;
        } else {
            $this->Template->modalClass = "";
        }

        $this->Template->text = $this->modal_text;
    }
}
