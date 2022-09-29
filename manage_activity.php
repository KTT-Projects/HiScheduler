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
if ($_SESSION['COM_ADMIN'] != 1 && $_SESSION['AREA_ADMIN'] != 1) {
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
    // 研修取得処理
    function get_activities() {
      let company;
      company = '<?php if (isset($_SESSION['COM'])) {
                    echo $_SESSION['COM'];
                  } ?>';
      let area = '<?php echo $_SESSION['AREA'] ?>';
      let data8 = {
        'ajax': 8,
        'area': area,
        'company': company,
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data8
        })
        .done(function(data, dataType) {
          if ($('.activities').html() != data) {
            $('.activities').html(data);
          }
          remove_activity_click();
        });
    }
    // クリック時処理アップデート関数
    function remove_activity_click() {
      $('.remove_activity').click(function() {
        if (confirm('本当にこの研修を削除しますか？')) {
          remove_activity($(this).attr('id'));
        }
      });
    }
    // 研修削除処理
    function remove_activity(id) {
      let data9 = {
        'ajax': 9,
        'id': id
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data9
        })
        .done(function(data, dataType) {
          get_activities();
        });
    }
    // 初期実行
    get_activities();
    // 定期実行
    setInterval(() => {
      get_activities();
    }, 5000);
  });
</script>

<body>
  <a href="./home.php">戻る</a>
  <div class="activities"></div>
</body>

</html>