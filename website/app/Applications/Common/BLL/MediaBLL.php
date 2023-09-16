<?php

namespace App\Applications\Common\BLL;

use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

/**
 * 
 */
class MediaBLL implements MediaBLLInterface
{
    /** @var MediaDALInterface */
    protected $mediaDAL;
    /** @var LocationDALInterface */

    public function __construct(
        MediaDALInterface $mediaDAL,
    ){
        $this->mediaDAL = $mediaDAL;
    }

    public function getById($id){
        return $this->mediaDAL->getById($id);
    }

    public function getEntrySessionPhotos($id){
        return $this->mediaDAL->getBySessionId($id);
    }

    public function delete($id){
        return $this->mediaDAL->delete($id);
    }

    public function editComment($id, $comment){
        return $this->mediaDAL->editComment($id, $comment);
    }

    public function getMedia($request){
        $entity = false;
        // Entity exists
        if ($entity) {
            // Has a media (custom one, not Spatie) relation
            if ($entity->media && class_basename($entity->media) != 'Collection'){
                $entity = $entity->media;     
            } 
        }
        return $entity;
    }

    public function savePhoto($request){
        $collection = 'photos';
        if(!empty($request->get('custom_properties')['type'])){
            $collection = $request->get('custom_properties')['type'];
        }
        $media = $this->getMedia($request);
        return $this->mediaDAL->save($request, $media, $collection);
    }

    public function saveTemporaryPhoto($request){
        $collection = 'photos';
        $session_id = Cookie::get('session_id');
        if (!$session_id) {
            $session_id = Session::getId();
            Cookie::queue(Cookie::make('session_id', $session_id, 30));
        }
        $media = $this->mediaDAL->getBySessionId($session_id);
        return $this->mediaDAL->save($request, $media, $collection);
    }

    public function saveHeaderVideo($media, $request){
        $property_name = 'uploaded_header_video';
        $collection = 'header_video';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveVr360Thumbnail($media, $request){
        $property_name = 'uploaded_vr360_thumbnail';
        $collection = 'vr360_thumbnail';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveHomepageHeaderVideo($media, $request){
        $property_name = 'uploaded_header_video';
        $collection = 'homepage_header_video';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveHomepageHeaderImage($media, $request){
        $property_name = 'uploaded_header_image';
        $collection = 'homepage_header_image';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveHomepageSliderImage($media, $request){
        $property_name = 'uploaded_slider_image';
        $collection = 'homepage_slider_image';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveHomepageBoxImage($media, $request){
        $property_name = 'uploaded_box_image';
        $collection = 'homepage_box_image';
        return $this->mediaDAL->save($request, $media, $collection, $property_name);
    }

    public function saveDocument($request){
        $collection = 'documents';
        $media = $this->getMedia($request);
        return $this->mediaDAL->save($request, $media, $collection);
    }

    public function editPhoto($media, $request){
        $collection = 'photos';
        if(!empty($request->get('custom_properties')['type'])){
            $collection = $request->get('custom_properties')['type'];
        }
        $media_parent = $this->getMedia($request);
        return $this->mediaDAL->edit($request, $media_parent, $media, $collection);
    }

    public function editDocument($media, $request){
        $collection = 'documents';
        $media_parent = $this->getMedia($request);
        return $this->mediaDAL->edit($request, $media_parent, $media, $collection);
    }

    public function getEntityByType($type, $id){
        $entity = false;

        if ($type == 'session') {
            $session_id = Cookie::get('session_id');
            $entity = $this->mediaDAL->getBySessionId($session_id);
        }

        // Entity exists
        if ($entity && class_basename($entity->media) != 'Collection') {
            // Has a basic data relation
            if ($entity->media) $entity = $entity->media;
        }
        return $entity;
    }

    public function upOrderPhoto($id, $entity, $entity_id){
        $entity = $this->getEntityByType($entity, $entity_id);
        return $this->mediaDAL->upOrder($entity, 'photos', $id);
    }

    public function downOrderPhoto($id, $entity, $entity_id){
        $entity = $this->getEntityByType($entity, $entity_id);
        return $this->mediaDAL->downOrder($entity, 'photos', $id);
    }

    public function upOrderDocument($id, $entity, $entity_id){
        $entity = $this->getEntityByType($entity, $entity_id);
        return $this->mediaDAL->upOrder($entity, 'documents', $id);
    }

    public function downOrderDocument($id, $entity, $entity_id){
        $entity = $this->getEntityByType($entity, $entity_id);
        return $this->mediaDAL->downOrder($entity, 'documents', $id);
    }

    public function removeFile($type, $id){
        $media = $this->mediaDAL->getById($id);
        if ($type == "file") $this->mediaDAL->deleteFile($media);
        return $media;
    }

    public function newRteImage($request){
        $imageName = request()->file->getClientOriginalName();

        request()->file->move(public_path('storage/rte'), $imageName);

        return ['name' => $imageName, 'location' => '/storage/rte/'.$imageName];
    }
}



