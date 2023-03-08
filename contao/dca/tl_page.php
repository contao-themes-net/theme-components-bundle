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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 *  apply new field for the root page
 */
PaletteManipulator::create()
    // create a new legend after tabnav_legend
    ->addLegend('wcag_legend', 'publish_legend', PaletteManipulator::POSITION_BEFORE)
    // apply the new fields
    ->addField('enable_high_contrast', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('enable_text_size', 'wcag_legend', PaletteManipulator::POSITION_APPEND)
    // register the palette for the root page
    ->applyToPalette('rootfallback', 'tl_page')
;

/*
 * Add fields to tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['enable_high_contrast'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['enable_high_contrast'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => true],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['enable_text_size'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['enable_text_size'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql'  => ['type' => 'boolean', 'default' => true],
];
