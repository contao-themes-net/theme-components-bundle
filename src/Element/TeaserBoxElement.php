<?php

declare(strict_types=1);

/*
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2022 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    LGPL-3.0+
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\FilesModel;
use Contao\System;

class TeaserBoxElement extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_teaserbox';

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        if (TL_MODE === 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->title = $this->headline;
            $objTemplate->text = $this->text;
        }

        if (TL_MODE !== 'BE') {
            if ('' !== $this->ct_teaserBox_customTpl) {
                $this->Template->setName($this->ct_teaserBox_customTpl);
            }

            $this->Template->page = $this->ct_teaserBox_page;

            if (null !== $this->singleSRC) {
                $this->Template->picture = FilesModel::findByUuid($this->singleSRC)->path;
            }

            $this->Template->pageText = $this->ct_teaserBox_pageText;

            // add an image
            if ($this->addImage && null !== $this->singleSRC) {
                $objModel = FilesModel::findByUuid($this->singleSRC);

                if (null !== $objModel && is_file(System::getContainer()->getParameter('kernel.project_dir').'/'.$objModel->path)) {
                    $this->singleSRC = $objModel->path;
                    $this->addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
                }
            }

            // overwrite link target
            $this->Template->target = '';
            $this->Template->rel = '';

            if ($this->target) {
                $this->Template->target = ' target="_blank"';
                $this->Template->rel = ' rel="noreferrer noopener"';
            }

            //link title
            $this->Template->pageTitle = '';

            if ('' !== $this->ct_teaserBox_pageTitle) {
                $this->Template->pageTitle = ' title="'.$this->ct_teaserBox_pageTitle.'"';
            }
        }
    }
}
