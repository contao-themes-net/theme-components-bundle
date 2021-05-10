<?php

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

class SliderElement extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_slider_element';

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

            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->text = \StringUtil::toHtml5($this->text);

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->page = $this->ct_sliderElement_page;
        $this->Template->linkText = $this->ct_sliderElement_linkText;
        $this->Template->metaImg = unserialize(\FilesModel::findByUuid($this->singleSRC)->meta);
        $this->Template->picture = $this->singleSRC;
        $this->Template->subheadline = $this->ct_sliderElement_subHeadline;

        if($this->ct_sliderElement_playerSRC != "") {
            $this->Template->playerSRC = \FilesModel::findByUuid($this->ct_sliderElement_playerSRC)->path;
        } else {
            $this->Template->playerSRC = "";
        }

        // overwrite link target
        $this->Template->target = '';
        $this->Template->rel = '';
        if ($this->ct_sliderElement_target)
        {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}