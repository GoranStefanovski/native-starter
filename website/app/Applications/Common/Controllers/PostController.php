<?php

namespace App\Applications\Common\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\Common\BLL\PostBLLInterface;
use App\Applications\Common\Requests\PostRequest;

/**
 * @property PostBLLInterface $postBLL
 */
class PostController extends Controller
{
    public function __construct(
        PostBLLInterface $postBLL
    ){
        $this->postBLL = $postBLL;
    }

    public function index(){

        return $this->postBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->postBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allPosts(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->postBLL->getDataTablesReadyPublic($request);
    }

    public function allPostsPublic(Request $request){
        // dd($this->postBLL->getAllPosts());
        return $this->postBLL->getPublicPosts($request);
    }

    public function getPostById($id){
        return $this->postBLL->getPostById($id);
    }
    public function savePost(PostRequest $request){
//         dd($request->all());
//        dd($request);
        return $this->postBLL->savePost($request);
    }
    public function editPost(PostRequest $request, $id){
        return $this->postBLL->editPost($request,$id);
    }
    public function deletePost($id){
        return $this->postBLL->deletePost($id);
    }
}
