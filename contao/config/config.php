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

use ContaoThemesNet\ThemeComponentsBundle\Element\ContentBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\FeatureElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\PriceBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\SliderElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\TeaserBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\WrapperStartElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\WrapperStopElement;
use ContaoThemesNet\ThemeComponentsBundle\Module\ModalModule;

// Insert the mate theme category
if (!isset($GLOBALS['TL_CTE']['contaoThemesNet']))
{
    $GLOBALS['TL_CTE']['contaoThemesNet'] = [];
}

/*
 * Add content element
 */
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_contentBox'] = ContentBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_featureElement'] = FeatureElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_priceBox'] = PriceBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_sliderElement'] = SliderElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_teaserBox'] = TeaserBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_wrapperStart'] = WrapperStartElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_wrapperStop'] = WrapperStopElement::class;

/*
 * Add modules
 */

$GLOBALS['FE_MOD']['contaoThemesNet']['ct_modal'] = ModalModule::class;

/*
 * Wrapper elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'ct_wrapperStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'ct_wrapperStop';
