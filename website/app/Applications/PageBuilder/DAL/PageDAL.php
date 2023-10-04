<?php

namespace App\Applications\PageBuilder\DAL;

use App\Applications\PageBuilder\Model\Page;

class PageDAL implements PageDALInterface
{
    public function __construct(){}

    public function savePage($data)
    {
        // Convert the $data array to JSON and save it
        $page = new Page();
        $page->title = $data['title'];
        $page->slug = $data['slug'];
        $page->body = json_encode($data['body']);
        $page->save();
    }

    public function getPage($id): ?Page
    {
        return Page::find($id);
    }

    public function getPageBySlug($slug): ?Page
    {
        return Page::where('slug', $slug)->first();
    }

    public function getPagesTable()
    {
        return Page::simplePaginate(10);
    }
}
