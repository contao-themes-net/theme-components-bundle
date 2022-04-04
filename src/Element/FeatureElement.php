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

use Contao\ContentElement;

class FeatureElement extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_feature_element';

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        if ('' !== $this->ct_featureElement_customTpl) {
            $this->Template->setName($this->ct_featureElement_customTpl);
        }

        $this->Template->featureIcon = $this->ct_featureIcon;
        $this->Template->iconLink = $this->ct_iconLink;

        // overwrite link target
        $this->Template->target = '';
        $this->Template->rel = '';

        if ($this->target) {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }
    }
}
