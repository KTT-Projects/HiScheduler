<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
// If not logged in, redirect to index.php
if ($_SESSION['LOGGED_IN'] != 1 || $_SESSION['COM_ADMIN'] != 1) {
  header('Location: ./index.php');
}
// 研修アップロード処理
if ($_POST['add_activity_submit'] == '追加') {
  // 全データ確認
  if ($_POST['activity_name'] == '' || $_POST['activity_name'] == null || $_POST['activity_details'] == '' || $_POST['activity_details'] == null || $_POST['activity_start_date'] == '' || $_POST['activity_start_date'] == null || $_POST['activity_start_time'] == '' || $_POST['activity_start_time'] == null || $_POST['activity_end_time'] == '' || $_POST['activity_end_time'] == null || $_FILES['activity_pdf']['tmp_name'] == '') {
    $error[] = '全項目を入力してください。';
  } else {
    // pdfアップロード処理
    $file_path;
    function upload_pdf($path)
    {
      if (move_uploaded_file($_FILES['activity_pdf']['tmp_name'], $path)) {
        chmod($path, 0666);
      }
    }
    if (is_uploaded_file($_FILES['activity_pdf']['tmp_name'])) {
      $file_path = 'pdfs/' . $_FILES['activity_pdf']['name'];
      $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
      if ($file_ext == 'pdf') {
        if (file_exists($file_path)) {
          $number = 0;
          $original_file_path = $file_path;
          while (file_exists($file_path)) {
            $number++;
            $file_path = str_replace('.pdf', $number, $original_file_path);
            $file_path = $file_path . '.pdf';
          }
          upload_pdf($file_path);
        } else {
          upload_pdf($file_path);
        }
      }
    }
    // 研修情報アップロード処理
    $name = $_POST['activity_name'];
    $start = $_POST['activity_start_date'] . ' ' . $_POST['activity_start_time'] . ':00';
    $end = $_POST['activity_start_date'] . ' ' . $_POST['activity_end_time'] . ':00';
    $details = $_POST['activity_details'];
    $area = $_SESSION['AREA'];
    $company = $_SESSION['COM'];
    if (empty($error)) {
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('INSERT INTO activity (area, company, name, start, end, details, pdf_path) VALUES (:area, :company, :name, :start, :end, :details, :file_path)');
        $stmt->bindParam(':area', $area, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_STR);
        $stmt->bindParam(':end', $end, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->execute();
        $_POST = array();
        $javascript = 'alert("研修をアップロードしました。");';
      } catch (PDOException $e) {
        $error[] = '研修をアップロードできませんでした。';
      }
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
  <link rel="stylesheet" href="./css/add_activity.css">
  <script src="./jquery.js"></script>
  <title>HiScheduler || 研修スケジューラー</title>
</head>

<script>
  $(document).ready(function() {
    <?php
    // echo $javascript;
    if ($javascript == 'alert("研修をアップロードしました。");') {
        header('Location: ./home.php');
    }
    ?>
    $('.close_error').click(function() {
      $('.error, .error_container, close_error').hide();
    })
  })
</script>

<body>
  <header>
  <a href="./"><img src="./images/logo192.png" alt="" class="logo">
    <h1>HiScheduler</h1></a>
  </header>
  <div class="top_div">
    <label for="add_activity" class="top_title">研修を追加</label>
    <a href="./home.php">前ページへ戻る</a>
  </div>
  <?php
  if (!empty($error)) {
    echo '<ul class="error_container">';
    foreach ($error as $message) {
      echo '<li class="error">' . $message . '</li>';
    }
    echo '<button class="close_error">非表示</button></ul>';
  }
  ?>
  <form method="post" class="add_activity first_form" enctype="multipart/form-data">
    <div class="form_flex">
    <div class="form_one">
      <label for="activity_name">研修名</label><br>
      <label for="activity_start_date">開始日</label><br>
      <label for="activity_start_time">開始時刻</label><br>
      <!-- <label for="activity_end_date">終了日</label><br> -->
      <label for="activity_end_time">終了時刻</label><br>
      <label for="activity_details">概要</label><br>
      <label for="activity_pdf" class="label_file">添付ファイル</label><br>
      <input type="submit" value="追加" name="add_activity_submit" class="add_activity_submit_c">
    </div>
    <div class="form_two">
      <input type="text" name="activity_name" value="<?php if( !empty($_POST['activity_name']) ){ echo $_POST['activity_name']; } ?>"><br>
      <input type="date" name="activity_start_date" value="<?php if( !empty($_POST['activity_start_date']) ){ echo $_POST['activity_start_date']; } ?>"><br>
      <input type="time" name="activity_start_time" value="<?php if( !empty($_POST['activity_start_time']) ){ echo $_POST['activity_start_time']; } ?>"><br>
      <!-- <input type="date" name="activity_end_date" value="<?//php if( !empty($_POST['activity_end_date']) ){ echo $_POST['activity_end_date']; } ?>"><br> -->
      <input type="time" name="activity_end_time" value="<?php if( !empty($_POST['activity_end_time']) ){ echo $_POST['activity_end_time']; } ?>"><br>
      <textarea name="activity_details"><?php if( !empty($_POST['activity_details']) ){ echo $_POST['activity_details']; } ?></textarea><br>
      <label class="file_design">
      <input type="file" name="activity_pdf" class="activity_pdf_c" accept=".pdf">アップロード<br>
      </label>
      <span>PDFファイルを選択してください</span>
    </div>
    </div>
  </form>
    <form method="post" class="add_activity second_form" enctype="multipart/form-data">
    <label for="activity_name">研修名</label><br><input type="text" name="activity_name"><br><br>
    <label for="activity_start_date">開始日</label><br><input type="date" name="activity_start_date"><br><br>
    <label for="activity_start_time">開始時刻</label><br><input type="time" name="activity_start_time"><br><br>
    <!-- <label for="activity_end_date">終了日</label><br><input type="date" name="activity_end_date"><br><br> -->
    <label for="activity_end_time">終了時刻</label><br><input type="time" name="activity_end_time"><br><br>
    <label for="activity_details">概要</label><br><textarea name="activity_details"></textarea><br><br>
    <label for="activity_pdf">添付ファイル</label><label class="file_design"><input type="file" name="activity_pdf" accept=".pdf" required>アップロード<br></label><br><br>
    <input type="submit" value="追加" name="add_activity_submit">
  </form>
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
  <script>
    $('.activity_pdf_c').on('change', function () {
    var file = $(this).prop('files')[0];
    $('span').text(file.name);
    });
  </script>
</body>
</html>