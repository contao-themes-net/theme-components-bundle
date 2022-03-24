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

use Contao\Backend;

$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_contentBox'] = '{type_legend},type,headline;{text_legend},text;{ct_contentBox_settings},ct_contentBox_page,target,ct_contentBox_pageText,ct_contentBox_pageTitle;{template_legend:hide},ct_contentBox_customTpl;{expert_legend:hide},cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop;';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_featureElement'] = '{type_legend},type,headline;{text_legend},text,ct_featureIcon,ct_iconLink,target;{template_legend:hide},ct_featureElement_customTpl;{expert_legend:hide},guests,cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop;';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_priceBox'] = '{type_legend},type,headline;{text_legend},text,ct_price,ct_priceLabel,ct_priceBox_link1,ct_priceBox_linkText1,ct_priceBox_link2,ct_priceBox_linkText2,ct_popularPriceBox;{template_legend:hide},ct_priceBox_customTpl;{expert_legend:hide},guests,cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_teaserBox'] = '{type_legend},type,headline;{text_legend},text;{ct_teaserBox_settings},ct_teaserBox_page,target,ct_teaserBox_pageText,ct_teaserBox_pageTitle;{image_legend},addImage;{template_legend:hide},ct_teaserBox_customTpl;{expert_legend:hide},cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop;';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_wrapperStart'] = '{type_legend},type,ct_wrapper_name;{expert_legend:hide},guests,cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_wrapperStop'] = '{type_legend},type;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_sliderElement'] = '{type_legend},type,headline,ct_sliderElement_subHeadline;{text_legend},text,ct_sliderElement_page,ct_sliderElement_target,ct_sliderElement_linkText;{image_legend},addImage;{video_legend},ct_sliderElement_playerSRC;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop;';

/*
 * Add fields to tl_content
 */

/* Content Box */
$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_page'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_page'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['target'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['target'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_pageText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_pageText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['ct_ContentBox_pageText'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_pageTitle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_pageTitle'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_pageTitle'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_customTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_ct', 'getContentBoxTemplates'],
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

/* Feature Element */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_featureIcon'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_featureIcon'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_iconLink'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_iconLink'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50 clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_featureElement_customTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_featureElement_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_ct', 'getFeatureElementTemplates'],
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

/* Price Box */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_price'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_price'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceLabel'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceLabel'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(50) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_link1'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_link1'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50 clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_linkText1'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_linkText1'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_link2'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_link2'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50 clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_linkText2'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_linkText2'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_popularPriceBox'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_popularPriceBox'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "varchar(50) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_customTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_ct', 'getPriceBoxTemplates'],
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

/* Teaserbox */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_page'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_page'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_pageText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_pageText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_pageTitle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_pageTitle'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_customTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_ct', 'getTeaserBoxTemplates'],
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

/* Wrapper */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_wrapper_name'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_wrapper_name'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => 'text NULL',
];

/* Slider Element */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_sliderElement_page'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_sliderElement_page'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_sliderElement_linkText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_sliderElement_linkText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_sliderElement_target'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_sliderElement_target'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_sliderElement_subHeadline'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_sliderElement_subHeadline'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_sliderElement_playerSRC'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_sliderElement_playerSRC'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['tl_class' => 'w50', 'fieldType' => 'radio', 'files' => true],
    'sql' => 'blob NULL',
];

class tl_content_ct extends Backend
{
    /**
     * Return all content element templates as array.
     *
     * @return array
     */
    public function getContentBoxTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_cthemes_contentbox');
    }

    public function getFeatureElementTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_cthemes_feature_element');
    }

    public function getPriceBoxTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_cthemes_pricebox');
    }

    public function getTeaserBoxTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_cthemes_teaserbox');
    }
}
