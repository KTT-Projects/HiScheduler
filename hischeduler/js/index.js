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
  ThisMonth--;
  if (ThisMonth == 0) {
      ThisMonth = 12;
      ThisYear--;
  }
  func();
}

// 次の月表示
function next() {
  showDate.setMonth(showDate.getMonth() + 1);
  showProcess(showDate);
  ThisMonth++;
  if (ThisMonth == 13) {
      ThisMonth = 1;
      ThisYear++;
  }
  func();
}

// カレンダー表示
function showProcess(date) {
  var year = date.getFullYear();
  var month = date.getMonth();
  document.querySelector("#header").innerHTML =
    year + "年 " + (month + 1) + "月";

  var calendar = createProcess(year, month);
  document.querySelector("#calendar").innerHTML = calendar;
  // console.log(calendar)
}

// カレンダー作成
function createProcess(year, month) {
  // 曜日
  var calendar = "<div id='calendar_body'>";
  for (var i = 0; i < week.length; i++) {
    calendar += "<div class='day'>" + week[i] + "</div>";
  }

  var count = 0;
  var startDayOfWeek = new Date(year, month, 1).getDay();
  var endDate = new Date(year, month + 1, 0).getDate();
  var lastMonthEndDate = new Date(year, month, 0).getDate();
  var row = Math.ceil((startDayOfWeek + endDate) / week.length);

  // 1行ずつ設定
  for (var i = 0; i < row; i++) {
    // 1colum単位で設定
    for (var j = 0; j < week.length; j++) {
      if (i == 0 && j < startDayOfWeek) {
        // 1行目で1日まで先月の日付を設定
        calendar +=
          // "<td class='disabled click'>" +
          "<div class='disabled click'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</div>"
      } else if (count >= endDate) {
        // 最終行で最終日以降、翌月の日付を設定
        count++;
        calendar += "<div class='disabled click'>" + (count - endDate) + "</div>";
      } else {
        // 当月の日付を曜日に照らし合わせて設定
        count++;
        if (
          year == today.getFullYear() &&
          month == today.getMonth() &&
          count == today.getDate()
        ) {
          calendar += "<div class='today Data" + count + "'>" + count + "<span class='w_day'>" + '(' + week[j] + ')' + "</span>" + "</div>";
        } else {
          calendar += "<div class='Data" + count + "'>" + count + "<span class='w_day'>" + '(' + week[j] + ')' + "</span>" + "</div>";
        }
      }
    }
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
      let time_s = start_time.split(' ');
      let time_e = end_date_time.split(' ');
      let time_ss = time_s[1];
      let time_es = time_e[1];
      time_ss = time_ss.replace(':00', '');
      time_es = time_es.replace(':00', '');
      let next_html = '<br><div class="main_contents"><span id="' + id + '" class="contents">' + '<span class="contents_title">' + Name + '</span>' + '<br>' + '<div class="orign"><div class="left"><button class="open_spec" id="' + id + '_" onclick="open_spec(' + id + ')">詳細</button></div><div class="right"><a class="pdf_paths" href="' + pdf_path + '" target="_blank" rel="noreferrer noopener">PDF</a></div></div><span class="hidden_s" hidden="true" id="' + id + '_closed">' + company + '<br>' + activity_data[i]["details"] + '<br>' + time_ss + ' 〜 ' + time_es + '<br><button class="activity_join_button" id="#' + id + '" onclick="join_activity(' + id + ')">参加</span></span></div>';
      if (!(prev.includes(test))) {
        $(where).append(next_html);
      }
    }
  }
}