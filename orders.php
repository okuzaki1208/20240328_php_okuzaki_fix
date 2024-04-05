<!DOCTYPE html>
<html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理者ページ</title>
<link rel="stylesheet" type="text/css" href="./CSS/index.css">
</head>
<style>
      table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }
</style>
<body>
<h1><a href="orders.php" style="text-decoration:none;">OKUZAKI SHOP - 管理者ページ</a></h1>

<section class="order_list">
    <h2>注文一覧</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>住所</th>
            <th>リンゴの個数</th>
            <th>みかんの個数</th>
            <th>バナナの個数</th>
            <th>合計額</th>
            <th>管理者操作</th>
        </tr>
        <?php
        // DB接続情報
        $host = 'localhost';
        $dbname = 'okuzaki_shop'; // データベース名
        $username = 'root'; // データベースユーザー名
        $password = ''; // データベースパスワード

        try {
            // PDOインスタンスを作成
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            // エラーモードを例外モードに設定
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // order_list テーブルの全てのデータを取得
            $stmt = $pdo->query('SELECT * FROM order_list');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['ID']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['item1']}</td>";
                echo "<td>{$row['item2']}</td>";
                echo "<td>{$row['item3']}</td>";

                // 合計額を計算
                $total_price = ($row['item1'] * 100) + ($row['item2'] * 150) + ($row['item3'] * 230);
                echo "<td>{$total_price} 円</td>";

                // 削除ボタンを追加
                echo "<td>
                        <form id='delete_form_{$row['ID']}' method='post' onsubmit='return confirm(\"本当にキャンセルしますか？\")'>
                            <input type='hidden' name='delete_id' value='{$row['ID']}'>
                            <button type='submit' name='delete_submit'>キャンセル</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            die("データベースに接続できません: " . $e->getMessage());
        }

        // 削除ボタンが押された場合の処理
        if (isset($_POST['delete_submit'])) {
            $delete_id = $_POST['delete_id'];
            try {
                $stmt = $pdo->prepare("DELETE FROM order_list WHERE ID = ?");
                $stmt->execute([$delete_id]);
                echo "<script>alert('データを削除しました。');</script>";
                // 削除後にページをリロードする
                echo "<meta http-equiv='refresh' content='0'>";
            } catch (PDOException $e) {
                exit('データを削除できませんでした。');
            }
        }
        ?>
    </table>
</section>

</body>
</html>
