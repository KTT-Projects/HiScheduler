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
  <link rel="stylesheet" href="./css/calendar.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/e4a9507649.js" crossorigin="anonymous"></script>
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
  ?>

  <header>
    <h1><a href="./">HiScheduler</a></h1>
  </header>
  <div class="choose">
    <?php
    if ($_SESSION['COM_ADMIN'] == 1) {
      echo '<div class="choose-a"><a href="com_admin.php">会社管理ページ</a></div>';
      echo '<div class="choose-a"><a href="add_activity.php">研修を追加</a></div>';
      echo '<div class="choose-a"><a href="manage_activity.php">研修を削除</a></div>';
    } elseif ($_SESSION['AREA_ADMIN'] == 1) {
      echo '<div class="choose-a"><a href="area_admin.php">地域管理ページ</a></div>';
      echo '<div class="choose-a"><a href="manage_activity.php">研修を削除</a></div>';
    }
    ?>
  </div>
  <div class="wrapper">
    <!-- 年月を表示 -->
    <h1 id="header"></h1>
    <!-- ボタンクリックで月移動 -->
    <div id="next-prev-button">
      <button id="prev" onclick="prev()">‹</button>
      <button id="next" onclick="next()">›</button>
    </div>
    <!-- カレンダー -->
    <div id="calendar"></div>
  </div>

  <form method="post">
    <input type="submit" value="ログアウト" name="logout">
  </form>
  <footer>
    <section class="f-section1">
      <div class="f-page">
        <p><a href="https://kttprojects.com/homepage/">KTT Projectsとは</a></p>
        <p><a href="https://kttprojects.com/homepage/">活動内容</a></p>
        <p><a href="https://kttprojects.com/homepage/">実績</a></p>
      </div>
      <div class="f-page">
        <p><a href="https://kttprojects.com/homepage/">よくあるお問い合わせ</a></p>
        <p><a href="https://kttprojects.com/homepage/">お問い合わせ</a></p>
      </div>
    </section>
    <section class="f-section2">
      <div class="writing f-under">
        <p><a href="https://kttprojects.com/homepage/">利用規約</a></p>
        <p><a href="https://kttprojects.com/homepage/">プライバシーポリシー</a></p>
        <div class="f-icon f-under">
          <a href="https://m.youtube.com/channel/UCihqEDqGrLOOrs0o-IBulqw"><i class="fa-brands fa-youtube f-youtube"></i></a>
        </div>
        <p class="copyright">Copyright ©︎ 2022 KTT Projects.</p>
      </div>
    </section>
  </footer>
  <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>