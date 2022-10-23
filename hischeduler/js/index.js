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
function prev() {
  showDate.setMonth(showDate.getMonth() - 1);
  showProcess(showDate);
  setTimeout("func();", 1000);
  ThisMonth--;
}

// 次の月表示
function next() {
  showDate.setMonth(showDate.getMonth() + 1);
  showProcess(showDate);
  setTimeout("func();", 1000);
  ThisMonth++;
}

// カレンダー表示
function showProcess(date) {
  var year = date.getFullYear();
  var month = date.getMonth();
  document.querySelector("#header").innerHTML =
    year + "年 " + (month + 1) + "月";

  var calendar = createProcess(year, month);
  document.querySelector("#calendar").innerHTML = calendar;
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
        calendar +=
          "<td class='disabled click'>" +
          (lastMonthEndDate - startDayOfWeek + j + 1) +
          "</td>";
      } else if (count >= endDate) {
        // 最終行で最終日以降、翌月の日付を設定
        count++;
        calendar += "<td class='disabled click'>" + (count - endDate) + "</td>";
      } else {
        // 当月の日付を曜日に照らし合わせて設定
        count++;
        if (
          year == today.getFullYear() &&
          month == today.getMonth() &&
          count == today.getDate()
        ) {
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
setTimeout("func();", 1000);
setInterval(() => {
  setTimeout("func();", 1000);
}, 5000);
function func() {
  let DateMonth, DateYear, company, id;
  for (let i = 0; i < activity_data.length; i++) {
    DateMonth = activity_data[i]["month"];
    DateYear = activity_data[i]["year"];
    DAY = activity_data[i]["day"];
    Name = activity_data[i]["name"];
    company = activity_data[i]["company"];
    id = activity_data[i]["id"];
    if (ThisMonth == DateMonth && ThisYear == DateYear) {
      if (DAY == 1) {
        let prev = document.querySelector(".Data1").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data1").append(next_html);
        }
      } else if (DAY == 2) {
        let prev = document.querySelector(".Data2").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data2").append(next_html);
        }
      } else if (DAY == 3) {
        let prev = document.querySelector(".Data3").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data3").append(next_html);
        }
      } else if (DAY == 4) {
        let prev = document.querySelector(".Data4").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data4").append(next_html);
        }
      } else if (DAY == 5) {
        let prev = document.querySelector(".Data5").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data5").append(next_html);
        }
      } else if (DAY == 6) {
        let prev = document.querySelector(".Data6").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data6").append(next_html);
        }
      } else if (DAY == 7) {
        let prev = document.querySelector(".Data7").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data7").append(next_html);
        }
      } else if (DAY == 8) {
        let prev = document.querySelector(".Data8").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data8").append(next_html);
        }
      } else if (DAY == 9) {
        let prev = document.querySelector(".Date9").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Date9").append(next_html);
        }
      } else if (DAY == 10) {
        let prev = document.querySelector(".Data11").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data11").append(next_html);
        }
      } else if (DAY == 11) {
        let prev = document.querySelector(".Data12").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data12").append(next_html);
        }
      } else if (DAY == 12) {
        let prev = document.querySelector(".Data13").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data13").append(next_html);
        }
      } else if (DAY == 14) {
        let prev = document.querySelector(".Data14").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data14").append(next_html);
        }
      } else if (DAY == 15) {
        let prev = document.querySelector(".Data15").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data15").append(next_html);
        }
      } else if (DAY == 16) {
        let prev = document.querySelector(".Data16").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data16").append(next_html);
        }
      } else if (DAY == 17) {
        let prev = document.querySelector(".Data17").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data17").append(next_html);
        }
      } else if (DAY == 18) {
        let prev = document.querySelector(".Data18").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data18").append(next_html);
        }
      } else if (DAY == 19) {
        let prev = document.querySelector(".Data19").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data19").append(next_html);
        }
      } else if (DAY == 20) {
        let prev = document.querySelector(".Data20").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data20").append(next_html);
        }
      } else if (DAY == 21) {
        let prev = document.querySelector(".Data21").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data21").append(next_html);
        }
      } else if (DAY == 22) {
        let prev = document.querySelector(".Data22").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data22").append(next_html);
        }
      } else if (DAY == 23) {
        let prev = document.querySelector(".Data23").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data23").append(next_html);
        }
      } else if (DAY == 24) {
        let prev = document.querySelector(".Data24").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data24").append(next_html);
        }
      } else if (DAY == 25) {
        let prev = document.querySelector(".Data25").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data25").append(next_html);
        }
      } else if (DAY == 26) {
        let prev = document.querySelector(".Data26").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data26").append(next_html);
        }
      } else if (DAY == 27) {
        let prev = document.querySelector(".Data27").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data27").append(next_html);
        }
      } else if (DAY == 28) {
        let prev = document.querySelector(".Data28").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data28").append(next_html);
        }
      } else if (DAY == 29) {
        let prev = document.querySelector(".Data29").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data29").append(next_html);
        }
      } else if (DAY == 30) {
        let prev = document.querySelector(".Data30").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data30").append(next_html);
        }
      } else if (DAY == 31) {
        let prev = document.querySelector(".Data31").innerHTML;
        let next_html = '<br><span id="' + id + '" class="contents">' + Name + ' (' + company + ')</span>';
        if (!(prev.includes(next_html))) {
          $(".Data31").append(next_html);
        }
      }
    }
  }
}
