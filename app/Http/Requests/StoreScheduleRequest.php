<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Schedule;
class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $canStore= $this->overlap();
        if($canStore){
            return true;
        }else{
            response()->json(['message' => '时间冲突'], 422);
        }
    }


    public function overlap(){
        $start = request()->start_time;
        $end = request()->end_time;
        $id = request()->id;
//        请求时间段不与已存在的时间段重叠
        $schedule = Schedule::where('start_time','<=',$end)
            ->where('end_time','>=',$start)
            ->where('id','!=',$id)
            ->get();
        if(count($schedule) > 0){
            return false;
        }
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
