<?php

use App\Api\Attachment\AttachmentController;
use App\Api\Auth\AuthController;
use App\Api\LoginInfo\LoginInfoController;
use App\Api\Menu\MenuController;
use App\Api\SystemConfig\SystemConfigController;
use App\Api\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Api\Teacher\TeacherController;
use App\Api\Course\CourseController;
use App\Api\Classroom\ClassroomController;
use App\Api\Schedule\ScheduleController;
/**
 * 公共部分
 */
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::post('scanQr', [AuthController::class, 'scanQr']);//获取二维码

Route::post('scanLogin', [AuthController::class, 'scanLogin']);//发送二维码登录

Route::get('menus', MenuController::class);
Route::apiResource('user', UserController::class);
Route::post("user/search", [UserController::class, 'search']);

Route::post("getAvatar", [AttachmentController::class, 'getAvatar']);
Route::post("delAvatar", [AttachmentController::class, 'delAvatar']);
//本地上传
Route::post("uploadCloud", [AttachmentController::class, 'uploadLocal']);
Route::post("wangUploadCloud", [AttachmentController::class, 'wangUploadCloud']);


/**
 * 公共部分END
 */

//系统配置
Route::post('systemconfig', [SystemConfigController::class, 'showConfig']);
Route::post('updateSystemConfig', [SystemConfigController::class, 'updateSystemConfig']);
Route::get('logininfo', LoginInfoController::class);

//教师管理
Route::apiResource('teacher', TeacherController::class);
Route::post('teacher/search', [TeacherController::class,'search']);
//课程管理
Route::apiResource('course', CourseController::class);
Route::post('course/list', [CourseController::class, 'getCourseNameAndTitle']);
Route::post("teacher/{teacher}/courses", [CourseController::class, 'getTeacherCourses']);

//教室管理
Route::apiResource('classroom', ClassroomController::class);
Route::post('classroom/search', [ClassroomController::class,'search']);
Route::post('classroom/list', [ClassroomController::class,'list']);
//课表管理
Route::apiResource('schedule', ScheduleController::class);
Route::get('simpleSchedule', [ScheduleController::class, 'simpleSchedule']);
//当前用户的课表
Route::get('userSchedule', [ScheduleController::class, 'getUserSchedule']);