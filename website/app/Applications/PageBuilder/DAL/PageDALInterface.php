<?php

namespace App\Applications\PageBuilder\DAL;

use App\Applications\PageBuilder\Model\Page;

/**
 * Interface PageDALInterface
 */

interface PageDALInterface
{
    public function savePage($data);
    public function getPage($id): ?Page;
    public function getPagesTable();
    public function getPageBySlug($slug): ?Page;
}
