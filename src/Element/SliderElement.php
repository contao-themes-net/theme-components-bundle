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

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\System;

class SliderElement extends ContentElement
{
    use ElementHelperTrait;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_slider_element';

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        $this->Template->page = $this->ct_sliderElement_page;
        $this->Template->linkText = $this->ct_sliderElement_linkText;
        $this->Template->subheadline = $this->ct_sliderElement_subHeadline;
        $this->Template->playerSRC = '';
        $this->Template->target = '';
        $this->Template->rel = '';

        // Add an image
        $this->Template->picture = $this->singleSRC;

        if ($this->addImage && '' !== $this->singleSRC) {
            $objModel = FilesModel::findByUuid($this->singleSRC);

            if (null !== $objModel && is_file(System::getContainer()->getParameter('kernel.project_dir').'/'.$objModel->path)) {
                if ($objModel->meta) {
                    $this->Template->metaImg = unserialize($objModel->meta);
                }
            }
        }

        // Add player src
        if ('' !== $this->ct_sliderElement_playerSRC) {
            $objModel = FilesModel::findByUuid($this->ct_sliderElement_playerSRC);

            if (null !== $objModel && is_file(System::getContainer()->getParameter('kernel.project_dir').'/'.$objModel->path)) {
                $this->Template->playerSRC = $objModel->path;
            }
        }

        // Overwrite link target
        if ($this->ct_sliderElement_target) {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}
