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
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\Image\Studio\Figure;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\Validator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Shared helpers for the content elements of the theme components bundle.
 *
 * The elements only provide the markup and a minimal base styling. The themes
 * add their individual styles on top of it or provide template variants.
 */
abstract class AbstractThemeElementController extends AbstractContentElementController
{
    public function __construct(
        protected readonly Studio $studio,
        protected readonly InsertTagParser $insertTagParser,
    ) {
    }

    /**
     * Builds the attributes of a link like the core "hyperlink" element does.
     */
    protected function createLinkAttributes(Request $request, string|null $url, string|null $title = null, bool $newWindow = false): HtmlAttributes|null
    {
        $href = $this->insertTagParser->replaceInline((string) $url);

        if ('' === $href) {
            return null;
        }

        if (Validator::isRelativeUrl($href)) {
            $href = $request->getBasePath().'/'.$href;
        }

        $attributes = (new HtmlAttributes())
            ->set('href', $href)
            ->setIfExists('title', $this->insertTagParser->replaceInline((string) $title))
        ;

        if ($newWindow) {
            $attributes
                ->set('target', '_blank')
                ->set('rel', 'noreferrer noopener')
            ;
        }

        return $attributes;
    }

    /**
     * Builds the figure of the "addImage" fields like the core "text" element
     * does. Without a lightbox, the image can optionally be linked.
     */
    protected function createFigure(ContentModel $model, HtmlAttributes|null $linkAttributes = null): Figure|null
    {
        if (!$model->addImage || !$model->singleSRC) {
            return null;
        }

        $figureBuilder = $this->studio
            ->createFigureBuilder()
            ->fromUuid($model->singleSRC)
            ->setSize($model->size)
            ->setOverwriteMetadata($model->getOverwriteMetadata())
            ->enableLightbox((bool) $model->fullsize)
        ;

        if (null !== $linkAttributes && !$model->fullsize) {
            $figureBuilder->setLinkAttributes($linkAttributes);
        }

        return $figureBuilder->buildIfResourceExists();
    }
}
