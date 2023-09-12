<?php

namespace App\Applications\Common\DAL;

use App\Applications\Common\DAL\TaxonomiesDALInterface;
use App\Applications\Common\Model\Location;
//use App\Applications\Common\Model\Format;
//use App\Applications\Common\Model\Color;
//use App\Applications\Common\Model\Handle;
//use App\Applications\Common\Model\Lamination;
//use App\Applications\Common\Model\Paper;
use Illuminate\Support\Facades\DB;
use Webpatser\Countries\Countries;
use App\Applications\Common\Model\LocationTypes;

/*INSERT NEW IMPORTS HERE*/


/**
 * @property Countries countries
 */

 /**
 * @property LocationTypes locationTypes
 */

class TaxonomiesDAL implements TaxonomiesDALInterface
{

    public function __construct(

        Countries $countries,
        LocationTypes $locationTypes

    ){

        $this->countries = $countries;
        $this->locationTypes = $locationTypes;
		/*SET DEPENDENCY HERE*/
    }

    /*INSERT NEW CONFIGURATOR OPTIONS HERE*/

    public function updateTaxonomyById($type, $id, $data_array){
        return $this->{$type}
                    ->where('id', $id)
                    ->withTrashed()
                    ->update($data_array);
    }

    public function newTaxonomy($type, $data_array){
        $order = $this->{$type}->max('order')+1;
        $data_array['order'] = $order;
        return $this->{$type}
                    ->create($data_array);
    }

    public function getTaxonomy($type, $id){
        return $this->{$type}
                    ->where('id', $id)
                    ->withTrashed()
                    ->first();
    }

    public function deleteTaxonomy($type, $id){
        return $this->{$type}
                    ->where('id', $id)
                    ->delete();
    }

    public function restoreTaxonomy($type, $id){
        return $this->{$type}
                    ->where('id', $id)
                    ->restore();
    }


    public function getCountries(){
        return $this->countries->getList();
    }

    public function getLocationTypes() {
        return $this->locationTypes->whereNull('location_types.deleted_at')->get();
    }

}
