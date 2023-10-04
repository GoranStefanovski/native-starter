<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Applications\PageBuilder\Model\Page;
use App\Applications\PageBuilder\Model\Container;
use App\Applications\PageBuilder\Model\Block;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pageCount = 10; // Number of pages
        $containerCount = 5; // Number of containers per page
        $blockCount = 5; // Number of blocks per container

        for ($i = 1; $i <= $pageCount; $i++) {
            $page = Page::create([
                'title' => "Page $i",
                'slug' => "page-$i",
            ]);

            for ($j = 1; $j <= $containerCount; $j++) {
                $container = $page->containers()->create([
                    'name' => "Container $j"
                ]);

                for ($k = 1; $k <= $blockCount; $k++) {
                    Block::create([
                        'container_id' => $container->id,
                        'content' => "Block $k in Container $j",
                        'component' => "Column"
                    ]);
                }
            }
        }
    }
}
