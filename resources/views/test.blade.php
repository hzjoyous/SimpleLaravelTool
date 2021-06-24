<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>


</head>
<body>
<div id="app">
    <button onclick="buttonClick()" style="width: 300px;height: 200px">调试按钮调试按钮调试按钮</button>

    <button onclick="fButtonClick()" style="width: 300px;height: 200px">不进行判断直接调用</button>
    <br>
    <button onclick="f2ButtonClick()" style="width: 300px;height: 200px">直接调用weidengluToken</button>
</div>
</body>
<script>
    function buttonClick() {
        let androidTokenType = typeof androidToken
        let msg = '开始尝试调用androidToken,check typeof androidToken:' + androidTokenType + "\n";
        if (androidTokenType !== 'undefined') {
            let androidTokenWeidengluTokenTypeof = typeof androidToken.weidengluToken
            if (androidTokenWeidengluTokenTypeof !== 'undefined') {
                androidToken.weidengluToken("abcdefghijklmnopqistuvwxyz1234567890")
            }
            msg += ' androidTokenWeidengluTokenTypeof:' + androidTokenType
        }
        alert(msg);
    }

    function fButtonClick() {
        androidToken.weidengluToken("abcdefghijklmnopqistuvwxyz1234567890")
    }

    function f2ButtonClick() {
        window.webkit.messageHandlers.weidengluToken.postMessage('hello');


        // weidengluToken("abcdefghijklmnopqistuvwxyz1234567890")

    }
</script>
</html>
