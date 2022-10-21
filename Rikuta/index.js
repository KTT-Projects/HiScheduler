const week = ["日", "月", "火", "水", "木", "金", "土"];
const today = new Date();
// 月末だとずれる可能性があるため、1日固定で取得
var showDate = new Date(today.getFullYear(), today.getMonth(), 1);
var ThisMonth = today.getMonth() + 1;
var ThisYear = today.getFullYear();

// 初期表示
window.onload = function () {
    showProcess(today, calendar);
};
// 前の月表示
function prev(){
    showDate.setMonth(showDate.getMonth() - 1);
    showProcess(showDate);
    setTimeout('func();', 1000);
    ThisMonth--
} 

// 次の月表示
function next() {
    showDate.setMonth(showDate.getMonth() + 1);
    showProcess(showDate);
    setTimeout('func();', 1000);
    ThisMonth++
}

// カレンダー表示
function showProcess(date) {
    var year = date.getFullYear();
    var month = date.getMonth();
    document.querySelector('#header').innerHTML = year + "年 " + (month + 1) + "月";

    var calendar = createProcess(year, month);
    document.querySelector('#calendar').innerHTML = calendar;
}

// カレンダー作成
function createProcess(year, month) {
    // 曜日
    var calendar = "<table><tr class='dayOfWeek'>";
    for (var i = 0; i < week.length; i++) {
        calendar += "<th>" + week[i] + "</th>";
    }
    calendar += "</tr>";

    var count = 0;
    var startDayOfWeek = new Date(year, month, 1).getDay();
    var endDate = new Date(year, month + 1, 0).getDate();
    var lastMonthEndDate = new Date(year, month, 0).getDate();
    var row = Math.ceil((startDayOfWeek + endDate) / week.length);

    // 1行ずつ設定
    for (var i = 0; i < row; i++) {
        calendar += "<tr>";
        // 1colum単位で設定
        for (var j = 0; j < week.length; j++) {
            if (i == 0 && j < startDayOfWeek) {
                // 1行目で1日まで先月の日付を設定
                calendar += "<td class='disabled click'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</td>";
            } else if (count >= endDate) {
                // 最終行で最終日以降、翌月の日付を設定
                count++;
                calendar += "<td class='disabled click'>" + (count - endDate) + "</td>";
            } else {
                // 当月の日付を曜日に照らし合わせて設定
                count++;
                if(year == today.getFullYear()
                    && month == (today.getMonth())
                    && count == today.getDate()){
                    calendar += "<td class='today Data" + count + "'>" + count + "</td>";
                } else {
                    calendar += "<td class='Data" + count + "'>" + count + "</td>";
                }
            }
        }
        calendar += "</tr>";
    }
    return calendar;
}

// // 研修データ取得
const date = { name:'今田', start:'2022-11-13 11:00:00', end:'2022-11-15 11:00:00', details:'実験用', path:'../pdf/a.pdf', DAY:'1', Month:'10', Year:'2022' }
const Name = date['name']
const start = date['start']
const end = date['end']
const DAY = date['DAY']
console.log(date)

const DateMonth = date['Month']
const DateYear = date['Year']

setTimeout('func();', 1000);

function func() {
    if (ThisMonth == DateMonth && ThisYear == DateYear) {
        if (DAY == 1) {
            document.querySelector(".Data1").innerHTML = "1<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 2) {
            document.querySelector(".Data2").innerHTML = "2<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 3) {
            document.querySelector(".Data3").innerHTML = "3<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 4) {
            document.querySelector(".Data4").innerHTML = "4<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 5) {
            document.querySelector(".Data5").innerHTML = "5<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 6) {
            document.querySelector(".Data6").innerHTML = "5<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 7) {
            document.querySelector(".Data7").innerHTML = "6<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 8) {
            document.querySelector(".Data8").innerHTML = "8<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 9) {
            document.querySelector(".Date9").innerHTML = "9<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 10) {
            document.querySelector(".Data11").innerHTML = "10<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 11) {
            document.querySelector(".Data12").innerHTML = "12<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 12) {
            document.querySelector(".Data13").innerHTML = "13<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 14) {
            document.querySelector(".Data14").innerHTML = "14<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 15) {
            document.querySelector(".Data15").innerHTML = "15<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 16) {
            document.querySelector(".Data16").innerHTML = "16<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 17) {
            document.querySelector(".Data17").innerHTML = "17<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 18) {
            document.querySelector(".Data18").innerHTML = "18<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 19) {
            document.querySelector(".Data19").innerHTML = "19<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 20) {
            document.querySelector(".Data20").innerHTML = "20<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 21) {
            document.querySelector(".Data21").innerHTML = "21<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 22) {
            document.querySelector(".Data22").innerHTML = "22<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 23) {
            document.querySelector(".Data23").innerHTML = "23<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 24) {
            document.querySelector(".Data24").innerHTML = "24<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 25) {
            document.querySelector(".Data25").innerHTML = "25<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 26) {
            document.querySelector(".Data26").innerHTML = "26<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 27) {
            document.querySelector(".Data27").innerHTML = "27<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 28) {
            document.querySelector(".Data28").innerHTML = "28<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 29) {
            document.querySelector(".Data29").innerHTML = "29<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 30) {
            document.querySelector(".Data30").innerHTML = "30<br><span class='contents'>" + Name + "</span>"
        } else if (DAY == 31) {
            document.querySelector(".Data31").innerHTML = "31<br><span class='contents'>" + Name + "</span>"
        } 
    }
}