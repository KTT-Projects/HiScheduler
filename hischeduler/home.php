<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
// If not logged in, redirect to index.php
if ($_SESSION['LOGGED_IN'] != 1) {
  header('Location: ./index.php');
}
// Logout process
if ($_POST['logout'] == 'ログアウト') {
  $_SESSION = array();
  header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="manifest" href="./manifest.json">
  <link rel="shortcut icon" href="./images/logo256.png">
  <script src="./jquery.js"></script>
  <title>HiScheduler || 研修スケジューラー</title>
</head>

<script>
  $(document).ready(function() {

  });
</script>

<body>
  <?php
  if (isset($_SESSION['NAME'])) {
    $area = $_SESSION['AREA'];
    $company = $_SESSION['COM'];
    $name = $_SESSION['NAME'];
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT permission FROM user WHERE area = :area AND company = :company AND name = :name');
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->bindParam(':company', $company, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $permission = $row['permission'];
      }
      $_SESSION['COM_ADMIN'] = $permission;
    } catch (PDOException $e) {
      $error[] = $e;
    }
  }
  // ユーザー種ごとの遷移先画面表示
  if ($_SESSION['AREA_ADMIN'] == 1) {
    echo '<a href="./area_admin.php" class="admin_link">地域管理ページ</a>';
    echo '<a href="./remove_activity.php" class="admin_link">研修を削除</a>';
  } elseif ($_SESSION['COM_ADMIN'] == 1) {
    echo '<a href="./com_admin.php" class="admin_link">会社管理ページ</a>';
    echo '<a href="./add_activity.php" class="admin_link">研修を追加</a>';
    echo '<a href="./remove_activity.php" class="admin_link">研修を削除</a>';
  }
  ?>
  <form method="post">
    <input type="submit" value="ログアウト" name="logout">
  </form>
</body>

</html>