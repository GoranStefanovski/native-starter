<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\Post;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property Post $post
 */
class PostBLL implements PostBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        Post $post
    ){
        $this->mediaDAL = $mediaDAL;
        $this->post = $post;
    }

    private const COLUMNS_MAP = [
        'id' => 'posts.id',
        'title' => 'posts.title',
        'description' => 'posts.description',
        'rating' => 'posts.rating',
        'user_id' => 'posts.user_id',
        'country_id' => 'posts.country_id',
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllPosts()
    {
//        dd($this->post->all());
        $data['records'] =$this->post->all();
        $data['draw'] = 2;
        return $data;
//        return Post::all();
        // TODO: Implement getAllPosts() method.
    }


    public function getPostById($id){
//        dd($this->post->find($id));
        return $this->post::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicPosts()
    {
        return $this->post->all();
    }

    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function savePost($request){
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['country_id'] = $request['country_id'];
        $input['country'] = \Countries::find($request['country_id'])->name;
        $input['user_id'] = Auth::user()->id;
        $input['city_id'] = $request['city_id'];
        $input['city'] = $request['city']['name'];
        $post = $this->post->create($input);
        $this->mediaDAL->save($request,$post,'post_image');

    }
    public function editPost($request,$id){
        $post_data = $request->all();
//        dd($post_data);
        $post = $this->post->find($id);
        $this->mediaDAL->save($request,$post,'post_image');
        return $post->update($post_data);
    }
    public function deletePost($id){
        return $this->post
            ->where('id', $id)
            ->delete();
    }

    public function getDataTablesReadyPublic($data){
        // TODO: Refactor this segment
        $query = DB::table('posts')
            ->select(
                DB::raw('posts.id as id'),
                DB::raw('posts.title as title'),
                DB::raw('posts.description as description'),
                DB::raw('posts.country_id as country_id'),
                DB::raw('posts.rating as rating'),
                DB::raw('posts.user_id as user_id'),
                DB::raw('posts.city as city'),
                DB::raw('countries.name as country_name')
            )
            ->join('countries', 'countries.id', '=', 'posts.country_id');

        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('posts.title', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.description', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.rating', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.user_id', 'like', '%'.$search.'%');
                $subquery->orWhere('countries.full_name', 'like', '%'.$search.'%');
            });
        }
//        if(isset($data['source']) && $data['source'] != '' && $data['source'] != 'all'){
//            $query->where('users.source','=',$data['source']);
//        }

        $query->whereNull('posts.deleted_at');

        $query->groupBy('posts.id');
        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $paginator = $query->paginate($data['length']);
//        dd($this->prepareDatatablesData($paginator, $data));
        return $this->prepareDatatablesData($paginator, $data);
    }


    function prepareDatatablesData($paginator, $data){
        $last_page = $paginator->lastPage();
        $limit = $paginator->perPage();
        $current_page = $paginator->currentPage();
        $total = $paginator->total();
        $pagination = [
            'lastPage' => $last_page,
            'currentPage' => $current_page,
            'total' => $total,
            'dataLength' => $limit,
            'options' => $paginator->getOptions(),
        ];

        return [
            'data' => $paginator,
            'records' => $paginator->items(),
            'pagination' => $pagination,
            'draw' => $data['draw']
        ];
    }
}
