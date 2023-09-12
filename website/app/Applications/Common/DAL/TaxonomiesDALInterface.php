<?php

namespace App\Applications\Common\DAL;

use App\Applications\Common\Model\Parameter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface TaxonomiesDALInterface
 * @package App\Applications\Common
 */

interface TaxonomiesDALInterface
{


    public function updateTaxonomyById($type, $id, $data_array);

    public function newTaxonomy($type, $data_array);

    /**
     * @param string $type
     * @param integer $id
     *
     * @return Model
     */
    public function getTaxonomy($type, $id);

    /**
     * @param string $type
     * @param integer $id
     *
     * @return integer
     */
    public function deleteTaxonomy($type, $id);

    /**
     * @param string $type
     * @param integer $id
     *
     * @return integer
     */
    public function restoreTaxonomy($type, $id);


    /**
     * @return array
     */
    public function getCountries();

    
    /**
     * @return Model
     */
    public function getLocationTypes();

        /**
     * @return Model
     */
    public function getMusicTypes();

}
