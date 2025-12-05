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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 *  apply new field for the root page
 */
PaletteManipulator::create()
    // create a new legend after tabnav_legend
    ->addLegend('wcag_legend', 'publish_legend', PaletteManipulator::POSITION_BEFORE)
    // apply the new fields
    ->addField('enable_high_contrast', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('enable_auto_high_contrast', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('enable_font_size', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('enable_font_size_switcher', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('font_size_comment_page', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    // register the palette for the root page
    ->applyToPalette('rootfallback', 'tl_page')
;

/*
 * Add fields to tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['enable_high_contrast'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => true],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['enable_auto_high_contrast'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => false],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['enable_font_size'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => true],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['enable_font_size_switcher'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => true],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['font_size_comment_page'] = [
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => ['multiple'=>false, 'fieldType'=>'radio', 'tl_class' => 'clr'],
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type'=>'hasOne', 'load'=>'lazy')
];
