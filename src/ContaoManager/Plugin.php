<?php
/**
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    pdir contao theme licence
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoThemesNet\ThemeComponentsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use ContaoThemesNet\ThemeComponentsBundle\ThemeComponentsBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoDD\AdvancedClassesBundle\ContaoDDAdvancedClassesBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Philipp Seibt <develop@pdir.de>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ThemeComponentsBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    ContaoDDAdvancedClassesBundle::class
                ]),
        ];
    }
}