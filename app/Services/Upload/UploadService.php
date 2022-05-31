<?php

namespace App\Services\Upload;

use App\Models\Attachment;
use Auth;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Multiavatar;
use OSS\Core\OssException;
use OSS\OssClient;

/**
 * 文件上传
 * @package App\Services
 */
class UploadService
{

    public function saveMultiavatarFile()
    {
        $multiavatar = new Multiavatar();
        $svgCode = $multiavatar(mt_rand(), null, null);
        $originpath = '/attachments/avatar/Multiavatar' . mt_rand() . '.svg';

        $saveurl = public_path($originpath);

        file_put_contents($saveurl, $svgCode);

        $path = url($originpath);
        $name = pathinfo($saveurl, PATHINFO_BASENAME);
        $extension = pathinfo($saveurl, PATHINFO_EXTENSION);
        $type = 'multiavatar';//方式
        $user_id = Auth::id() ? Auth::id() : null;
        $size = filesize($saveurl);
        $data = ['path' => $path, 'name' => $name, 'extension' => $extension, 'type' => $type, 'user_id' => $user_id, 'size' => $size];
        $this->inputDatabase($type, $data);

        return $data;
    }

    /**
     * 入库
     * @param $type
     * @param $data
     */

    protected function inputDatabase($type, $data)
    {
        if ($type == 'multiavatar') {
            $attactment = new Attachment();
            $attactment->fill($data)->save();
        }
    }

    public function wangEditor($file)
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store(date('Ym'), 'attachment');
            return $this->save(url("/attachments/{$path}"), $file->getsize(), $file->getClientOriginalName(), $file->extension(), 'local');
//             返回wangEditor格式
        } else if (is_file($file)) {
            $info = pathinfo($file);
            $to = 'attachments' . date('Ym') . '/user_id_' . Auth::id() . date('his') . '.' . $info['extension'];
            copy($file, public_path($to));
            return $this->save(url($to), filesize($file), basename($to), $info['extension'], 'local');
        }
    }

    /**
     * 保存入库
     * @param mixed $path 文件链接
     * @param mixed $size 文件大小
     * @param mixed $name 源文件名
     * @param string|null $type 上传方式
     * @return Attachment
     */
    protected function save($path, $size, $name = null, $extension = null, string $type = null): Attachment
    {
        return Attachment::create([
            'path' => $path,
            'user_id' => Auth::id(),
            'size' => $size,
            'type' => $type,
            'name' => $name,
            'extension' => $extension
        ]);
    }

    /**
     * 本地上传
     * @param UploadedFile $file
     * @return Attachment
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function local($file)
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store(date('Ym'), 'attachment');
            return $this->save(url("/attachments/{$path}"), $file->getsize(), $file->getClientOriginalName(), $file->extension(), 'local');
        } else if (is_file($file)) {
            $info = pathinfo($file);
            $to = 'attachments/' . date('Ym') . '/user_id_' . Auth::id() . date('his') . '.' . $info['extension'];
            copy($file, public_path($to));
            return $this->save(url($to), filesize($file), basename($to), $info['extension'], 'local');
        }
    }

    /**
     * 阿里云OSS
     * @param UploadedFile | String $file
     * @return Attachment
     */
    public function oss($file): Attachment
    {
        if ($file instanceof UploadedFile) {
            $info = $this->ossUpload($file->path(), $file->extension());
            return $this->save($info['oss-request-url'], $file->getSize(), $file->getClientOriginalName(), $file->extension(), 'oss');
        } else if (is_file($file)) {
            $info = pathinfo($file);
            $oss = $this->ossUpload($file, $info['extension']);
            return $this->save($oss['oss-request-url'], filesize($file), $info['basename'], $info['extension'], 'oss');
        }
    }

    /**
     * OSS上传文件
     * @param mixed $file
     * @param mixed $extension
     * @return null
     * @throws BindingResolutionException
     * @throws OssException
     */
    protected function ossUpload($file, $extension)
    {
        $object = Auth::id() . '-' . date('Ymdhis') . '.' . $extension;
        $ossClient = new OssClient(config('system.aliyun.oss.AccessKeyId'), config('system.aliyun.oss.AccessKeySecret'), config('system.aliyun.oss.Endpoint'));
        return $ossClient->uploadFile(config('system.aliyun.oss.BucketName'), $object, $file);
    }

}
