<?php

/**
 * Add palette to tl_content
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['ct_modal'] = '{title_legend},name,type;{modal_link_legend},modal_linkText,modal_linkClass;{modal_headline_legend},headline;{modal_text_legend},modal_text,modal_class;{template_legend:hide},modal_customTpl;{expert_legend:hide},cssID,space';

/**
 * Add fields to tl_module
 */

/* Modal */

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_linkText'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_linkText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_linkClass'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_linkClass'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_text'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_text'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => array('rte'=>'tinyMCE'),
    'sql' => "TEXT NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_customTpl'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_module_cthemes', 'getModalTemplates'),
    'eval' => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_class'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_class'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
);

class tl_module_cthemes extends Backend {
    /**
     * Return all content element templates as array
     *
     * @param DataContainer $dc
     *
     * @return array
     */

    public function getModalTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('mod_cthemes_modal');
    }
}