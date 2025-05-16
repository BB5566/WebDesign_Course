<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    * {
      box-sizing: border-box;
    }

    /* table, */
    td {
      border: grey 2px dotted;
      border-collapse: collapse;
      width: 80vh;
      /* height: 40px; */
      text-align: right;
      padding-right: 10px;
      padding-bottom: 20px;
      margin: auto;
      border-radius: 50px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }



    h1 {
      text-align: center;
    }

  </style>
</head>

<body>

  <?php
  $today = date("Y-m-d");
  // 設定變數為當前時間的年月日
  $firstDay = date("Y-m-01");
  // 設定變數為當月的第一天
  $firstDayWeek = date("w", strtotime($firstDay));
  // 該月第一天是星期幾（0~6）
  $theDaysOfMonth = date("t", strtotime($firstDay));
  // 該月總天數
  ?>
  <table>

    <?php
    date_default_timezone_set("Asia/Taipei");
    // 設定時區為台北

    $month = date("m");
    // 定義當前月份
    $year = date("Y");
    // 定義當前年份
    $todaynow = date("Y-m-d H:m");
    // 現在時間的年月日時分
    $pMonth = date("n", strtotime("first day of last month"));
    // 定義下個月的月份(n)
    $nMonth = date("n", strtotime("first day of next month"));
    // 定義上個月的月份(n)


    echo "<tr>";
    echo "<th style='color:white;background-color: lightgreen;'>上個月<br>$year 年$pMonth 月</th>";
    // 顯示上個月的年份與月份
    echo "<th colspan='5' style='color:white;background-color: green;'>$year 年$month 月<br>(現在時間$todaynow</th>";
    // 顯示這個月的月份與現在時間的年月日時分
    echo "<th style='color:white;background-color: lightgreen;'>下個月<br>$year 年$nMonth 月</th>";
    // 顯示下個月的年份及月份
    echo "</tr>";
    ?>

    <tr>
      <th style="color:white;background-color: pink;">周日</th>
      <th style="color:black;background-color: lightblue;">周一</th>
      <th style="color:black;background-color: lightblue;">周二</th>
      <th style="color:black;background-color: lightblue;">周三</th>
      <th style="color:black;background-color: lightblue;">周四</th>
      <th style="color:black;background-color: lightblue;">周五</th>
      <th style="color:white;background-color: pink;">周六</th>
    </tr>

    <?php
    for ($i = 0; $i < 6; $i++) {
      echo "<tr>";

      for ($j = 0; $j < 7; $j++) {
        $day = $j + ($i * 7) - $firstDayWeek;
        $timestamp = strtotime(" $day days", strtotime($firstDay));
        $date = date("Y-m-d", $timestamp);
        $class = "";

        if (date("N", $timestamp) > 5) {
          $class = $class . " holiday";
        }

        if ($today == $date) {

          $class = $class . " today";
        } else if (date("m", $timestamp) != date("m", strtotime($firstDay))) {

          $class = $class . " other-month";
        }

        if ($timestamp < strtotime($today)) {
          $class = $class . " pass-date";
        }
        echo "<td class='$class' data-date='$date'>";
        echo "<div class='date-num'>";
        echo date("d", $timestamp);
        echo "</div>";
        echo "<div class='date-event'>";
        if (isset($spDate[$date])) {
          echo $spDate[$date];
        }
        echo "</div>";
        echo "</td>";
      }

      echo "</tr>";
    }


    ?>



    <!-- 
        //日曆第一行的星期

    <?php
    $dayCount = 1; // 計數用來顯示日期
    $printed = false;

    for ($i = 0; $i < 6; $i++) {
      echo "<tr>";
      for ($j = 0; $j < 7; $j++) {
        // 第1週且 j < 首日星期，先輸出空格
        if ($i == 0 && $j < $firstDayWeek) {
          echo "<td>&nbsp;</td>";
        } elseif ($dayCount <= $theDaysOfMonth) {
          // 顯示實際日期，並處理星期六日樣式
          if ($j == 0 || $j == 6) {
            echo "<td style='background-color: pink;'>$dayCount</td>";
          } else {
            echo "<td>$dayCount</td>";
          }
          // 其餘輸出為無STYLE日期
          $dayCount++;
        } else {
          // 超出當月天數，也輸出空格
          echo "<td>&nbsp;</td>";
        }
      }
      echo "</tr>";
    }
    ?> -->
  </table>


</body>

</html>