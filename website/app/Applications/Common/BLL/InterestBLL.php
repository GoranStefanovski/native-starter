<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\Model\Post;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\LocationTypes;
use App\Applications\Common\Model\MusicTypes;
use App\Applications\User\Model\UserInterests;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * @property MediaDALInterface $mediaDAL
 * @property Post $post
 * @property LocationTypes $locationTypes
 * @property MusicTypes $musicTypes
 * @property UserInterests $userInterests
 */
class InterestBLL implements InterestBLLInterface
{

    public function __construct(
        MediaDALInterface $mediaDAL,
        Post $post,
        LocationTypes $locationTypes,
        MusicTypes $musicTypes,
        UserInterests $userInterests
    ){
        $this->mediaDAL = $mediaDAL;
        $this->post = $post;
        $this->locationTypes = $locationTypes;
        $this->musicTypes = $musicTypes;
        $this->userInterests = $userInterests;
    }

}
