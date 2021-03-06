<?php
/**
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    pdir contao theme licence
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

/**
 * Class ContentBoxElement
 *
 * @author Philipp Seibt <develop@pdir.de>
 */
class ContentBoxElement extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_contentbox';

    /**
     * Generate the module
     */
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->title = $this->headline;
            $objTemplate->text = $this->text;
        } else {
            if($this->ct_contentBox_customTpl != "") {
                $this->Template->setName($this->ct_contentBox_customTpl);
            }

            $this->Template->page = $this->ct_contentBox_page;
            if(!is_null($this->singleSRC)) $this->Template->href = \FilesModel::findByUuid($this->singleSRC)->path;
            $this->Template->pageText = $this->ct_contentBox_pageText;

            // overwrite link target
            $this->Template->target = '';
            $this->Template->rel = '';
            if ($this->target)
            {
                $this->Template->target = ' target="_blank"';
                $this->Template->rel = ' rel="noreferrer noopener"';
            }

            //link title
            $this->Template->pageTitle = "";
            if( $this->ct_contentBox_pageTitle != "" ) {
                $this->Template->pageTitle = ' title="'.$this->ct_contentBox_pageTitle.'"';
            }

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
        }
    }
}
