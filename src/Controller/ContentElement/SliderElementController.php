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
use Contao\CoreBundle\Filesystem\VirtualFilesystemInterface;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

#[AsContentElement('ct_sliderElement', category: 'contaoThemesNet', template: 'content_element/ct_slider_element')]
class SliderElementController extends AbstractThemeElementController
{
    public function __construct(
        Studio $studio,
        InsertTagParser $insertTagParser,
        #[Autowire(service: 'contao.filesystem.virtual.files')]
        private readonly VirtualFilesystemInterface $filesStorage,
    ) {
        parent::__construct($studio, $insertTagParser);
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $image = $this->createFigure($model);

        $template->set('image', $image);
        $template->set('video', null === $image ? $this->getVideo($model) : null);
        $template->set('subheadline', $model->ct_sliderElement_subHeadline ?: '');
        $template->set('text', $model->text ?: '');
        $template->set('page_link', $this->createLinkAttributes($request, $model->ct_sliderElement_page, null, (bool) $model->ct_sliderElement_target));
        $template->set('page_link_text', $model->ct_sliderElement_linkText ?: '');

        // The CSS class "only-image" hides the text layer (backwards compatibility)
        $cssClasses = StringUtil::deserialize($model->cssID, true)[1] ?? '';
        $template->set('only_image', \in_array('only-image', explode(' ', (string) $cssClasses), true));

        return $template->getResponse();
    }

    /**
     * @return array{src: string, type: string}|null
     */
    private function getVideo(ContentModel $model): array|null
    {
        if (!$model->ct_sliderElement_playerSRC) {
            return null;
        }

        // Accepts the binary UUID of the database like the core "player" element
        $uuid = Uuid::fromString($model->ct_sliderElement_playerSRC);
        $item = $this->filesStorage->get($uuid);

        if (!$item?->isFile() || !$publicUri = $this->filesStorage->generatePublicUri($uuid)) {
            return null;
        }

        return [
            'src' => (string) $publicUri,
            'type' => $item->getMimeType('video/mp4'),
        ];
    }
}
