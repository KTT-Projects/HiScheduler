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
// var_dump($_SESSION);
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
  if ($_SESSION['AREA_ADMIN'] == 1) {
    echo '<a href="./area_admin.php" class="admin_link">地域管理ページ</a>';
  } elseif ($_SESSION['COM_ADMIN']) {
    echo '<a href="./com_admin.php" class="admin_link">会社管理ページ</a>';
  }
  ?>
  <form method="post">
    <input type="submit" value="ログアウト" name="logout">
  </form>
</body>

</html>