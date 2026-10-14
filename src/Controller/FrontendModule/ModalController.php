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
namespace ContaoThemesNet\ThemeComponentsBundle\Migration;
namespace ContaoThemesNet\ThemeComponentsBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A modal dialog with a trigger button. Without a link text, the dialog opens
 * when the page is loaded.
 */
#[AsFrontendModule('ct_modal', category: 'contaoThemesNet', template: 'frontend_module/ct_modal')]
class ModalController extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        // Legacy templates selected in the "customTpl" field (e.g. the former
        // "mod_cthemes_modal_*" templates of the themes) keep their variables
        if (!str_contains($template->getName(), '/')) {
            $template->set('linkText', $model->modal_linkText);
            $template->set('linkClass', $model->modal_linkClass ? ' '.$model->modal_linkClass : '');
            $template->set('modalClass', $model->modal_class ? ' '.$model->modal_class : '');
            $template->set('text', StringUtil::encodeEmail((string) $model->modal_text));

            return $template->getResponse();
        }

        $template->set('dialog_id', 'ct-modal-'.$model->id);
        $template->set('link_text', $model->modal_linkText ?: '');
        $template->set('link_class', $model->modal_linkClass ?: '');
        $template->set('modal_class', $model->modal_class ?: '');
        $template->set('text', $model->modal_text ?: '');

        return $template->getResponse();
    }
}
