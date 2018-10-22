<?php

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

class WrapperStartElement extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_wrapper_start';


    /**
     * Generate the content element
     */
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate($this->strTemplate);
            $this->Template = $objTemplate;
            if($this->ct_wrapper_name != "") $this->Template->wildcard = "### " . $this->ct_wrapper_name. " ###";
        }
    }
}
