<?php

declare(strict_types=1);

namespace ContaoThemesNet\ThemeComponentsBundle\Listener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Environment;
use Contao\PageModel;

#[AsHook('replaceInsertTags', priority: 100)]
class ReplaceInsertTagsListener
{
    // for components
    public const TAG = 'comp';

    /**
     * Replace the icon insert tag.
     */
    public function __invoke($tag)
    {
        $chunks = explode('::', $tag);

        if (self::TAG !== $chunks[0]) return false;

        switch($chunks[1]) {
            case 'contrast': $tag = $this->generateContrastTag($chunks); break;
            case 'size':     $tag = $this->generateSizeTag($chunks); break;
            default:
                // invalid tag
                return false;
        }

        return $tag;
    }

    private function generateContrastTag(array $chunks): string
    {
        $html = 'contrast';

        $name = 'test';
        $classes = 'text';
        $style = '';

        $tag = "<img src='bundles/contaothemesnetbootstrapiconsinserttag/img/bootstrap/{$name}.svg' class='{$classes}'$style alt='$name'>";

        return $html;
    }

    private function generateSizeTag(array $chunks): string
    {
        $html = 'size';

        $targetPage = PageModel::findOneByAlias($chunks[2]);

        if($targetPage) {
            $html .= Environment::get('requestUri');
        } else {
            $html = 'alias nicht gefunden';
        }

        return $html;
    }
}
