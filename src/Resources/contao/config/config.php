<?php

use ContaoThemesNet\ThemeComponentsBundle\Element\ContentBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\FeatureElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\PriceBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\SliderElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\TeaserBoxElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\WrapperStartElement;
use ContaoThemesNet\ThemeComponentsBundle\Element\WrapperStopElement;
use ContaoThemesNet\ThemeComponentsBundle\Module\ModalModule;

// Insert the mate theme category
array_insert($GLOBALS['TL_CTE'], 1, array('contaoThemesNet' => array()));

/**
 * Add content element
 */
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_contentBox'] = ContentBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_featureElement'] = FeatureElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_priceBox'] = PriceBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_sliderElement'] = SliderElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_teaserBox'] = TeaserBoxElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_wrapperStart'] = WrapperStartElement::class;
$GLOBALS['TL_CTE']['contaoThemesNet']['ct_wrapperStop'] = WrapperStopElement::class;

/**
 * Add modules
 */

$GLOBALS['FE_MOD']['contaoThemesNet']['ct_modal'] = ModalModule::class;

/**
 * Wrapper elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'ct_wrapperStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'ct_wrapperStop';