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
use Contao\FilesModel;
use Contao\StringUtil;

class SliderElement extends \ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_slider_element';

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->text = StringUtil::toHtml5($this->text);

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        $this->Template->page = $this->ct_sliderElement_page;
        $this->Template->linkText = $this->ct_sliderElement_linkText;
        $this->Template->metaImg = unserialize(FilesModel::findByUuid($this->singleSRC)->meta);
        $this->Template->picture = $this->singleSRC;
        $this->Template->subheadline = $this->ct_sliderElement_subHeadline;

        if ('' !== $this->ct_sliderElement_playerSRC) {
            $this->Template->playerSRC = FilesModel::findByUuid($this->ct_sliderElement_playerSRC)->path;
        } else {
            $this->Template->playerSRC = '';
        }

        // overwrite link target
        $this->Template->target = '';
        $this->Template->rel = '';

        if ($this->ct_sliderElement_target) {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}
