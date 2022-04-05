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

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\System;

/**
 * Class ContentBoxElement.
 *
 * @author Philipp Seibt <develop@pdir.de>
 */
class ContentBoxElement extends ContentElement
{
    use ElementHelperTrait;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_contentbox';

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        $this->Template->page = $this->ct_contentBox_page;
        $this->Template->pageText = $this->ct_contentBox_pageText;
        $this->Template->pageTitle = '';
        $this->Template->target = '';
        $this->Template->rel = '';

        // Overwrite template
        if ('' !== $this->ct_contentBox_customTpl) {
            $this->Template->setName($this->ct_contentBox_customTpl);
        }

        // Overwrite page title
        if ('' !== $this->ct_contentBox_pageTitle) {
            $this->Template->pageTitle = ' title="'.$this->ct_contentBox_pageTitle.'"';
        }

        // Add an image
        if ($this->addImage && '' !== $this->singleSRC) {
            $objModel = FilesModel::findByUuid($this->singleSRC);

            if (null !== $objModel && is_file(System::getContainer()->getParameter('kernel.project_dir').'/'.$objModel->path)) {
                $this->singleSRC = $this->Template->href = $objModel->path;
                $this->addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
            }
        }

        // Overwrite link target
        if ($this->target) {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}
