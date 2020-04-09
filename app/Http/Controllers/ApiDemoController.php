<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDemoController extends Controller
{
    public function index()
    {
        return
            [
                'this is api demo'
            ];
    }

    public function rgps()
    {
        return [
            $_REQUEST,
            $_SERVER,
        ];
    }


    public function cookieLook()
    {
        setcookie("TestCookie",'testCookie '.date('Y-m-d H:i:s'));
        return $_COOKIE;
    }

    public function showCode()
    {
        $image = new VerificationCode(80, 20); //将类实例化为对象 

        $image->show(); //调用函数 

        // 如不适用下述方法返回，请使用die，否则header会被重置
        return response('', 200, ['content-type' => 'image/png']);
    }


    public function uploadFile()
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
        if (
            in_array($_FILES["file"]["type"], [
                "image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"
            ])
            && ($_FILES["file"]["size"] < 2048000)   // 小于 200 kb
            && in_array(strtolower($extension), $allowedExts)
        ) {
            if ($_FILES["file"]["error"] > 0) {
                return response([
                    "错误：: " . $_FILES["file"]["error"]
                ]);
            } else {
                if (is_dir(storage_path('upload')) || mkdir(storage_path('upload'))) {
                }
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
}




class VerificationCode
{ //创建类名为TestCode 

    private $width;

    private $height;

    private $str;

    private $im;

    private $strColor;

    function __construct($width, $height)
    {

        $this->width = $width;

        $this->height = $height;

        $this->str = '1231';

        $this->createImage();
    }

    function createImage()
    {

        $this->im = imagecreate($this->width, $this->height); //创建画布 

        imagecolorallocate($this->im, 200, 200, 200); //为画布添加颜色 

        for ($i = 0; $i < 4; $i++) { //循环输出四个数字 

            $this->strColor = imagecolorallocate($this->im, rand(0, 100), rand(0, 100), rand(0, 100));

            imagestring(
                $this->im,
                rand(3, 5),
                (string) ($this->width / 4 * $i + rand(5, 10)),
                (string) rand(2, 5),
                $this->str[$i],
                $this->strColor
            );
        }

        for ($i = 0; $i < 200; $i++) { //循环输出200个像素点 

            $this->strColor = imagecolorallocate($this->im, rand(0, 255), rand(0, 255), rand(0, 255));

            imagesetpixel($this->im, rand(0, $this->width), rand(0, $this->height), $this->strColor);
        }
    }

    function show()
    {
        header('content-type:image/png'); //定义输出为图像类型 

        imagepng($this->im); //生成图像 

        imagedestroy($this->im); //销毁图像释放内存 
    }
}
