<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Fundy-新規会員登録</title>
        <link rel="stylesheet" href="Fundyregistry.css">
    </head>
    <body>
        <h1>
            Fundy 新規会員登録
        </h1>
        <?php

        // パスワードの二重チェック
            if (!empty($_POST["user_name"]) && !empty($_POST["password"])) {
                if ($_POST["password"] != $_POST["passwordConfirm"]) {
                    echo "パスワードが一致しません";
                } else {
                    $db = "mysql:host=localhost;dbname=project;charset=utf8mb4";
                    $username = "odawara";
                    $password = "ebetyun";

                    try {
                        $pdo = new PDO($db, $username, $password);

                        // ユーザー名の重複チェック
                        $stmt = $pdo->prepare("SELECT * FROM user WHERE user_name = :user_name;");
                        $stmt->bindValue(":user_name", $_POST["user_name"], PDO::PARAM_STR);
                        $stmt->execute();

                        if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                            echo "そのユーザー名は使われています";
                        } else {
                            $pw = password_hash($_POST["password"], PASSWORD_DEFAULT);

                            // 新しいユーザーを挿入
                            $stmt = $pdo->prepare("
                                INSERT INTO user (user_name, password)
                                VALUES (:user_name, :password);
                            ");
                            $stmt->bindValue(":user_name", $_POST["user_name"], PDO::PARAM_STR);
                            $stmt->bindValue(":password", $pw, PDO::PARAM_STR);
                            $stmt->execute();

                            header("Location: ./login.php");
                            exit;
                        }
                    } catch (PDOException $e) {
                        echo "データベース接続エラー: " . $e->getMessage();
                        exit;
                    }
                }
            }
        ?>

        <!-- 新規登録の入力フォーム -->
        <form action="" method="POST">
            <table class="registry">
                <tr>
                    <td>ユーザー名</td>
                    <td><input type="text" name="user_name" required></td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td>パスワード(確認用)</td>
                    <td><input type="password" name="passwordConfirm" required></td>
                </tr>
            </table>
            <div class="registry">
                <input type="submit" class="registry" value="登録">
            </div>
        </form>
    </body>
</html>
