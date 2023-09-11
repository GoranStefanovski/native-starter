<?php

namespace App\Applications\Common\BLL;

use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Common\DAL\TaxonomiesDALInterface;
use Illuminate\Http\Request;


/**
 * @property TaxonomiesDALInterface $taxonomiesDAL
 * @property MediaDALInterface $mediaDAL
 */
class TaxonomiesBLL implements TaxonomiesBLLInterface
{


    public function __construct(
        TaxonomiesDALInterface $taxonomiesDAL,
        MediaDALInterface $mediaDAL
    ){
        $this->taxonomiesDAL = $taxonomiesDAL;
        $this->mediaDAL = $mediaDAL;
    }


    public function newTaxonomy($type){
        return $this->taxonomiesDAL->newTaxonomy($type)->toJson();
    }

    public function deleteTaxonomy($type, $id){
        return $this->taxonomiesDAL->deleteTaxonomy($type, $id);
    }

    public function restoreTaxonomy($type, $id){
        return $this->taxonomiesDAL->restoreTaxonomy($type, $id);
    }

    public function getCountries(){
        return $this->taxonomiesDAL->getCountries()/*->toJson()*/;
    }

    public function getLocationTypes(){
        return $this->taxonomiesDAL->getLocationTypes()/*->toJson()*/;
    }
}
