<?php
namespace App\Applications\Common\BLL;


interface WorkingHoursBLLInterface {

    public function saveWorkingHours($request, $id);

    public function getWorkingHours($id);
}
