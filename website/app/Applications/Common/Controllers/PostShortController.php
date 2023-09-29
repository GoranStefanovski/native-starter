<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\PostShortBLLInterface;
use App\Applications\Common\Requests\ShortsPostRequest;

/**
 * @property PostShortBLLInterface $shortPostBLL
 */
class PostShortController extends Controller
{
    public function __construct(
        PostShortBLLInterface $shortPostBLL
    ){
        $this->shortPostBLL = $shortPostBLL;
    }

    public function index(){

        return $this->shortPostBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->shortPostBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allPosts(Request $request){
        // dd($this->shortPost->getAllPosts());
        return $this->shortPostBLL->getShortPostData($request);
    }

    public function allShortPostsPublic(Request $request){
        // dd($this->shortPost->getAllPosts());
        return $this->shortPostBLL->getPublicShortPosts($request);
    }

    public function getPostById($id){
        return $this->shortPostBLL->getPostById($id);
    }
    public function savePost(ShortsPostRequest $request){
        return $this->shortPostBLL->savePost($request);
    }
    public function savePostStatus(Request $request, $id){
        return $this->shortPostBLL->savePostStatus($request, $id);
    }
    public function editPost(ShortsPostRequest $request, $id){
        return $this->shortPostBLL->editPost($request,$id);
    }

    public function deletePost($id){
        return $this->shortPostBLL->deletePost($id);
    }

}
