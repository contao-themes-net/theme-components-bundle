<?php

declare(strict_types=1);

/*
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2026 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    LGPL-3.0+
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Insert the mate theme category
if (!isset($GLOBALS['TL_CTE']['contaoThemesNet']))
{
    $GLOBALS['TL_CTE']['contaoThemesNet'] = [];
}

/*
 * The content elements and frontend modules are registered as fragment
 * controllers, see src/Controller/ContentElement and src/Controller/FrontendModule
 */
