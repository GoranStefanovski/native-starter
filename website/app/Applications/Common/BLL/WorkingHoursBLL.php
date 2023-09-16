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
        $input['monday_working'] = $request['monday_working'];
        $input['tuesday_start'] = $request['tuesday_start'];
        $input['tuesday_end'] = $request['tuesday_end'];
        $input['tuesday_working'] = $request['tuesday_working'];
        $input['wednesday_start'] = $request['wednesday_start'];
        $input['wednesday_end'] = $request['wednesday_end'];
        $input['wednesday_working'] = $request['wednesday_working'];
        $input['thursday_start'] = $request['thursday_start'];
        $input['thursday_end'] = $request['thursday_end'];
        $input['thursday_working'] = $request['thursday_working'];
        $input['friday_start'] = $request['friday_start'];
        $input['friday_end'] = $request['friday_end'];
        $input['friday_working'] = $request['friday_working'];
        $input['saturday_start'] = $request['saturday_start'];
        $input['saturday_end'] = $request['saturday_end'];
        $input['saturday_working'] = $request['saturday_working'];
        $input['sunday_start'] = $request['sunday_start'];
        $input['sunday_end'] = $request['sunday_end'];
        $input['sunday_working'] = $request['sunday_working'];

        $input['always_open'] = $request['always_open'];

        $working_hours_old = DB::table('working_hours')->where('location_id', $id)->first();
        if ($working_hours_old) {
            $this_hours = $this->workingHours->find($working_hours_old->id);
            $this_hours->update($input);
        } else {
            $this->workingHours->create($input);
        }
    }

    public function getWorkingHours($id){
        $working_hours = DB::table('working_hours')->where('location_id', $id)->first();
        return $working_hours;
    }

}
