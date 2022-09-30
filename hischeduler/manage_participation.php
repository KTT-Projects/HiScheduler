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
if (!isset($_SESSION['NAME'])) {
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
        // 参加研修id取得処理
        function get_participation() {
            let company;
            company = '<?php if (isset($_SESSION['COM'])) {
                            echo $_SESSION['COM'];
                        } ?>';
            let area = '<?php echo $_SESSION['AREA'] ?>';
            let name = '<?php echo $_SESSION['NAME'] ?>';
            let data10 = {
                'ajax': 10,
                'area': area,
                'company': company,
                'name': name
            }
            $.ajax({
                    dataType: 'json',
                    url: './data.php',
                    type: 'post',
                    data: data10
                })
                .done(function(data, dataType) {
                    get_activities_from_id(data);
                });
        }
        // 参加研修取得処理
        function get_activities_from_id(ids) {
            let data11 = {
                'ajax': 11,
                'ids': ids
            }
            $.ajax({
                    dataType: 'json',
                    url: './data.php',
                    type: 'post',
                    data: data11
                })
                .done(function(data, dataType) {
                    if ($('.activities').html() != data) {
                        $('.activities').html(data);
                        cancel_activity_click();
                    }
                })
        }
        // クリック時処理アップデート関数
        function cancel_activity_click() {
            $('.cancel_activity').click(function() {
                if (confirm('本当にこの研修の参加を取り消しますか？')) {
                    cancel_activity($(this).attr('id'));
                }
            });
        }
        // 研修キャンセル処理
        function cancel_activity(id) {
            let data12 = {
                'ajax': 12,
                'company': '<?php echo $_SESSION['COM'] ?>',
                'area': '<?php echo $_SESSION['AREA'] ?>',
                'name': '<?php echo $_SESSION['NAME'] ?>',
                'cancel': id
            }
            $.ajax({
                    dataType: 'json',
                    url: './data.php',
                    type: 'post',
                    data: data12
                })
                .done(function(data, dataType) {
                    console.log(data);
                    get_participation();
                });
        }
        // 初期実行
        get_participation();
        // 定期実行
        setInterval(() => {
            get_participation();
        }, 5000);
    });
</script>

<body>
    <a href="./home.php">戻る</a>
    <div class="activities"></div>
</body>

</html>