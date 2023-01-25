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
  let activity_data;
  // 研修取得処理
  function get_activities() {
    let company;
    company = '<?php if (isset($_SESSION['COM'])) {
                  echo $_SESSION['COM'];
                } ?>';
    let area = '<?php echo $_SESSION['AREA'] ?>';
    let data13 = {
      'ajax': 13,
      'area': area,
      'company': company,
    }
    $.ajax({
        dataType: 'json',
        url: './data.php',
        type: 'post',
        data: data13
      })
      .done(function(data, dataType) {
        activity_data = data;
      });
  }
  // 研修参加処理
  function join_activity(id) {
    if ('<?php echo $_SESSION['NAME'] ?>' == '') {
      alert('管理者は研修に参加できません');
    } else if (confirm('この活動に参加しますか？')) {
      let area = '<?php echo $_SESSION['AREA'] ?>';
      let com = '<?php echo $_SESSION['COM'] ?>';
      let name = '<?php echo $_SESSION['NAME'] ?>';
      let data14 = {
        'ajax': 14,
        'area': area,
        'com': com,
        'name': name,
        'id': id,
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data14
        })
        .done(function(data, dataType) {
          if (data == 'error') {
            alert("エラー：研修に参加できませんでした");
          }
          if (data == 'already joined') {
            alert("この活動にはすでに参加しています");
          }
        });
    }
  }
  // クリック時処理アップデート
  function activity_click() {
    let com_admin = '<?php echo $_SESSION['COM_ADMIN'] ?>';
    let area_admin = '<?php echo $_SESSION['AREA_ADMIN'] ?>';
    let normal_user = '<?php if (empty($_SESSION['NAME'])) {
                          echo '1';
                        }
                        ?>';
    if ((com_admin == '1' && normal_user == '1') || area_admin == '1') {
      $('.activity_join_button').remove();
    }
  }
  // 詳細クリック時
  function open_spec(id) {
    id = '#' + id + '_';
    if ($(id).html() == '閉じる') {
      $(id).html('詳細')
      id = id + 'closed';
      $(id).hide();
    } else {
      $(id).html('閉じる')
      id = id + 'closed';
      $(id).show();
    }
  }
  get_activities();
  setTimeout(() => {
    activity_click();
  }, 1050);
  setInterval(() => {
    get_activities();
  }, 3000);
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
    <img src="./images/logo192.png" alt="" class="logo">
    <h1><a href="./">HiScheduler</a></h1>
  </header>
  <main>
    <div class="choose">
      <?php
      if ($_SESSION['COM_ADMIN'] == 1) {
        echo '<div class="choose-a"><a href="com_admin.php">会社管理ページ</a></div>';
        echo '<div class="choose-a"><a href="add_activity.php">研修を追加</a></div>';
        echo '<div class="choose-a"><a href="manage_activity.php">研修を管理</a></div>';
      } elseif ($_SESSION['AREA_ADMIN'] == 1) {
        echo '<div class="choose-a"><a href="area_admin.php">地域管理ページ</a></div>';
        echo '<div class="choose-a"><a href="manage_activity.php">研修を削除</a></div>';
      }
      if (isset($_SESSION['NAME'])) {
        echo '<div class="choose-a"><a href="manage_participation.php">参加研修の管理</a></div>';
      }
      ?>
    </div>
    <div class="popup"></div>
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
  </main>
  <footer>
    <section class="f-section1">
      <p><a href="https://kttprojects.com/homepage/">運営者情報</a></p>
      <p><a href="https://kttprojects.com/homepage/">活動内容</a></p>
      <p><a href="https://kttprojects.com/homepage/">実績</a></p>
    </section>
    <section class="f-section2">
      <!--<p><a href="https://kttprojects.com/homepage/">よくあるお問い合わせ</a></p>-->
      <p><a href="./tools/contact.html">お問い合わせ</a></p>
      <p><a href="./terms_of_service.pdf">利用規約</a></p>
      <p><a href="./privacy_policy.pdf">プライバシーポリシー</a></p>
    </section>
    <div class="f-under">
      <p class="copyright">©︎ 2022 KTT Projects.</p>
      <div class="f-icon">
        <a href="https://m.youtube.com/channel/UCihqEDqGrLOOrs0o-IBulqw"><i class="fa-brands fa-youtube f-youtube"></i></a>
      </div>
    </div>
  </footer>
  <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>