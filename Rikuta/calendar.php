<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/calendar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e4a9507649.js" crossorigin="anonymous"></script>
    <title>カレンダー</title>
</head>
<body>
<header>
    <div>
        <!-- ホームに戻るボタン欲しいかも一応HiSchedulerのロゴ押しても戻れる -->
        <h1><a href="../index.html">HiScheduler</a></h1>
    </div>
    <!-- あったほうがよかったら追加する -->
    <div class="home">
        <!-- <p><a href="index.html">Home</a></p> -->
    </div>
    <!-- カレンダースクロールせずに見えるようにしたい -->
</header>

    <div class="wrapper">
        <!-- xxxx年xx月を表示 -->
        <h1 id="header"></h1>
    
        <!-- ボタンクリックで月移動 -->
        <div id="next-prev-button">
            <button id="prev" onclick="prev()">‹</button>
            <button id="next" onclick="next()">›</button>
        </div>
    
        <!-- カレンダー -->
        <div id="calendar"></div>

    </div>
    <div class="addactivity">
    <button onclick="window.open('add_activity.php')" value"add_activityのボタン"">+</button>
    </div>

    <div class="experiment">
    </div>

<script type="text/javascript" src="../js/calendar.js"></script>
</body>
