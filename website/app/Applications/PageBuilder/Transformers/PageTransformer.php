<?php
    namespace App\Applications\PageBuilder\Transformers;

    use App\Applications\PageBuilder\Model\Page;

    class PageTransformer
    {
        public static function transformPageForCMS(Page $page): array
        {
            $containers = [];
            $blocks = [];

            foreach ($page->containers as $container) {
                $containerData = [
                    'id' => $container->id,
                    'name' => $container->name,
                    'blocks' => []
                ];

                foreach ($container->blocks as $block) {
                    $containerData['blocks'][] = $block->id;
                    $blocks[$block->id] = $block;
                }

                $containers[] = $containerData;
            }

            return [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'body' => [
                    'containers' => $containers,
                    'blocks' => $blocks,
                ]
            ];
        }
    }
