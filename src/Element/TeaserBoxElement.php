<?php

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

class TeaserBoxElement extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_teaserbox';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);
            $this->Template->title = $this->headline;
            $this->Template->text = \StringUtil::toHtml5($this->text);
        }

        $this->Template->page = $this->ct_teaserBox_page;
        $this->Template->picture = \FilesModel::findByUuid($this->singleSRC)->path;
        $this->Template->metaImg = unserialize(\FilesModel::findByUuid($this->singleSRC)->meta);
        $this->Template->pageText = $this->ct_teaserBox_pageText;

        // add an image
        if ($this->addImage && $this->singleSRC != '')
        {
            $objModel = \FilesModel::findByUuid($this->singleSRC);
            if ($objModel !== null && is_file(\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objModel->path))
            {
                $this->singleSRC = $objModel->path;
                $this->addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
            }
        }

        // overwrite link target
        $this->Template->target = '';
        $this->Template->rel = '';
        if ($this->target)
        {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}
