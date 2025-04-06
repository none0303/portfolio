<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ランキング</title>
    <link rel="stylesheet" href="Q.css">
</head>
<body>
    <?php
        // データベース接続
        $db = "mysql:host=localhost;dbname=project;charset=utf8mb4";
        $username = "odawara";
        $password = "ebetyun";

        try {
            $pdo = new PDO($db, $username, $password);
        } catch (PDOException $e) {
            echo "データベース接続エラー: " . $e->getMessage();
            exit;
        }

        // スコアを昇順で取得
        $query = $pdo->prepare("SELECT user_id, user_name, score FROM test_scores ORDER BY score DESC");
        $query->execute();
        $rankings = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- スコアを表示するテーブル -->
    <button onclick="location.href='FunDyHome.php'">ホーム画面に戻る</button>
    <div class="content2">
        <h1>ランキング</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>順位</th>
                    <th>ユーザー名</th>
                    <th>スコア</th>
                </tr>
            </thead>
            <!-- ランキングに新しいデータが入る度に表示されるデータを追加するところ -->
            <tbody>
                <?php
                if (!empty($rankings)) {
                    $rank = 1;
                    foreach ($rankings as $row) {
                        echo "<tr>";
                        echo "<td>" . $rank++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['score']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>データがありません</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
