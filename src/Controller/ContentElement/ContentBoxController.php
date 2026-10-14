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

#[AsContentElement('ct_contentBox', category: 'contaoThemesNet', template: 'content_element/ct_content_box')]
class ContentBoxController extends AbstractThemeElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->set('text', $model->text ?: '');
        $template->set('image', $this->createFigure($model));
        $template->set('page_link', $this->createLinkAttributes($request, $model->ct_contentBox_page, $model->ct_contentBox_pageTitle, (bool) $model->target));
        $template->set('page_link_text', $model->ct_contentBox_pageText ?: '');

        return $template->getResponse();
    }
}
