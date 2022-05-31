<?php

namespace App\Api\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use UploadService;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['uploadToAliCloud', 'uploadLocal']);
    }

    public function getAvatar(Attachment $attachment)
    {
        $attachmentsource = UploadService::saveMultiavatarFile();

        $attachment->fill($attachmentsource)->save();

        return $this->message('保存成功', ['attachment' => $attachment]);
    }

    public function getAvatarUrl(Request $request)
    {
        $attachment = Attachment::find($request->id);
        return $attachment->path;
    }

    public function delAvatar(Request $request)
    {
        $attachment = Attachment::find($request->id);
        $path = public_path() . '\\attachments' . '\\' . $attachment->name;
        if (unlink($path)) {
            $attachment->delete();
            return $this->message('删除成功');
        } else {
            return $this->error('删除失败，未找到文件');
        }
    }

    public function uploadToAliCloud(Request $request)
    {
        $res = UploadService::oss($request->file);
        return $res;
    }

    public function uploadLocal(Request $request)
    {
        $res = UploadService::local($request->file);
        return $res;
    }

//    wangEditor上传
    public function wangUploadCloud(Request $request)
    {
        $res= UploadService::wangEditor($request->file('wangeditor-uploaded-image'));
        return ['errno'=>0,'data'=>['url'=>$res->path]];
    }
}
