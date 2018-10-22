<?php

namespace ContaoThemesNet\ThemeComponentsBundle\Element;

class FeatureElement extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_cthemes_feature_element';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->featureIcon = $this->ct_featureIcon;
        $this->Template->iconLink = $this->ct_iconLink;
    }
}
