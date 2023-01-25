<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
$_SESSION['test'] = 4;
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
      if (true) {
        $area_password = password_hash($area_password, PASSWORD_DEFAULT);
      } else {
        $error[] = '地域パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
      }
      // validate admin password
      if (true) {
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
            return false;
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
        } catch (PDOException $e) {
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
  // login_area
} elseif ($_POST['login_area_submit'] == 'ログイン') {
  // Putting post type data into variables
  $area_name = $_POST['login_area_name'];
  $area_password = $_POST['login_area_password'];
  $actual_password = '';
  if ($area_name == '' || $area_name == null || $area_password == '' || $area_password == null) {
    $error[] = '未入力箇所があります。';
  }
  // Get admin password
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
    // Validate password
    if (empty($error) && password_verify($area_password, $actual_password)) {
      $_SESSION['LOGGED_IN'] = 1;
      $_SESSION['AREA'] = $area_name;
      $_SESSION['AREA_ADMIN'] = 1;
      header('Location: ./home.php');
    } else {
      $error[] = 'パスワードまたは地域名が間違っています。';
    }
  }
  // create_com
} elseif ($_POST['create_com_submit'] == '追加') {
  // Putting post type data into variables
  $area_name = $_POST['create_com_area_name'];
  $area_password = $_POST['create_com_area_password'];
  $com_name = $_POST['create_com_name'];
  $com_password = $_POST['create_com_password'];
  $com_admin = $_POST['create_com_admin'];
  $actual_password = '';
  if ($area_name == '' || $area_name == null || $area_password == '' || $area_password == null || $com_name == '' || $com_name == null || $com_password == '' || $com_password == null || $com_admin == '' || $com_admin == null) {
    $error[] = '未入力箇所があります。';
  }
  if (empty($error)) {
    // validate area password
    if (true) {
      $com_password = password_hash($com_password, PASSWORD_DEFAULT);
    } else {
      $error[] = '会社パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    }
    // validate admin password
    if (true) {
      $com_admin = password_hash($com_admin, PASSWORD_DEFAULT);
    } else {
      $error[] = '管理者パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    }
    if (empty($error)) {
      // Get area password
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('SELECT area_password FROM area WHERE area_name = :area_name');
        $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt as $row) {
          $actual_password = $row['area_password'];
        }
      } catch (PDOException $e) {
        $error[] = $e;
      }
      // Validate password
      if (empty($error) && password_verify($area_password, $actual_password)) {
        // Insert data into company database
        try {
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('INSERT INTO company (com_name, com_password, admin_password, area) VALUES (:com_name, :com_password, :com_admin, :area_name)');
          $stmt->bindParam(':com_name', $com_name, PDO::PARAM_STR);
          $stmt->bindParam(':com_password', $com_password, PDO::PARAM_STR);
          $stmt->bindParam(':com_admin', $com_admin, PDO::PARAM_STR);
          $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
          $stmt->execute();
        } catch (PDOException $e) {
          $error[] = '既に地域内に存在する会社名です。';
        }
        if (empty($error)) {
          $_SESSION['LOGGED_IN'] = 1;
          $_SESSION['AREA'] = $area_name;
          $_SESSION['COM'] = $com_name;
          $_SESSION['COM_ADMIN'] = 1;
          header('Location: ./home.php');
        }
      } else {
        $error[] = 'パスワードまたは地域名が間違っています。';
      }
    }
  }
  // login_com
} elseif ($_POST['login_com_submit'] == 'ログイン') {
  // Putting post type data into variables
  $area_name = $_POST['login_com_area'];
  $com_name = $_POST['login_com_name'];
  $com_password = $_POST['login_com_password'];
  $actual_password = '';
  if ($com_name == '' || $com_name == null || $com_password == '' || $com_password == null || $area_name == '' || $area_name == null) {
    $error[] = '未入力箇所があります。';
  }
  if (empty($error)) {
    // Get admin password
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT admin_password FROM company WHERE area = :area_name AND com_name = :com_name');
      $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
      $stmt->bindParam(':com_name', $com_name, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $actual_password = $row['admin_password'];
      }
    } catch (PDOException $e) {
      $error[] = $e;
    }
    // Validate password
    if (empty($error) && password_verify($com_password, $actual_password)) {
      $_SESSION['LOGGED_IN'] = 1;
      $_SESSION['COM'] = $com_name;
      $_SESSION['AREA'] = $area_name;
      $_SESSION['COM_ADMIN'] = 1;
      header('Location: ./home.php');
    } else {
      $error[] = 'パスワードまたは会社名/地域名が間違っています。';
    }
  }
  // Create normal user
} elseif ($_POST['create_user_submit'] == '追加') {
  $area = $_POST['create_user_area_name'];
  $company = $_POST['create_user_com_name'];
  $name = $_POST['create_user_normal_name'];
  $password = $_POST['create_user_password'];
  $com_password = $_POST['create_user_com_password'];
  $actual_password = '';
  if ($area == '' || $area == null || $com_password == '' || $com_password == null || $name == '' || $name == null || $password == '' || $password == null || $company == '' || $company == null) {
    $error[] = '未入力箇所があります。';
  }
  if (empty($error)) {
    if (true) {
      $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
      $error[] = '個人パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    }
    if (empty($error)) {
      // Get company password
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('SELECT com_password FROM company WHERE area = :area AND com_name = :company');
        $stmt->bindParam(':area', $area, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt as $row) {
          $actual_password = $row['com_password'];
        }
      } catch (PDOException $e) {
        $error[] = $e;
      }
      if (empty($error) && password_verify($com_password, $actual_password)) {
        // Insert data.
        try {
          $pdo = new PDO(DSN, DB_USER, DB_PASS);
          $stmt = $pdo->prepare('INSERT INTO user (area, company, name, password) VALUES (:area, :company, :name, :password)');
          $stmt->bindParam(':area', $area, PDO::PARAM_STR);
          $stmt->bindParam(':company', $company, PDO::PARAM_STR);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':password', $password, PDO::PARAM_STR);
          $stmt->execute();
        } catch (PDOException $e) {
          $error[] = 'このユーザー名は既に登録されています。';
        }
        if (empty($error)) {
          $_SESSION['LOGGED_IN'] = 1;
          $_SESSION['COM'] = $company;
          $_SESSION['AREA'] = $area;
          $_SESSION['NAME'] = $name;
          header('Location: ./home.php');
        }
      } else {
        $error[] = 'パスワードまたは会社名/地域名が間違っています。';
      }
    }
  }
  // Login as normal user
} elseif ($_POST['login_normal_submit'] == 'ログイン') {
  $area = $_POST['login_normal_area'];
  $company = $_POST['login_normal_com'];
  $name = $_POST['login_normal_name'];
  $password = $_POST['login_normal_password'];
  $actual_password = '';
  if ($area == '' || $area == null || $name == '' || $name == null || $password == '' || $password == null || $company == '' || $company == null) {
    $error[] = '未入力箇所があります。';
  }
  if (empty($error)) {
    // Get actual password
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT password FROM user WHERE area = :area AND company = :company AND name = :name');
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->bindParam(':company', $company, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $actual_password = $row['password'];
      }
    } catch (PDOException $e) {
      $error[] = $e;
    }
    if (empty($error) && password_verify($password, $actual_password)) {
      $_SESSION['LOGGED_IN'] = 1;
      $_SESSION['COM'] = $company;
      $_SESSION['AREA'] = $area;
      $_SESSION['NAME'] = $name;
      header('Location: ./home.php');
    } else {
      $error[] = 'パスワードまたは会社名/地域名/個人名が間違っています。';
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
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <script src="./jquery.js"></script>
  <script src="./script.js"></script>
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
  <?php
  if (!empty($error)) {
    echo '<ul class="error_container">';
    foreach ($error as $message) {
      echo '<li class="error">' . $message . '</li>';
    }
    echo '<button class="close_error">×</button></ul>';
  }
  ?>
  <div class="all">
    <div class="icon">
      <img src="./images/IMG_1844.PNG">
      <h1>Hi<br> Scheduler</h1>
    </div>

    <div class="form">
      <div class="login">
        <button class="login_btn"><span>ログイン</span></button>
        <div>
          <div class="youngest">
            <h2>通常ユーザー</h2>
            <form method="post" class="login_normal" id="login_normal" autocomplete="new-password">
              <input class="input" type="text" name="login_normal_area" placeholder="地域名">
              <input class="input" type="text" name="login_normal_com" placeholder="会社名">
              <input class="input" type="text" name="login_normal_name" placeholder="個人名">
              <input class="input" type="password" name="login_normal_password" placeholder="個人パスワード">
              <input class="input" type="submit" value="ログイン" name="login_normal_submit">
            </form>
          </div>
          <input type="checkbox" id="F">
          <label class="F" for="F">管理者はこちら</label>
          <div class="administrator">
          <div class="youngest">
            <h2>地域管理者</h2>
            <form method="post" class="login_area" id="login_area" autocomplete="new-password">
              <input class="input" type="text" name="login_area_name" placeholder="地域名">
              <input class="input" type="password" name="login_area_password" placeholder="管理者パスワード">
              <input class="input" type="submit" value="ログイン" name="login_area_submit">
            </form>
          </div>
          <div class="youngest">
            <h2>会社管理者</h2>
            <form method="post" class="login_com" id="login_com" autocomplete="new-password">
              <input type="text" name="login_com_area" placeholder="地域名">
              <input type="text" name="login_com_name" placeholder="会社名">
              <input type="password" name="login_com_password" placeholder="管理者パスワード">
              <input type="submit" value="ログイン" name="login_com_submit">
            </form>
          </div>
        </div>
        </div>
      </div>

      <h3 class="yet">未登録の方は</h3>

      <div class="register">
        <button class="register_btn"><span>新規登録</span></button>
        <div>
          <div class="youngest">
            <h2>通常ユーザーを作成</h2>
            <form method="post" class="create_user" id="creat_user" autocomplete="new-password">
              <input type="text" name="create_user_area_name" placeholder="地域名">
              <input type="text" name="create_user_com_name" placeholder="会社名">
              <input type="password" name="create_user_com_password" placeholder="会社パスワード">
              <input type="text" name="create_user_normal_name" placeholder="個人名">
              <input type="password" name="create_user_password" placeholder="個人パスワード">
              <input type="submit" value="追加" name="create_user_submit">
            </form>
          </div>
          <input type="checkbox" id="G">
          <label class="G" for="G">管理者はこちら</label>
          <div class="administrator_2">
          <div class="youngest">
            <h2>地域を追加</h2>
            <form method="post" class="create_area" id="create_area" autocomplete="new-password">
              <input type="text" name="create_area_name" placeholder="地域名">
              <input type="password" name="create_area_password" placeholder="地域パスワード">
              <input type="password" name="create_area_admin" placeholder="管理者パスワード">
              <input type="submit" value="追加" name="create_area_submit">
            </form>
          </div>
          <div class="youngest">
            <h2>会社を追加</h2>
            <form method="post" class="create_com" id="create_com" autocomplete="new-password">
              <input class="input" type="text" name="create_com_area_name" placeholder="地域名">
              <input class="input" type="password" name="create_com_area_password" placeholder="地域パスワード">
              <input class="input" type="text" name="create_com_name" placeholder="会社名">
              <input class="input" type="password" name="create_com_password" placeholder="会社パスワード">
              <input class="input" type="password" name="create_com_admin" placeholder="管理者パスワード">
              <input class="input" type="submit" value="追加" name="create_com_submit">
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</body>

</html>