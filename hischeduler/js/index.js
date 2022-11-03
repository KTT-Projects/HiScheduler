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
    start_time = activity_data[i]["start"];
    end_date_time = activity_data[i]["end"];
    pdf_path = activity_data[i]["path"];
    if (ThisMonth == DateMonth && ThisYear == DateYear) {
      let where = '.Data' + Number(DAY);
      let prev = $(where).html();
      let test = 'id="' + id + '"';
      let next_html = '<br><span id="' + id + '" class="contents">' + Name + '<button class="open_spec" id="' + id + '_" onclick="open_spec(' + id + ')">詳細</button><span class="hidden_s" hidden="true" id="' + id + '_closed"><br>' + company + '<br>' + activity_data[i]["details"] + '<br>開始：' + start_time + '<br>終了：' + end_date_time + '<br><a class="pdf_paths" href="' + pdf_path + '">PDF</a><br><button class="activity_join_button" id="#' + id + '" onclick="join_activity(' + id + ')">参加</span></span>';
      if (!(prev.includes(test))) {
        $(where).append(next_html);
      }
    }
  }
}
