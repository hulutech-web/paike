<?php

namespace App\Api\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return ScheduleResource::collection(Schedule::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreScheduleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        $schedule = Schedule::create($request->all());

        return $this->message("添加成功", $schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return $schedule;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateScheduleRequest $request
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->all());
        return $this->message("更新成功", $schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return $this->message("删除成功", $schedule);
    }

    //获取当前老师的课表
    public function getTeacherSchedule(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return $this->error("非老师身份");
        }
        $schedule = Schedule::where('teacher_id', $teacher->id)->get();
        return $schedule;
    }

//仅供渲染组件使用
    public function simpleSchedule(Request $request)
    {
        $schedules = Schedule::where('start_time', '>', $request->start)->where('end_time', '<', $request->end)->get();
//        返回数组
        return collect($schedules)->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->course->title,
                'start' => $item->start_time,
                'end' => $item->end_time,
            ];
        });

    }
//    当前用户对应老师的课表
    public function getUserSchedule(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return $this->error("非老师身份");
        }
        $schedules = Schedule::where('start_time', '>', $request->start)->where('end_time', '<', $request->end)->where('teacher_id', $teacher->id)->get();

        return collect($schedules)->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->course->title,
                'start' => $item->start_time,
                'end' => $item->end_time,
            ];
        });
    }
}
