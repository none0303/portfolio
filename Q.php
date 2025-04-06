<?php
    session_start();
    if (!isset($_SESSION["user_id"])) {
        echo "ログインが必要です。";
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>問題作成</title>
    <meta name="author" content="小田原海斗">
    <link rel="stylesheet" href="Q.css">
</head>
<body>
<button onclick="location.href='FunDyHome.php'">ホーム画面に戻る</button>
    <?php
        $db = "mysql:host=localhost;dbname=s2312067;charset=utf8mb4";
        $username = "s2312067";
        $password = "4heBRAvlB5fU";

        try {
            $pdo = new PDO($db, $username, $password);
        } catch (PDOException $e) {
            echo "データベース接続エラー: " . $e->getMessage();
            exit;
        }

        // 「Q.php」として動作中であればこの辺りでINSERT文を実行する想定
        if (!empty($_POST["newscore"])) {
            $stmt = $pdo->prepare("INSERT INTO test_scores (user_id, user_name, score)
                                   VALUES (:user_id, :user_name, :score)");
            $stmt->bindValue(":user_id", $_SESSION["user_id"], PDO::PARAM_INT);
            $stmt->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
            $stmt->bindValue(":score", $_POST["newscore"], PDO::PARAM_INT);
            $stmt->execute();
            echo "<p>スコアが保存されました！</p>";

            // スコア保存後、ランキングページへ飛ばしたい場合
            header("Location: ranking.php");
            exit;
        }
    ?>
    <!-- 小田ちゃんここから -->
    <div class="content">
        <main class="main">
            <!-- POST先を Q.php に -->
            <form id="quizForm" method="POST" action="Q.php">
                <input type="hidden" id="hiddenScore" name="newscore" value="">

                <!-- Quiz Questions -->
                  <p class="question">以下の問題を微分しなさい</p>
                <p class="answer">
                    問題１<br>
                    4X^3 + 5X^2<br>
                    <input type="radio" name="q1" value="0">8X^2 + 10X<br>
                    <input type="radio" name="q1" value="0">12X^3 + 10X^2<br>
                    <input type="radio" name="q1" value="1">12X^2 + 10X<br>
                    <input type="radio" name="q1" value="0">12X + 10X<br>
                </p>
                <p class="question">問題２</p>
                <p class="answer">
                    6X^7 - 3X^4 + 2<br>
                    <input type="radio" name="q2" value="1">42X^6 - 12X^3<br>
                    <input type="radio" name="q2" value="0">42X^7 - 12X^4<br>
                    <input type="radio" name="q2" value="0">36X^6 - 9X^3 + 2<br>
                    <input type="radio" name="q2" value="0">42X^6 -12X^3 + 2<br>
                </p>
                <p class="question">問題３</p>
                <p class="answer">
                    15X^6 + 4X^9 + 3X^2<br>
                    <input type="radio" name="q3" value="0">90X^6 + 36X^9 + 3X<br>
                    <input type="radio" name="q3" value="0">90X^5 + 36X^8 + 6X^2<br>
                    <input type="radio" name="q3" value="1">90X^5 + 36X^8 + 6X<br>
                    <input type="radio" name="q3" value="0">15X^5 + 4X^8 + 3<br>
                </p>
                <p class="question">問題４</p>
                <p class="answer">
                    7X^7 + 8X^5 - 9X<br>
                    <input type="radio" name="q4" value="0">49X^6 + 40X^5 - 9X^2<br>
                    <input type="radio" name="q4" value="1">49X^6 + 40X^4 - 9<br>
                    <input type="radio" name="q4" value="0">42X^7 + 32X^5 - 9<br>
                    <input type="radio" name="q4" value="0">49X^6 + 40X^4 + 9X<br>
                </p>
                <p class="question">問題５</p>
                <p class="answer">
                    2X^7 - 3X^3 - 12X^3<br>
                    <input type="radio" name="q5" value="0">14X^6 - 15X^2<br>
                    <input type="radio" name="q5" value="0">14X^8 - 9X^3<br>
                    <input type="radio" name="q5" value="0">2X^6 - 6X^3 -12X^2<br>
                    <input type="radio" name="q5" value="1">14X^6 - 9X^2 - 36X^2<br>
                </p>
                <p class="question">以下の問題を積分しなさい</p>
                <p class="answer">
                    問題１<br>
                    ∫(2X^3 - 5X - 3)dx<br>
                    <input type="radio" name="q6" value="1">1X^4/2 - 5X^2/2 - 3X + C<br>
                    <input type="radio" name="q6" value="0">2X^5/5 - 5X^3/3 - 3X + C<br>
                    <input type="radio" name="q6" value="0">1X^3/3 - 5X^2 - 3X + C<br>
                    <input type="radio" name="q6" value="0">1X^4/2 - 5X^3 - 3X + C<br>
                </p>
                <p class="question">問題２</p>
                <p class="answer">
                    ∫(4X^2 + 3X)dx<br>
                    <input type="radio" name="q7" value="0">4X^3 + 3X^2 + C<br>
                    <input type="radio" name="q7" value="1">4X^3/3 + 3X^2/2 + C<br>
                    <input type="radio" name="q7" value="0">1X^4/4 + 1X^3/3 + C<br>
                    <input type="radio" name="q7" value="0">4X^3/3 + 1X^2/2 + C<br>
                </p>
                <p class="question">問題３</p>
                <p class="answer">
                    ∫(7X^6 - 8X^3 - 3)dx<br>
                    <input type="radio" name="q8" value="0">7X^5 - 8X^3 - 3X + C<br>
                    <input type="radio" name="q8" value="1">X^7 - 2X^4 - 3X + C<br>
                    <input type="radio" name="q8" value="0">X^7 - 8X^3 -3X + C<br>
                    <input type="radio" name="q8" value="0">7X^7/6 - 4X^4 -3X + C<br>
                </p>
                <p class="question">問題４</p>
                <p class="answer">
                    ∫(12X^3 + 6X^9 +8)dx<br>
                    <input type="radio" name="q9" value="1">3X^4 + 3X^10/5 + 8X + C<br>
                    <input type="radio" name="q9" value="0">12X^4/4 + 6X^9/10 + 8 + C<br>
                    <input type="radio" name="q9" value="0">4X^3 + 6X^9/10 + 8X + C<br>
                    <input type="radio" name="q9" value="0">3X^4 + 6X^10 + 8 + C<br>
                </p>
                <p class="question">問題５</p>
                <p class="answer">
                    ∫(15X^4 + 2X^3 - 8X)dx<br>
                    <input type="radio" name="q10" value="0">3X^4 + 2X^3/4 - 8X^2 + C<br>
                    <input type="radio" name="q10" value="0">15X^5/5 + X^3 -4X + C<br>
                    <input type="radio" name="q10" value="0">15X^5 + 1X^4/3 - 8X^2 + C<br>
                    <input type="radio" name="q10" value="1">3X^5 + X^4/2 - 4X^2 + C<br>
                </p>
                <!-- ここまで -->

                <!-- Submit Button -->
                <!-- onsubmitやonclickでスコアをセットしたら、あとは通常のフォーム送信でOK -->
                <button type="submit" onclick="calculateScore()">スコア送信</button>
            </form>
            <p id="score"></p>
        </main>
    </div>
    <!-- let = 再代入できる変数しかも初期値宣言しなくてもいい、const = 値の変更ができない(主にブロックで囲まれた場所で使う) -->
    <!-- querySelectorAll =  指定したcssセレクタに一致する全ての内容を取得できる(ここではinput type = radioの値を取得してる) -->
    <!-- foreach = その要素が終わるまで処理を繰り返す（ここではanswersの値を全て取得し計算するまで繰り返してる） -->
    <!-- parseInt = valueの値が文字列だから整数に変換してる(なにこれ便利) -->
    <!-- getElementById = わからーーーーーん！！！scoreに値セットする役割？ -->
    <script>
        function calculateScore() {
            let score = 0;
            const answers = document.querySelectorAll('input[type="radio"]:checked');
            answers.forEach(answer => {
                score += parseInt(answer.value, 10);
            });
            // 画面上にスコアを表示
            document.getElementById('score').innerText = score + "点";
            // フォームの隠しフィールドにスコアを設定
            document.getElementById('hiddenScore').value = score;
            // ここでreturnすれば通常のフォーム送信が行われます
        }
    </script>
</body>
</html>