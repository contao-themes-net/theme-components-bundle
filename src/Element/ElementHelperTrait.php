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

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

use Contao\BackendTemplate;
use Contao\StringUtil;

trait ElementHelperTrait
{
    /**
     * Display a wildcard in the back end.
     */
    public function generate(): string
    {
        if (TL_MODE === 'BE') {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->text = StringUtil::toHtml5($this->text);

            return $objTemplate->parse();
        }

        return parent::generate();
    }
}
