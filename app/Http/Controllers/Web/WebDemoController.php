<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;

class WebDemoController extends Controller
{
    public function index()
    {
        return "This is WebDemo";
    }

    public function form()
    {
        $html = <<<eof
<html>
        <head>
            <meta charset="utf-8">
            <title></title>
        </head>

        <body>
            <form action="/api/uploadFile" method="post" enctype="multipart/form-data">
                <label for="file">文件名：</label>
                <input type="file" name="file" id="file"><br>
                <input type="submit" name="submit" value="提交">
            </form>
            <img name=codeimg src="/api/showCode">
        </body>

</html>
eof;
        return response($html);

    }


}
