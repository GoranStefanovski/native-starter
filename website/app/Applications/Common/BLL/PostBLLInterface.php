<?php
namespace App\Applications\Common\BLL;
use Illuminate\Http\Request;

interface PostBLLInterface{

    public function getScrolldownPosts(Request $request);

    public function getAllPosts();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser();

    public function savePost($request);

    public function editPost($id, $request);

    public function deletePost($id);

    public function getPublicPosts();

    /**
     * @param array $data
     * @return array
     */
    public function getDataTablesReadyPublic($data);

}
