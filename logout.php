<?php
    session_start();
    $_SESSION = array();
    if (!empty($_COOKIE[session_name()])){
        setcookie(session_name(), "", time()-42000, "/");
    }
    session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
    <hrad>
        <meta charset="utf-8">
        <title>Fundy-ログアウト画面</title>
        <link rel="stylesheet" href="FundyUI.css">
    </head>
    <body>
        <h1>Fundy ログアウト画面</h1>
        <p>ログアウトしました。</p>
        <p><a href="login.php">やっぱり勉強したい！！！</a></p>
    </body>
</html>
