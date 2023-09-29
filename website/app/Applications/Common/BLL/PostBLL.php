<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\Post;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\LocationTypes;
use App\Applications\Common\Model\MusicTypes;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property Post $post
 * @property LocationTypes $locationTypes
 * @property MusicTypes $musicTypes
 */
class PostBLL implements PostBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        Post $post,
        LocationTypes $locationTypes,
        MusicTypes $musicTypes
    ){
        $this->mediaDAL = $mediaDAL;
        $this->post = $post;
        $this->locationTypes = $locationTypes;
        $this->musicTypes = $musicTypes;
    }

    private const COLUMNS_MAP = [
        'id' => 'posts.id',
        'title' => 'posts.title',
        'description' => 'posts.description',
        'is_active' => 'posts.is_active'
    ];

    public function getScrolldownPosts(Request $request)
    {
        // TODO: Implement getScrolldownPosts() method.
    }

    public function getAllLocations()
    {
        $data['records'] =$this->post->all();
        $data['draw'] = 2;
        return $data;
    }


    public function getPostById($id){
        return $this->post::find($id);
    }

    public function getPostByIdNonAuth($id)
    {
        // TODO: Implement getPostByIdNonAuth() method.
    }

    public function getPublicLocations($request)
    {
        $currentDate = now()->toDateString();

        $query = DB::table('posts')
        ->select(
            DB::raw('posts.id as id'),
            DB::raw('posts.title as title'),
            DB::raw('posts.description as description'),
            DB::raw('posts.location_types as location_types'),
            DB::raw('posts.music_types as music_types'),
            DB::raw('posts.image as image'),
            DB::raw('posts.contact_person_email_second as contact_person_email_second')
        );
        
        $interest = $request['interest'];
        if($interest){
            $query->where(function($subquery) use ($interest) {
                $subquery->where('posts.location_types', 'like', '%'.$interest.'%');
                $subquery->orWhere('posts.music_types', 'like', '%'.$interest.'%');
            });
        }

        $query->whereNull('posts.deleted_at');
        $query->where('posts.is_active',1);
        $query->whereDate('posts.start_active_date', '<=', $currentDate);
        $query->whereDate('posts.end_active_date', '>=', $currentDate);
        
        return $query->get();
    }


    public function getPostsByUser()
    {
        // TODO: Implement getPostsByUser() method.
    }

    public function savePost($request){
        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['user_id'] = Auth::user()->id;
        $input['event_id'] = $request['event_id'];
        $input['location_id'] = $request['location_id'];
        $input['artist_id'] = $request['artist_id'];
        $input['location_types'] = json_encode($request->input('location_types'));
        $input['music_types'] = json_encode($request->input('music_types'));
        $post = $this->post->create($input);
        $this->mediaDAL->save($request,$post,'blog_post_image');
    }

    public function savePostStatus($request, $id){
        $input['is_active'] = $request['is_active'];
        $input['start_active_date'] = $request['start_active_date'];
        $input['end_active_date'] = $request['end_active_date'];

        $post = $this->post->find($id);
        return $post->update($input);
    }

    public function editPost($request,$id){
        $input = $request->all();
//        dd($post_data);
        $post = $this->post->find($id);
        $this->mediaDAL->save($request,$post,'blog_post_image');
        return $post->update($input);
    }

    public function deletePost($id){
        return $this->post
            ->where('id', $id)
            ->delete();
    }

    public function getLocationsData($data){
        // TODO: Refactor this segment
        $query = DB::table('posts')
            ->select(
                DB::raw('posts.id as id'),
                DB::raw('posts.title as title'),
                DB::raw('posts.description as description'),
                DB::raw('posts.user_id as user_id'),
                DB::raw('posts.is_active as is_active'),
                DB::raw('posts.location_types as location_types'),
                DB::raw('posts.music_types as music_types'),
            );
        $search = $data['search'];
        if($search){
            $query->where(function($subquery) use ($search) {
                $subquery->where('posts.title', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.description', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.location_types', 'like', '%'.$search.'%');
                $subquery->orWhere('posts.music_types', 'like', '%'.$search.'%');
            });
        }

        $query->whereNull('posts.deleted_at');
        $query->groupBy('posts.id');
        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $paginator = $query->paginate($data['length']);
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
