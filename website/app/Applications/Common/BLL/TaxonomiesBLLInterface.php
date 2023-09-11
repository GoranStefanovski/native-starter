<?php

namespace App\Applications\Common\BLL;

use Illuminate\Http\Request;

/**
 * Interface TaxonomiesBLLInterface
 * @package App\Applications\Common
 */

interface TaxonomiesBLLInterface
{
    /**
     * @param string $type
     *
     * @return array
     */
    public function newTaxonomy($type);

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
    * @return mixed[]|null
    */
    public function getLocationTypes();

}
