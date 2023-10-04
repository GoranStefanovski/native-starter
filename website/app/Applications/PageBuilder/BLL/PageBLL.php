<?php

namespace App\Applications\PageBuilder\BLL;

use App\Applications\PageBuilder\DAL\PageDALInterface;
use App\Applications\PageBuilder\Model\Page;
use App\Applications\PageBuilder\Transformers\PageTransformer;

class PageBLL implements PageBLLInterface
{
    protected $pageDAL;

    public function __construct(PageDALInterface $pageDAL)
    {
        $this->pageDAL = $pageDAL;
    }

    public function getPage(int $id): ?array
    {
        $page = $this->pageDAL->getPage($id);

        if ($page) {
            return PageTransformer::transformPageForCMS($page);
        }

        return null;
    }

    public function getPageBySlug(string $slug): ?Page
    {
        return $this->pageDAL->getPageBySlug($slug);
    }

    public function getPagesTable()
    {
        return $this->pageDAL->getPagesTable();
    }
}
