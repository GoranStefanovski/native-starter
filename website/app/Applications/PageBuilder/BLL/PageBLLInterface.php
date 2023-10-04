<?php

namespace App\Applications\PageBuilder\BLL;

use App\Applications\PageBuilder\Model\Page;
use Illuminate\Http\Request;

interface PageBLLInterface
{
    /**
     * Get a page by ID.
     *
     * @param int $id
     * @return array
     */
    public function getPage(int $id): ?array;

    /**
     * Get a page by slug.
     *
     * @param string $slug
     * @return array
     */
    public function getPageBySlug(string $slug): ?Page;

    public function getPagesTable();
}
