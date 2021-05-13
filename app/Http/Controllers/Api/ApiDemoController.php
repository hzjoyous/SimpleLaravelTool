<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiDemoController extends Controller
{

    public function index(Request $request)
    {
        return $this->simpleResponse('This is ApiDemo');
    }

    public function showRequest(Request $request): array
    {
        return $this->simpleResponse(
            $_REQUEST,
            $_SERVER,
            (array)json_decode($request->getContent(), true)
        );
    }


    public function cookieLook(): array
    {
        setcookie("TestCookie", 'testCookie ' . date('Y-m-d H:i:s'));
        return $this->simpleResponse($_COOKIE);
    }

    public function showCode()
    {
        $image = new VerificationCode(80, 20); //将类实例化为对象

        $image->show(); //调用函数

        // 如不适用下述方法返回，请使用die，否则header会被重置
        return response('', 200, ['content-type' => 'image/png']);
    }


    public function upload()
    {
        $allowedFileTypes = array("gif", "jpeg", "jpg", "png");
        $temp             = explode(".", $_FILES["file"]["name"]);
        $extension        = end($temp);     // 获取文件后缀名
        if (
            in_array($_FILES["file"]["type"], [
                "image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"
            ])
            && ($_FILES["file"]["size"] < 2048000)   // 小于 200 kb
            && in_array(strtolower($extension), $allowedFileTypes)
        ) {
            if ($_FILES["file"]["error"] > 0) {
                return response([
                    "错误：: " . $_FILES["file"]["error"]
                ]);
            } else {
                is_dir(storage_path('upload')) || mkdir(storage_path('upload'));
                move_uploaded_file($_FILES["file"]["tmp_name"], storage_path("upload") . DIRECTORY_SEPARATOR . date('YMDhis') . $_FILES["file"]["name"]);
                return response([
                    "上传文件名: " . $_FILES["file"]["name"] . "<br>",
                    "文件类型: " . $_FILES["file"]["type"] . "<br>",
                    "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>",
                    "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>",
                    "文件存储在: " . "upload" . DIRECTORY_SEPARATOR . $_FILES["file"]["name"]
                ]);
            }
        } else {
            return response([
                "非法的文件格式"
            ]);
        }
    }

    public function originalUploadFile()
    {
        foreach ($_FILES as $file){
            if (in_array($file["type"]??'', [
                "text/csv"
            ])) {
                if ($file["error"]??'' > 0) {
                    return response([
                        "错误：: " . $_FILES["file"]["error"]
                    ]);
                } else {
                    is_dir(storage_path('upload')) || mkdir(storage_path('upload'));
                    $newFilePath =  storage_path("upload") . DIRECTORY_SEPARATOR . date('YMDhis') . $file["name"];
                    move_uploaded_file($file["tmp_name"],$newFilePath);
                    if (($handle = fopen($newFilePath, "r")) !== FALSE) {
                        fgetcsv($handle, 1000, ",");
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            dump($data);
                        }
                    }
                }
            }
        }

        return  1;

    }

    public function uploadFile(Request $request)
    {
        $files = $request->files;

        foreach ($files as $file) {
            /* @var $file UploadedFile */
            //$tmpFilePath = $file->getPath(). DIRECTORY_SEPARATOR.$file->getFilename();
            dump($file);
            $fileName = $file->getFilename();

            //$extension = $file->getClientOriginalExtension();
            //$newFileName  = md5(time() . rand(1, 1000)) . '.' . $extension;
            $fileDir  = storage_path('tmp' . DIRECTORY_SEPARATOR);
            $filePath = $fileDir . $fileName;
            $file->move($fileDir, $fileName);

            if (($handle = fopen($filePath, "r")) !== FALSE) {
                fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    dump($data);
                }
            }
        }
    }

}

