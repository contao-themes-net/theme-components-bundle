<?php

namespace ContaoThemesNet\ThemeComponentsBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement()]
class FeatureSectionController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->text = $model->text;
        $template->variant = $model->fsVariant;
        $template->bgColor = $model->fsBgColor;
        $template->color = $model->fsColor;

        if ($model->fsLogo) {
            $template->logo = $model->fsLogo;
            $template->logoSize = $model->fsLogoSize;
        }

        if ($model->fsBgLeft) {
            $template->bgLeft = $model->fsBgLeft;
            $template->bgLeftSize = $model->fsBgLeftSize;
        }

        if ($model->fsBgRight) {
            $template->bgRight = $model->fsBgRight;
            $template->bgRightSize = $model->fsBgRightSize;
        }

        if ($model->fsGallery) {
            $uuids = StringUtil::deserialize($model->fsGallery, true);
            $template->gallery = $uuids;
            $template->gallerySize = $model->fsGallerySize;
        }

        $inlineStyle = [];
        if ($model->fsBgColor) {
            $inlineStyle[] = '--fs-bg-color: ' . $model->fsBgColor;
        }
        if ($model->fsColor) {
            $inlineStyle[] = '--fs-color: ' . $model->fsColor;
        }
        if ($model->fsColorHeadline) {
            $inlineStyle[] = '--fs-headline-color: ' . $model->fsColorHeadline;
        }
        $template->inlineStyle = 'style="' . implode(';', $inlineStyle) . '"';

        $GLOBALS['TL_CSS'][] = 'bundles/themecomponents/scss/feature_section.scss|static';
        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/themecomponents/js/feature_section.js|static';

        return $template->getResponse();
    }
}
