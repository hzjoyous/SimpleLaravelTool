<?php


namespace App\Http\Controllers\Api;


class VerificationCode
{

    private int $width;

    private int $height;

    private string $str;

    /**
     * @var resource
     */
    private $im;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;

        $this->height = $height;

        $this->str = '1231';

        $this->createImage();
    }

    public function createImage()
    {

        $this->im = imagecreate($this->width, $this->height); //创建画布

        imagecolorallocate($this->im, 200, 200, 200); //为画布添加颜色

        for ($i = 0; $i < 4; $i++) { //循环输出四个数字

            $strColor = imagecolorallocate($this->im, rand(0, 100), rand(0, 100), rand(0, 100));

            imagestring(
                $this->im,
                rand(3, 5),
                (string)($this->width / 4 * $i + rand(5, 10)),
                (string)rand(2, 5),
                $this->str[$i],
                $strColor
            );
        }

        for ($i = 0; $i < 200; $i++) { //循环输出200个像素点

            $strColor = imagecolorallocate($this->im, rand(0, 255), rand(0, 255), rand(0, 255));

            imagesetpixel($this->im, rand(0, $this->width), rand(0, $this->height), $strColor);
        }
    }

    public function show()
    {
        header('content-type:image/png'); //定义输出为图像类型

        imagepng($this->im); //生成图像

        imagedestroy($this->im); //销毁图像释放内存
    }
}
