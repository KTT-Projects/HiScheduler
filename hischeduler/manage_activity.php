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
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./manage_admin.css">
  <script src="./jquery.js"></script>
  <title>HiScheduler || 研修スケジューラー</title>
</head>

<script>
  // 研修削除処理
  function remove_activity(id) {
    if (confirm('本当にこの研修を削除しますか？')) {
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
  }
  // 研修編集処理
  function edit_activity(id) {
    $('#modalArea').fadeIn();
    let data15 = {
      'ajax': 15,
      'id': id
    }
    $.ajax({
        dataType: 'json',
        url: './data.php',
        type: 'post',
        data: data15
      })
      .done(function(data, dataType) {
        
        get_activities();
      });
  }
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
        let html_data = '';
        for (let i = 0; i < data.length; i++) {
          const element = data[i];
          let delete_button = '<button id="' + element['id'] + '" class="remove_activity" onclick="remove_activity(' + element['id'] + ')">削除</button>';
          let edit_button = '<button id="edit' + element['id'] + '" class="edit_activity" onclick="edit_activity(' + element['id'] + ')">編集</button>';
          html_data = html_data + '<div class="activity"><ul class="activity_container"><li class="activity_name">' + element['name'] + '</li><li class="activity_start">開始：' + element['start'] + '</li><li class="activity_end">終了：' + element['end'] + '</li><li class="activity_details">概要：' + element['details'] + '</li><li class="activity_end"><a class="pdf" href="' + element['pdf_path'] + '" target="_blank" rel="noreferrer noopener">PDF</a></li></ul>' + edit_button + delete_button + '</div>';
        }
        if ($('.activities').html() != html_data) {
          $('.activities').html(html_data);
        }
      });
  }
  $(document).ready(function() {
    // モーダルウィンドウ
    $('#closeModal , #modalBg').click(function() {
      $('#modalArea').fadeOut();
    });
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
  <section id="modalArea" class="modalArea">
    <div id="modalBg" class="modalBg"></div>
    <div class="modalWrapper">
      <div class="modalContents">
        <form method="post" class="add_activity first_form" enctype="multipart/form-data">
          <div class="form_flex">
            <div class="form_one">
              <label for="activity_name">研修名</label><br>
              <label for="activity_start_date">開始日</label><br>
              <label for="activity_start_time">開始時刻</label><br>
              <!-- <label for="activity_end_date">終了日</label><br> -->
              <label for="activity_end_time">終了時刻</label><br>
              <label for="activity_details">概要</label><br>
            </div>
            <div class="form_two">
              <input type="text" name="activity_name" value=""><br>
              <input type="date" name="activity_start_date" value=""><br>
              <input type="time" name="activity_start_time" value=""><br>
              <input type="time" name="activity_end_time" value=""><br>
              <textarea name="activity_details"></textarea><br>
              <input type="file" name="activity_pdf" class="activity_pdf_c" accept=".pdf"><br>
              <input type="submit" value="追加" name="add_activity_submit">
            </div>
          </div>
        </form>
      </div>
      <div id="closeModal" class="closeModal">
        ×
      </div>
    </div>
  </section>
  <div class="activities"></div>
</body>

</html>