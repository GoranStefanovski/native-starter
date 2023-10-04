<?php

namespace App\Applications\PageBuilder\Controllers;

use App\Http\Controllers\Controller;
use App\Applications\PageBuilder\BLL\PageBLLInterface;
use App\Applications\PageBuilder\DAL\PageDALInterface;
use App\Applications\PageBuilder\Requests\StorePageRequest;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    protected $pageBLL;

    public function __construct(PageBLLInterface $pageBLL)
    {
        $this->pageBLL = $pageBLL;
    }

    public function show($slug)
    {
        $page = $this->pageBLL->getPageBySlug($slug);

        if ($page === null) {
            return response()->json(['error' => 'Page not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(["result" => "ok", "data" => $page], Response::HTTP_OK);
    }

    public function store(StorePageRequest $request, PageDALInterface $pageDAL)
    {
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug
        ];

        $pageDAL->savePage($data);

        return response()->json(["result" => "ok"], 201);
    }

    public function draw()
    {
        $pages = $this->pageBLL->getPagesTable();

        return response()->json($pages, Response::HTTP_OK);
    }

    public function getPageById($id)
    {
        $page = $this->pageBLL->getPage($id);

        if ($page) {
            return response()->json($page, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Page not found'], Response::HTTP_NOT_FOUND);
        }
    }
}

?>
