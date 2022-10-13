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
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_module']['palettes']['ct_modal'] = '{title_legend},name,type;{modal_link_legend},modal_linkText,modal_linkClass;{modal_headline_legend},headline;{modal_text_legend},modal_text,modal_class;{template_legend:hide},modal_customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

/*
 * Add fields to tl_module
 */

/* Modal */

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_linkText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_linkText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_linkClass'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_linkClass'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_text'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_text'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => ['rte' => 'tinyMCE'],
    'sql' => 'TEXT NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_customTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_customTpl'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_module_cthemes', 'getModalTemplates'],
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['modal_class'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['modal_class'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

class tl_module_cthemes extends Backend
{
    /**
     * Return all content element templates as array.
     *
     * @return array
     */
    public function getModalTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('mod_cthemes_modal');
    }
}
