<?php

declare(strict_types=1);

namespace ContaoThemesNet\ThemeComponentsBundle\Controller\FrontendModule;

use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Input;
use Contao\ModuleBreadcrumb;
use Contao\ModuleModel;
use Contao\StringUtil;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsFrontendModule('breadcrumb', 'navigationMenu', 'mod_breadcrumb', priority: 1)]
class BreadcrumbController extends ModuleBreadcrumb
{
    private static array $models = [];

    /**
     * The head bag of the page, kept for the deferred rendering: when the
     * placeholders are replaced, the response context has already been
     * finalized, but the head bag object still holds the final page title
     * (e.g. the title of a news article set by the reader module).
     */
    private static HtmlHeadBag|null $htmlHeadBag = null;

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
            self::$htmlHeadBag = $this->getHtmlHeadBag();

            return new Response('[[render_breadcrumb::' . $model->id . ']]');
        }

        return new Response($this->generate());
    }

    /**
     * Replaces the placeholders with the rendered breadcrumb once the whole page
     * has been generated. A response listener works for both the legacy page
     * layouts (fe_page) and the modern Twig layouts, which do not trigger the
     * modifyFrontendPage hook.
     */
    #[AsEventListener(KernelEvents::RESPONSE, priority: 256)]
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest() || !self::$models || !$this->scopeMatcher->isFrontendRequest($event->getRequest())) {
            return;
        }

        $response = $event->getResponse();

        if ($response instanceof StreamedResponse || !\is_string($content = $response->getContent())) {
            return;
        }

        if (!preg_match_all('/\[\[render_breadcrumb::([0-9]+)\]\]/', $content, $matches)) {
            return;
        }

        foreach (array_unique($matches[1]) as $id) {
            $rendered = Controller::getFrontendModule(self::$models[$id] ?? $id);

            $content = str_replace(\sprintf('[[render_breadcrumb::%s]]', $id), $rendered, $content);
        }

        $response->setContent($content);

        self::$models = [];
        self::$htmlHeadBag = null;
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

        $htmlHeadBag = $this->getHtmlHeadBag() ?? self::$htmlHeadBag;

        if (!$htmlHeadBag?->getTitle()) {
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

    private function getHtmlHeadBag(): HtmlHeadBag|null
    {
        $responseContext = $this->responseContextAccessor->getResponseContext();

        if (!$responseContext?->has(HtmlHeadBag::class)) {
            return null;
        }

        return $responseContext->get(HtmlHeadBag::class);
    }
}
