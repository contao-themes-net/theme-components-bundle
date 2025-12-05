<?php

declare(strict_types=1);

namespace ContaoThemesNet\ThemeComponentsBundle\Controller\FrontendModule;

use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Input;
use Contao\ModuleBreadcrumb;
use Contao\ModuleModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule('breadcrumb', 'navigationMenu', 'mod_breadcrumb', priority: 1)]
class BreadcrumbController extends ModuleBreadcrumb
{
    private static array $models = [];

    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
        private readonly RequestStack $requestStack,
        private readonly ResponseContextAccessor $responseContextAccessor,
    ) {
    }

    public function __invoke(Request $request, ModuleModel $model, string $section): Response
    {
        parent::__construct($model, $section);

        if ($this->scopeMatcher->isBackendRequest($request)) {
            return new Response($this->generate());
        }

        // Render as placeholder first
        $attributeVar = '_' . $model->type . '_' . $model->id . '_render';
        $mainRequest  = $this->requestStack->getMainRequest();

        if (!$mainRequest->attributes->has($attributeVar)) {
            $mainRequest->attributes->set($attributeVar, true);
            self::$models[$model->id] = $model;

            return new Response('[[render_breadcrumb::' . $model->id . ']]');
        }

        return new Response($this->generate());
    }

    #[AsHook('modifyFrontendPage')]
    public function onModifyFrontendPage(string $buffer, string $template): string
    {
        if (!str_starts_with($template, 'fe_page')) {
            return $buffer;
        }

        $mainRequest = $this->requestStack->getMainRequest();

        // https://github.com/contao/contao/issues/8255
        if ($mainRequest->attributes->has(__METHOD__)) {
            return $buffer;
        }

        $mainRequest->attributes->set(__METHOD__, true);

        if (preg_match_all('/\[\[render_breadcrumb::([0-9]+)\]\]/', $buffer, $matches)) {
            foreach ($matches[1] as $id) {
                $rendered = Controller::getFrontendModule(self::$models[$id] ?? $id);

                $buffer = str_replace(\sprintf('[[render_breadcrumb::%s]]', $id), $rendered, $buffer);
            }
        }

        return $buffer;
    }

    protected function compile(): void
    {
        parent::compile();

        $this->overrideActiveTitle();
    }

    private function overrideActiveTitle(): void
    {
        // Only execute on legacy reader pages
        if (!Input::get('auto_item', false, true)) {
            return;
        }

        if (!$responseContext = $this->responseContextAccessor->getResponseContext()) {
            return;
        }

        if (!$responseContext->has(HtmlHeadBag::class)) {
            return;
        }

        $htmlHeadBag = $responseContext->get(HtmlHeadBag::class);

        if (!$htmlHeadBag->getTitle()) {
            return;
        }

        $items = $this->Template->items;

        if ($key = array_key_last($items)) {
            $items[$key] = array_merge($items[$key], [
                'title' => StringUtil::specialchars($htmlHeadBag->getTitle()),
                'link'  => $htmlHeadBag->getTitle(),
            ]);
        }

        $this->Template->items = $items;
    }
}
