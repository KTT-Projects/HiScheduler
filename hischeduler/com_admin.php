<?php
// global error list
$error = array();
// Import default settings
require_once('./config.php');
session_start();
// If wasn't a admin, redirect to index.php
if ($_SESSION['COM_ADMIN'] != 1) {
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
    // 社員一覧表示
    function get_users() {
      let data4 = {
        'ajax': 4,
        'area': '<?php echo $_SESSION['AREA'] ?>',
        'company': '<?php echo $_SESSION['COM'] ?>',
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data4
        })
        .done(function(data, dataType) {
          if (data != $('.all_users').html()) {
            $('.all_users').html(data);
            clicks();
          }
        });
    }
    // click functionのリフレッシュ
    function clicks() {
      $('.remove_user').click(function() {
        if (confirm('本当にこの会社を削除しますか？')) {
          delete_user($(this).attr('id'));
        }
      });
      $('.permission_user').click(function() {
        if (confirm('本当にこの社員に組織アカウント権限を与えますか？')) {
          permission_user($(this).attr('id'));
        }
      });
      $('.unpermission_user').click(function() {
        if (confirm('本当にこの社員の組織アカウント権限を剥奪しますか？')) {
          unpermission_user($(this).attr('id'));
        }
      });
    }
    // 社員削除処理
    function delete_user(id) {
      let data5 = {
        'ajax': 5,
        'id': id
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data5
        })
        .done(function(data, dataType) {
          get_users();
        });
    }
    // 組織アカウント権付与
    function permission_user(id) {
      let data6 = {
        'ajax': 6,
        'id': id
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data6
        })
        .done(function(data, dataType) {
          get_users();
        });
    }
    // 組織アカウント権剥奪
    function unpermission_user(id) {
      let data7 = {
        'ajax': 7,
        'id': id
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data7
        })
        .done(function(data, dataType) {
          get_users();
        });
    }
    // Delete company
    function delete_company() {
      let data2 = {
        'ajax': 2,
        'company': '<?php echo $_SESSION['COM'] ?>'
      }
      $.ajax({
          dataType: 'json',
          url: './data.php',
          type: 'post',
          data: data2
        })
        .done(function(data, dataType) {
          if (data == 'success') {
            location.href = './remove_all_sessions.php';
          }
        });
    }
    // 会社削除がクリックされたとき
    $('.delete_company').click(function() {
      if (confirm('本当に会社を削除しますか？')) {
        delete_company();
      }
    });
    // 初期実行
    get_users();
    clicks();
    delete_company_click();
    // 定期実行
    setInterval(() => {
      get_users();
    }, 5000);
  });
</script>

<body>
  <a class="home_link" href="./home.php">戻る</a>
  <div class="all_users"></div>
  <button class="delete_company">会社を削除</button>
</body>

</html>