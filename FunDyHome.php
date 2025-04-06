<!-- セッションを管理する部分、ログインしてなかったら蹴るし、長い間つけっぱならタイムアウトする -->
<?php
    ini_set("session.gc_maxlifetime", 300);
    ini_set("session.gc_probability", 1);
    ini_set("session.gc_divisor", 1);
    session_start();
    if (!isset($_SESSION["user_id"])) {
        echo "ログインが必要です。";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="FunDyHome.css">
<!-- 変数rabdoNumを宣言して30%、30%、60%の確率でそれぞれのページに遷移するようになってる、Math.rabdom();はよくわからん -->
<!-- function=関数、redirectRandom()が関数の名前か -->
        <script>
        function redirectRandom() {
            const randomNum = Math.random();
            if (randomNum <= 0.3) {
                location.href = 'notest.php';
            } else if (randomNum <= 0.6) {
                location.href = 'notest2.php';
            }
             else {
                location.href = 'notest3.php'; 
            }
        }
    </script>
    </head>
    <body>
        <!-- データベースの内容とかを取得するところ -->
        <?php
         $db = "mysql:host=localhost;dbname=s2312067;charset=utf8mb4";
         $username = "s2312067";
         $password = "4heBRAvlB5fU";
         try {
            $pdo = new PDO($db, $username, $password);

            // 投稿処理
            if (!empty($_POST["newcotent"]) && !empty($_POST["tag"]) && !empty($_POST["url"])) {
                $stmt = $pdo->prepare("INSERT INTO post (user_id, title, tag, url)
                                       VALUES (:user_id, :title, :tag, :url);");
                $stmt->bindValue(":user_id", $_SESSION["user_id"], PDO::PARAM_INT);
                $stmt->bindValue(":title", $_POST["newcotent"], PDO::PARAM_STR);
                $stmt->bindValue(":tag", $_POST["tag"], PDO::PARAM_STR);
                $stmt->bindValue(":url", $_POST["url"], PDO::PARAM_STR);
                $stmt->execute();
            }

            // 投稿リスト取得
            $stmt = $pdo->prepare('SELECT * FROM post 
                                   JOIN user
                                   ON post.user_id = user.user_id;');
            $stmt->execute();

             $searchResults = [];
        if (!empty($_GET["search_tag"])) {
            $searchTag = $_GET["search_tag"];
            $stmt = $pdo->prepare("SELECT * FROM post
                                   JOIN user
                                   ON post.user_id = user.user_id
                                   WHERE tag LIKE :tag;");
            $stmt->bindValue(":tag", "%" . $searchTag . "%", PDO::PARAM_STR);
            $stmt->execute();
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        } catch (PDOException $e) {
            echo "データベース接続エラー: " . $e->getMessage();
            exit;
        }
        ?>

        
        <div class="title"><h1> FunDy </h1></div>

        <!-- ログアウトするボタン(本当はちゃんとログアウトって書いた方がいい) -->
        <button onclick="location.href='logout.php'" class="giveup">勉強をあきらめる</button>
        
        <form id="form1" method="get" action="FunDyHome.php">
        <form method="get">
        <label for="search_tag">
        <input type="text" name="search_tag" id="sbox1" placeholder="#タグ名">
        </label>
        <input id="sbtn1" type="submit" value="検索" />
    </form>

    <!-- 投稿の内容を入力する部分 -->
        <div id="test">イベントテスト微分積分<br> 
                       2/3 15:00~23:00</div>
    <button onclick="redirectRandom()" id="testpage">テストはまだだよ</button>
        <div id="post">
            <h4>学習動画を共有</h4>
            <form action="" method="POST">
                <input type="text" name="tag" placeholder="#タグを入力(タグはひとつまで、10文字以内)" size="60">
                <p><input type="text" name="newcotent" placeholder="タイトルを入力してください(20文字まで)" size="60"></p>
                <p><input type="text" name="url" placeholder="共有したい教材のURLを記載してください" size="60"></p>
                <div class="test">
                    <p><button type="submit" class="btn">送信</button></p>
                </div>
            </form>
        </div>

        <!-- データベースの内容を参照して投稿を表示する   -->
        <table id="postlist"> 
        <tr>
                <th>称号</th>
                <th>ユーザーネーム</th>
                <th>タグ</th>
                <th>タイトル</th>
                <th>URL</th> 
            </tr>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["label"], ENT_QUOTES, "UTF-8") . "</td>";
                echo "<td>" . htmlspecialchars($row["user_name"], ENT_QUOTES, "UTF-8") . "</td>";
                echo "<td>" . htmlspecialchars($row["tag"], ENT_QUOTES, "UTF-8") . "</td>";
                echo "<td>" . htmlspecialchars($row["title"], ENT_QUOTES, "UTF-8") . "</td>";
                echo "<td><a href='" . htmlspecialchars($row["url"], ENT_QUOTES, "UTF-8") . "' target='_blank'>Let's FunDy!!!</a></td>";
                echo "</tr>";
            }
            ?>
            
            <!-- 投稿を表示する部分の中身部分 -->
            <?php if (!empty($_GET["search_tag"])): ?>
                <?php if (!empty($searchResults)): ?>
                    <?php foreach ($searchResults as $post): ?>
                <tr>
                <td><?= htmlspecialchars($post["label"]) ?></td>
                <td><?= htmlspecialchars($post["user_name"]) ?></td>
                <td><?= htmlspecialchars($post["tag"]) ?></td>
                <td><?= htmlspecialchars($post["title"]) ?></td>
                <td><a href="<?= htmlspecialchars($post["url"]) ?>" target="_blank">リンク</a></td>
                </tr>
                <?php endforeach; ?>
        <?php else: ?>
            <p>該当する投稿が見つかりませんでした。</p>
        <?php endif; ?>
    <?php endif; ?>
        </table>
    </body>
</html>
