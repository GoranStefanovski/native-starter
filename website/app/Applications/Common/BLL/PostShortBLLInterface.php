<?php
namespace App\Applications\Common\BLL;
use Illuminate\Http\Request;

interface PostShortBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllLocations();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function savePost($request);

    public function savePostStatus($request, $id);

    public function editPost($id, $request);

    public function deletePost($id);

    public function getPublicShortPosts($request);

    public function getShortPostData($data);

}
