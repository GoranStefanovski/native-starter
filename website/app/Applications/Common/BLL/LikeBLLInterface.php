<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\Model\Location;
use App\Applications\Common\Model\Event;


interface LikeBLLInterface{

    public function likeLocation(Location $location);

    public function unlikeLocation(Location $location);

    public function likeEvent(Event $event);
    
    public function unlikeEvent(Event $event);

}
