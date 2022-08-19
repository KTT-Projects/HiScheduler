<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
// If already logged in, redirect to home.php
if ($_SESSION['LOGGED_IN'] == 1) {
  header('Location: ./home.php');
}
// create_area
if ($_POST['create_area_submit'] == '追加') {
  if (empty($error)) {
    // Putting post type data into variables
    $area_name = $_POST['create_area_name'];
    $area_password = $_POST['create_area_password'];
    $area_admin = $_POST['create_area_admin'];
    if ($area_name == '' || $area_name == null || $area_password == '' || $area_password == null || $area_admin == '' || $area_admin == null) {
      $error[] = '未入力箇所があります。';
    }
    // If there's any error, return false
    if (empty($error)) {
      // validate area password
      if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $area_password)) {
        $area_password = password_hash($area_password, PASSWORD_DEFAULT);
      } else {
        $error[] = '地域パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
      }
      // validate admin password
      if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $area_admin)) {
        $area_admin = password_hash($area_admin, PASSWORD_DEFAULT);
      } else {
        $error[] = '管理者パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
      }
      // Check if there's a same area name
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('SELECT area_name FROM area ORDER BY id');
        $stmt->execute();
        foreach ($stmt as $row) {
          if ($row['area_name'] == $area_name) {
            $error[] = '既に存在している地域名です。';
          }
        }
      } catch (PDOException $e) {
        $error[] = '' . $e . '';
      }
      // If there's any error, return false
      if (empty($error)) {
        // Insert data into database
        try {
          $stmt = $pdo->prepare('INSERT INTO area (area_name, area_password, admin_password) VALUES (:area_name, :area_password, :area_admin)');
          $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
          $stmt->bindParam(':area_password', $area_password, PDO::PARAM_STR);
          $stmt->bindParam(':area_admin', $area_admin, PDO::PARAM_STR);
          $stmt->execute();
        } catch (PDOException) {
          $error[] = '' . $e . '';
        }
        if (!empty($error)) {
          return false;
        } else {
          $_SESSION['LOGGED_IN'] = 1;
          $_SESSION['AREA'] = $area_name;
          $_SESSION['AREA_ADMIN'] = 1;
          header('Location: ./home.php');
        }
      }
    }
  }
} elseif ($_POST['login_area_submit'] == 'ログイン') {
  // Putting post type data into variables
  $area_name = $_POST['login_area_name'];
  $area_password = $_POST['login_area_password'];
  $actual_password = '';
  if ($area_name == '' || $area_name == null || $area_password == '' || $area_password == null) {
    $error[] = '未入力箇所があります。';
  }
  if (empty($error)) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT admin_password FROM area WHERE area_name = :area_name');
      $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $actual_password = $row['admin_password'];
      }
    } catch (PDOException $e) {
      $error[] = $e;
    }
    if (empty($error) && password_verify($area_password, $actual_password)) {
      $_SESSION['LOGGED_IN'] = 1;
      $_SESSION['AREA'] = $area_name;
      $_SESSION['AREA_ADMIN'] = 1;
      header('Location: ./home.php');
    } else {
      $error[] = 'パスワードまたは地域名が間違っています。';
    }
  }
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
    $('.close_error').click(function() {
      $('.error, .error_container, close_error').hide();
    });
  });
</script>

<body>
  <ul class="error_container">
    <?php
    foreach ($error as $message) {
      echo '<li class="error">' . $message . '</li>';
      echo '<button class="close_error">非表示</button>';
    }
    ?>
  </ul>
  <label for="login_area">地域管理者としてログイン</label>
  <form method="post" class="login_area">
    <input type="text" name="login_area_name" placeholder="地域名">
    <input type="password" name="login_area_password" placeholder="管理者パスワード">
    <input type="submit" value="ログイン" name="login_area_submit">
  </form>

  <label for="login_com">会社管理者としてログイン</label>
  <form method="post" class="login_com">
    <input type="text" name="login_com_area" placeholder="地域名">
    <input type="text" name="login_com_com" placeholder="会社名">
    <input type="password" name="login_com_password" placeholder="管理者パスワード">
    <input type="submit" value="ログイン" name="login_com_submit">
  </form>

  <label for="login_normal">通常ユーザーとしてログイン</label>
  <form method="post" class="login_normal">
    <input type="text" name="login_normal_area" placeholder="地域名">
    <input type="text" name="login_normal_com" placeholder="会社名">
    <input type="text" name="login_normal_name" placeholder="個人名">
    <input type="password" name="login_normal_password" placeholder="個人パスワード">
    <input type="submit" value="ログイン" name="login_normal_submit">
  </form>

  <label for="create_area">地域を追加</label>
  <form method="post" class="create_area">
    <input type="text" name="create_area_name" placeholder="地域名">
    <input type="password" name="create_area_password" placeholder="地域パスワード">
    <input type="password" name="create_area_admin" placeholder="管理者パスワード">
    <input type="submit" value="追加" name="create_area_submit">
  </form>

  <label for="create_com">企業を追加</label>
  <form method="post" class="create_com">
    <input type="text" name="create_com_area_name" placeholder="地域名">
    <input type="password" name="create_com_area_password" placeholder="地域パスワード">
    <input type="text" name="create_com_name" placeholder="会社名">
    <input type="password" name="create_com_password" placeholder="会社パスワード">
    <input type="password" name="create_com_admin" placeholder="管理者パスワード">
    <input type="submit" value="追加" name="create_com_submit">
  </form>

  <label for="create_user">通常ユーザーを作成してログイン</label>
  <form method="post" class="create_user">
    <input type="text" name="create_user_area_name" placeholder="地域名">
    <input type="text" name="create_user_com_name" placeholder="会社名">
    <input type="password" name="create_user_com_password" placeholder="会社パスワード">
    <input type="text" name="create_user_normal_name" placeholder="個人名">
    <input type="password" name="create_user_password" placeholder="個人パスワード">
    <input type="submit" value="追加" name="create_user_submit">
  </form>
</body>

</html>