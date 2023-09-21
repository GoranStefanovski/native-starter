<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\Model\Location;
use App\Applications\Common\Model\Event;
use Illuminate\Support\Facades\Auth;

/**
 * @property Location $location
 */

 /**
 * @property Event $event
 */

class LikeBLL implements LikeBLLInterface
{

    public function __construct(
        Location $location,
        Event $event
    ){
        $this->location = $location;
        $this->event = $event;
    }


    public function likeLocation(Location $location)
    {
        Auth::user()->likes()->create([
            'likable_id' => $location->id,
            'likable_type' => get_class($location),
        ]);

        return redirect()->back();
    }

    public function unlikeLocation(Location $location)
    {
        Auth::user()->likes()->where([
            'likable_id' => $location->id,
            'likable_type' => get_class($location),
        ])->delete();

        return redirect()->back();
    }

    public function likeEvent(Event $event)
    {
        Auth::user()->likes()->create([
            'likable_id' => $event->id,
            'likable_type' => get_class($event),
        ]);

        return redirect()->back();
    }

    public function unlikeEvent(Event $event)
    {
        Auth::user()->likes()->where([
            'likable_id' => $event->id,
            'likable_type' => get_class($event),
        ])->delete();

        return redirect()->back();
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
