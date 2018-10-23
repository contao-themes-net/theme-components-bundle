<?php

/**
 * Add palette to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_contentBox'] = '{type_legend},type,headline;{text_legend},text;{ct_contentBox_settings},ct_contentBox_page,target,ct_contentBox_pageText;{template_legend:hide},ct_contentBox_customTpl;{expert_legend:hide},cssID;{advanced_classes_legend};space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_featureElement'] = '{type_legend},type,headline;{text_legend},text,ct_featureIcon,ct_iconLink,target;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_priceBox'] = '{type_legend},type,headline;{text_legend},text,ct_price,ct_priceLabel,ct_priceBox_link1,ct_priceBox_linkText1,ct_priceBox_link2,ct_priceBox_linkText2,ct_popularPriceBox;{template_legend:hide},ct_priceBox_customTpl;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_teaserBox'] = '{type_legend},type,headline;{text_legend},text;{ct_teaserBox_settings},ct_teaserBox_page,target,ct_teaserBox_pageText;{image_legend},addImage;{template_legend:hide},ct_teaserBox_customTpl;{expert_legend:hide},cssID;{advanced_classes_legend};space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_wrapperStart'] = '{type_legend},type,ct_wrapper_name;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ct_wrapperStop'] = '{type_legend},type;{invisible_legend:hide},invisible,start,stop';

/**
 * Add fields to tl_content
 */

/* Content Box */
$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_page'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_page'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['target'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['target'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class'=>'w50 m12'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_pageText'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_pageText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['ct_ContentBox_pageText'],
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_contentBox_customTpl'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_contentBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_content_ct', 'getContentBoxTemplates'),
    'eval' => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);

/* Feature Element */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_featureIcon'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_featureIcon'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_iconLink'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_iconLink'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

/* Price Box */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_price'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_price'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceLabel'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceLabel'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_link1'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_link1'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_linkText1'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_linkText1'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_link2'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_link2'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_linkText2'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_linkText2'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_popularPriceBox'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_popularPriceBox'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50 clr'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_priceBox_customTpl'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_priceBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_content_ct', 'getPriceBoxTemplates'),
    'eval' => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);

/* Teaserbox */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_page'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_page'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_pageText'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_pageText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_teaserBox_customTpl'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_teaserBox_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_content_ct', 'getTeaserBoxTemplates'),
    'eval' => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);

/* Wrapper */

$GLOBALS['TL_DCA']['tl_content']['fields']['ct_wrapper_name'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['ct_wrapper_name'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

class tl_content_ct extends Backend {
    /**
     * Return all content element templates as array
     *
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getContentBoxTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_cthemes_contentbox');
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