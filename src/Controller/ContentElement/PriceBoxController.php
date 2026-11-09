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
namespace ContaoThemesNet\ThemeComponentsBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement('ct_priceBox', category: 'contaoThemesNet', template: 'content_element/ct_price_box')]
class PriceBoxController extends AbstractThemeElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $links = [];

        foreach ([1, 2] as $i) {
            $text = (string) $model->{'ct_priceBox_linkText'.$i};
            $attributes = $this->createLinkAttributes($request, $model->{'ct_priceBox_link'.$i}, $model->{'ct_priceBox_linkTitle'.$i});

            // Like before, a link is only shown if it has a URL and a text
            if (null !== $attributes && '' !== $text) {
                $links[] = ['attributes' => $attributes, 'text' => $text];
            }
        }

        $template->set('price', $model->ct_price ?: '');
        $template->set('price_label', $model->ct_priceLabel ?: '');
        $template->set('highlight_label', $model->ct_popularPriceBox ?: '');
        $template->set('text', $model->text ?: '');
        $template->set('links', $links);

        return $template->getResponse();
    }
}
