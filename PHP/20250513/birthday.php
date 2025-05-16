<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>
  <h2>計算距離自己下一次生日還有幾天</h2>
  <?php
  $birthday = "05-01"; // 自己的生日（只填月日）
  $today = date("Y-m-d");
  $todayYear = date("Y");

  // 判斷今年的生日是否已經過
  $birthdayThisYear = strtotime("$todayYear-$birthday");
  $todayTimestamp = strtotime($today);

  if ($todayTimestamp > $birthdayThisYear) {
    // 今年生日已過，算明年的
    $nextBirthday = strtotime(($todayYear + 1) . "-$birthday");
  } else {
    // 生日還沒過，就用今年的
    $nextBirthday = $birthdayThisYear;
  }

  $diffDays = ($nextBirthday - $todayTimestamp) / (60 * 60 * 24);
  echo "今天日期：$today<br>";
  echo "下一次生日是：" . date("Y-m-d", $nextBirthday) . "<br>";
  echo "距離下一次生日還有：$diffDays 天";
  ?>

</body>

</html>