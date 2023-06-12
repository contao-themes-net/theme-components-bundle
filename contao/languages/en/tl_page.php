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

$GLOBALS['TL_LANG']['tl_page']['wcag_legend'] = 'WCAG-Settings (Web Content Accessibility Guidelines)';

$GLOBALS['TL_LANG']['tl_page']['enable_high_contrast'] = ['Allow switching to high contrast mode', 'Allows switching to the high contrast mode. This option is enabled by default.'];
$GLOBALS['TL_LANG']['tl_page']['enable_font_size'] = ['Allow display of the icon for changing the font size', 'Allows to display the icon for changing the font size. This function is implemented here by linking to a page with information about changing the font size. The font size itself is not changed.'];
$GLOBALS['TL_LANG']['tl_page']['enable_font_size_switcher'] = ['Allow display of font size toggle (-A A A+) for changing font size', 'Allows showing the font size toggle for changing the font size. This function directly changes the font size.'];
$GLOBALS['TL_LANG']['tl_page']['font_size_comment_page'] = ['Select here the page on which you carry out your explanations of the font size', 'Since all modern browsers support resizing text on their own, this feature should no longer be implemented through Javascript or stylesheets. Instead, it is easier to provide information about changing the font size on a separate page.'];
