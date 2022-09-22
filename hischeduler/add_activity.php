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
  if ($_POST['activity_name'] == '' || $_POST['activity_name'] == null || $_POST['activity_details'] == '' || $_POST['activity_details'] == null || $_POST['activity_start_date'] == '' || $_POST['activity_start_date'] == null || $_POST['activity_start_time'] == '' || $_POST['activity_start_time'] == null || $_POST['activity_end_date'] == '' || $_POST['activity_end_date'] == null || $_POST['activity_end_time'] == '' || $_POST['activity_end_time'] == null) {
    $error[] = '全項目を入力してください。';
  } else {
    // pdfアップロード処理
    $file_path;
    function upload_pdf($path)
    {
      if (move_uploaded_file($_FILES['activity_pdf']['tmp_name'], $path)) {
        chmod($path, 0644);
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
    $end = $_POST['activity_end_date'] . ' ' . $_POST['activity_end_time'] . ':00';
    $details = $_POST['activity_details'];
    if (empty($error)) {
      try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $stmt = $pdo->prepare('INSERT INTO activity (name, start, end, details, pdf_path) VALUES (:name, :start, :end, :details, :file_path)');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_STR);
        $stmt->bindParam(':end', $end, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->execute();
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
  <?php
  if (!empty($error)) {
    echo '<ul class="error_container">';
    foreach ($error as $message) {
      echo '<li class="error">' . $message . '</li>';
    }
    echo '<button class="close_error">非表示</button></ul>';
  }
  ?>
  <label for="add_activity">研修を追加</label>
  <form method="post" class="add_activity" enctype="multipart/form-data">
    <input type="text" name="activity_name" placeholder="研修名">
    <input type="date" name="activity_start_date">
    <input type="time" name="activity_start_time">
    <input type="date" name="activity_end_date">
    <input type="time" name="activity_end_time">
    <textarea name="activity_details" placeholder="概要"></textarea>
    <input type="file" name="activity_pdf" accept=".pdf" required>
    <input type="submit" value="追加" name="add_activity_submit">
  </form>
</body>

</html>