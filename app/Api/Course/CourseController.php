<?php

namespace App\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::orderBy('id', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Course::create($request->all());
        return $this->message('课程添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return $this->message('课程更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->message('删除成功');
    }

//    返回课程名称和标题
    public function getCourseNameAndTitle()
    {
        $courses = Course::all();
        $data = [];
        foreach ($courses as $course) {
            $data[] = [
                'label' => $course->title,
                'value' => $course->id,
            ];
        }
        return $data;
    }

    //    获取老师的课程
    public function getTeacherCourses(Teacher $teacher)
    {
        $courses= $teacher->courses;
        $data = [];
        foreach ($courses as $course) {
            $data[] = [
                'label' => $course->title,
                'value' => $course->id,
            ];
        }
        return $data;
    }
}
