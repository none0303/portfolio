<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Fundy-ログイン画面</title>
        <link rel="stylesheet" href="FundyUI.css">
    </head>
    <body>
        <h1>Fundy ログイン画面</h1>

        <!-- データベースにアクセスしてログイン時にパスワード、ユーザー名に違うものがないか確認する、ちがったらはじく -->
        <?php
            if (!empty($_POST["user_name"]) && !empty($_POST["password"])) {
                $db = "mysql:host=localhost;dbname=project;charset=utf8mb4";
                $username = "odawara";
                $password = "ebetyun";

                try {
                    $pdo = new PDO($db, $username, $password);

                    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_name = :user_name;");
                    $stmt->bindValue(":user_name", $_POST["user_name"], PDO::PARAM_STR);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!empty($row["user_name"])) {
                        if (password_verify($_POST["password"], $row["password"])) {
                            session_regenerate_id(true);
                            $_SESSION["user_id"] = $row["user_id"]; // user_id をセッションに保存
                            $_SESSION["user_name"] = $row["user_name"];
                            header("Location: ./FunDyHome.php");
                            exit;
                        } else {
                            echo "パスワードが間違っています";
                        }
                    } else {
                        echo "ユーザー名が間違っています";
                    }
                } catch (PDOException $e) {
                    echo "データベース接続エラー: " . $e->getMessage();
                    exit;
                }
            }
        ?>

        <!-- ログイン時の入力フォーム -->
        <form action="" method="POST">
            <table class="login">
                <tr>
                    <td>ユーザー名</td>
                    <td><input type="text" name="user_name" required></td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password" required></td>
                </tr>
            </table>
            <div class="login">
                <input type="submit" class="login" value="ログイン">
            </div>
        </form>
        <div class="newlog">
            <form action="registry.php" method="post">
                <button type="submit" class="newlog" value="新規登録画面">はじめましての方はこちら</button>
            </form>
        </div>
    </body>
</html>
