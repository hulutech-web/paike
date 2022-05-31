<?php

namespace App\Api\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Classroom::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreClassroomRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Classroom::create($request->all());
        return $this->message('教室添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Classroom $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        return $classroom;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateClassroomRequest $request
     * @param \App\Models\Classroom $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        $classroom->update($request->all());
        return $this->message('教室修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Classroom $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return $this->message('教室删除成功');
    }

    public function list(){
        $classrooms = Classroom::all();

        $data = [];
        foreach ($classrooms as $classroom) {
            $data[] = [
                'label' => $classroom->name,
                'value' => $classroom->id,
            ];
        }
        return $data;
    }

//    搜索教室
    public function search(Request $request){
        $keyword = $request->keyword;
        $classrooms = Classroom::where('name','like',"%$keyword%")->get();
        return $classrooms;
    }
}
