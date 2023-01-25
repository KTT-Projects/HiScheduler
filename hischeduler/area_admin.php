<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
// If not logged in, redirect to index.php
if ($_SESSION['AREA_ADMIN'] != 1) {
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
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./manage_admin.css">
  <script src="./jquery.js"></script>
  <title>HiScheduler || 研修スケジューラー</title>
</head>

<script>
  $(document).ready(function() {
    // Get all companies
    function get_companies() {
      let data1 = {
        'ajax': 1,
        'area': '<?php echo $_SESSION['AREA']; ?>'
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data1
        })
        .done(function(data, dataType) {
          if (data != $('.companies').html()) {
            $('.companies').html(data);
            delete_company_click();
          }
        });
    }
    // Delete company
    function delete_company(id) {
      let data2 = {
        'ajax': 2,
        'id': id
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data2
        })
        .done(function(data, dataType) {
          get_companies();
        });
    }
    // When delete button is pressed:
    function delete_company_click() {
      $('.remove_company').click(function() {
        if (confirm('本当にこの会社を削除しますか？')) {
          delete_company($(this).attr('id'));
        }
      });
    }
    // Delete area
    function delete_area() {
      let data3 = {
        'ajax': 3,
        'area': '<?php echo $_SESSION['AREA']; ?>'
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data3
        })
        .done(function(data, dataType) {
          if (data == 'success') {
            location.href = './remove_all_sessions.php';
          }
        });
    }
    // When delete area button is pressed:
    $('.delete_area').click(function() {
      if (confirm('本当にこの地域を削除しますか？')) {
        delete_area();
      }
    });
    // 初期実行
    get_companies();
    delete_company_click();
    // 定期実行
    setInterval(() => {
      get_companies();
    }, 5000);
  });
</script>

<body>
  <a href="./home.php" class="home_link">戻る</a>
  <ul class="companies"></ul>
  <button class="delete_area">地域を削除</button>
</body>

</html>