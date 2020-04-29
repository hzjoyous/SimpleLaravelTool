<?php


namespace App\Http\Controllers;



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
                (string)($this->width / 4 * $i + rand(5, 10)),
                (string)rand(2, 5),
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
