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

class PriceBoxElement extends ContentElement
{
    use ElementHelperTrait;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_pricebox';

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        // Overwrite template
        if ('' !== $this->ct_priceBox_customTpl) {
            $this->Template->setName($this->ct_priceBox_customTpl);
        }

        $this->Template->price = $this->ct_price;
        $this->Template->priceLabel = $this->ct_priceLabel;
        $this->Template->link1 = $this->ct_priceBox_link1;
        $this->Template->link2 = $this->ct_priceBox_link2;
        $this->Template->linkText1 = $this->ct_priceBox_linkText1;
        $this->Template->linkText2 = $this->ct_priceBox_linkText2;
        $this->Template->popularBox = $this->ct_popularPriceBox;
    }
}
