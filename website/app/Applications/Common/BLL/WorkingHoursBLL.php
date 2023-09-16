<?php

namespace App\Applications\Common\BLL;
use App\Applications\Common\BLL\WorkingHoursBLLInterface;
use App\Applications\Common\Model\WorkingHours;
use Illuminate\Support\Facades\DB;

/**
 * @property WorkingHours $workingHours
 */
class WorkingHoursBLL implements WorkingHoursBLLInterface
{

    public function __construct(
        WorkingHours $workingHours,
    ){
        $this->workingHours = $workingHours;
    }

    

    public function saveWorkingHours($request, $id){
        
        $input['location_id'] = $id;
        $input['monday_start'] = $request['monday_start'];
        $input['monday_end'] = $request['monday_end'];
        $input['tuesday_start'] = $request['tuesday_start'];
        $input['tuesday_end'] = $request['tuesday_end'];
        $input['wednesday_start'] = $request['wednesday_start'];
        $input['wednesday_end'] = $request['wednesday_end'];
        $input['thursday_start'] = $request['thursday_start'];
        $input['thursday_end'] = $request['thursday_end'];
        $input['friday_start'] = $request['friday_start'];
        $input['friday_end'] = $request['friday_end'];
        $input['saturday_start'] = $request['saturday_start'];
        $input['saturday_end'] = $request['saturday_end'];
        $input['sunday_start'] = $request['sunday_start'];
        $input['sunday_end'] = $request['sunday_end'];

        $input['open_24'] = $request['open_24'];

        $working_hours_old = DB::table('working_hours')->where('location_id', $id)->first();
        if ($working_hours_old) {
            $this->workingHours->update($input);
        } else {
            $this->workingHours->create($input);
        }
    }

    public function getWorkingHours($id){
        $working_hours = DB::table('working_hours')->where('location_id', $id)->first();
        return $working_hours;
    }

}
