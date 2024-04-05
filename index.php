<!DOCTYPE html>
<html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>テスト</title>
<link rel="stylesheet" type="text/css" href="./CSS/index.css">
</head>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<body>

<div class="shop_name">
    <h1><a href="index.php" style="text-decoration:none;">OKUZAKI SHOP</a></h1>
</div>

<section class="product_area">
    <div class="area_flex">
        <img src="./images/item1.png">
        <h2>りんご</h2>
        <label for="item1-quantity">¥ 100</label><br/>
        <input type="number" id="item1-quantity" name="item1-quantity" min="0">
    </div>
    
    <div class="area_flex">
        <img src="./images/item2.png">
        <h2>みかん</h2>
        <label for="item2-quantity">¥ 150</label><br/>
        <input type="number" id="item2-quantity" name="item2-quantity" min="0">
    </div>
        
    <div class="area_flex">
        <img src="./images/item3.png">
        <h2>バナナ</h2>
        <label for="item3-quantity">¥ 230</label><br/>
        <input type="number" id="item3-quantity" name="item3-quantity" min="0">
    </div>
</section>

<section class="input_field">
    <!-- フォームを修正 -->
    <form id="order-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return submitForm()">
        <label for="name">名前（必須、最大20文字）</label>
        <input type="text" id="name" name="name" placeholder="例）山田　太郎" autocomplete="name" maxlength="20">
        <span id="name-error" class="error-message"></span><br/><br/>
        <label for="zip">郵便番号で住所を自動入力できます。</label>
        <input type="text" id="zip" name="zip" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="例）123-4567 or 1234567"><br/><br/>
        <label for="address">住所（必須）</label>
        <input type="text" id="address" name="address" size="60" placeholder="例）〇〇県□□市△△町1-2-3" autocomplete="address">
        <span id="address-error" class="error-message"></span><br/><br/>
        
        <!-- 商品の数量入力フィールド -->
        <input type="hidden" name="item1-quantity" id="item1-quantity-hidden" value="">
        <input type="hidden" name="item2-quantity" id="item2-quantity-hidden" value="">
        <input type="hidden" name="item3-quantity" id="item3-quantity-hidden" value="">
        
        <!-- 送信ボタンをフォーム内に配置 -->
        <div style="text-align: center;">
            <button type="submit" name="submit" style="font-size: 20px;">送信</button>
        </div>
    </form>
</section>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!empty($_POST["name"])) {
        // DB接続情報
        $host = 'localhost';
        $dbname = 'okuzaki_shop'; // データベース名
        $username = 'root'; // データベースユーザー名
        $password = ''; // データベースパスワード

        // PDOインスタンスを作成
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            // エラーモードを例外モードに設定
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("データベースに接続できません: " . $e->getMessage());
        }

        // name と address のバリデーションは JavaScript で行われているため、PHP でのバリデーションは不要

        // name と address を取得
        $name = $_POST["name"];
        $address = $_POST["address"];

        // 商品の数量を取得
        $item1Quantity = $_POST["item1-quantity"] ?? 0;
        $item2Quantity = $_POST["item2-quantity"] ?? 0;
        $item3Quantity = $_POST["item3-quantity"] ?? 0;

        // データベースにデータを挿入
        try {
            $stmt = $pdo->prepare("INSERT INTO order_list (name, address, item1, item2, item3) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $address, $item1Quantity, $item2Quantity, $item3Quantity]);
            echo "データベースにデータを登録しました。";
            // リダイレクト
            echo "<script>window.location.href = 'thanks.php';</script>";
        } catch (PDOException $e) {
            die("データベースにデータを登録できません: " . $e->getMessage());
        }
    } else {
        echo "名前を入力してください。";
    }
}
?>

<script src="./Javascript/script.js"></script>

</body>
</html>
