<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  $str = "abdcdd12542";
  echo "原始字串密碼為:$str<br>";

  $str = preg_replace("/[a-z0-9]/", "*", $str);
  echo "使用preg_replace替換為$str";
  echo "<br>";
  var_dump($str);
  echo "<br>";
  echo "<hr>";
  $str = "abdcdd12542";
  $str = str_repeat("*", strlen($str));
  echo '使用str_repeat，輸出星號，字數以strlen($str)決定' . $str;
  echo "<br>";
  var_dump($str);
  echo "<br>";
  ?>
  <h3>字串分割</h3>
  <p>將”this,is,a,book”依”,”切割後成為陣列</p>
  <?php
  $str2 = "this,is,a,book";
  $str2 = explode(",", $str2);
  var_dump($str2);
  echo "<br>";
  ?>


  <h3>字串組合</h3>
  <p>將上例陣列重新組合成“this is a book”</p>
  <?php
  $text = "$str2[0] $str2[1] $str2[2] $str2[3]";
  echo $text;
  echo "<br>";
  $text = implode(" ", $str2);
  echo "<br>";
  echo $text;
  echo "<br>";
  echo "print_r";
  print_r($text);
  echo "<br>";
  var_dump($text);
  echo "<br>";
  ?>
  <h3>字串分割</h3>
  <p>The reason why a great man is great is that he resolves to be a great man</p>

  <?php
  $str3 = "The reason why a great man is great is that he resolves to be a great man";
  $str3 = mb_substr($str3, 0, 15);
  echo $str3 . "...";
  ?>
  <h3>尋找字串與HTML、css整合應用</h3>

  <p>
    給定一個句子，將指定的關鍵字放大
    “學會PHP網頁程式設計，薪水會加倍，工作會好找”
    請將上句中的 “程式設計” 放大字型或變色.
  </p>

  <?php
  $str = "學會PHP網頁程式設計，薪水會加倍，工作會好找";
  $keyword = "薪水";
  $style = "font-size:20pt;color:red;background-color:yellow;border:black 1px solid";
  $str = str_replace("$keyword", "<a style='$style'> $keyword </a>", $str);
  echo $str;
  ?>
  <br>
  <?php
  $text = "王文洋被爆包養小50歲「學生妹」、藏私生子 拒驗DNA遭討10億
2025-05-13 09:27 聯合新聞網／ 綜合報導

74歲宏仁集團總裁王文洋被爆料疑似在5年前包養一名20多歲的學生妹，對方為他生下一名兒子，而男童再過不久就要上小學了，女方希望可以「認祖歸宗」，但王文洋拒絕，認為孩子非兩人所生，女方告上法院並開價和解金逾10億元。

《鏡週刊》報導，王文洋傳出透過交友網站認識自稱「學生妹」的宋姓女子，宋女年紀僅20多歲，身高163公分，長相甜美，曾在交友網站徵友，希望包養她的人可以金援她完成學業，價錢可議。而王文洋與她長期發生性關係後，女方懷孕選擇將孩子生下，如今小孩已5歲。

然而有知情人士指出，王文洋並非直接透過交友網站認識女方，其實是透過中間人的介紹，且與女方無感情上的實質基礎，雙方多次見面純粹只是發生關係，女方也沒有強烈要求王文洋做好防護措施。

由於王文洋拒認小孩，女方聲稱握有當時往來的錄音檔，內容提到分擔扶養、教育及生活等支付，也提到要驗DNA認親。王文洋因不想再衍生風波，傳已給了數千萬元予女方，過程也被女方陳報法院當證據，表示王文洋有照顧過母子的事實。

此案因雙方協商多次，王文洋擔心自己被設局，早已給了一筆錢，如今女方又向法院提起確認親子關係訴訟，希望小孩認祖歸宗，且開價高達10億元，雙方達不成共識，法院將擇期再開庭審理。";

  $keywords = ["王文洋", "學生妹", "交友網站"];
  $style = [
    "font-size:20pt;color:red;background-color:yellow;border:black 1px solid;",
    "font-size:20pt;color:blue;background-color:yellow;border:black 1px solid;",
    "font-size:20pt;color:green;background-color:yellow;border:black 1px solid;"
  ];
  $url = ["https://udn.com/news/story/7315/8735547", "", ""];

  foreach ($keywords as $index => $word) {
    if ($url[$index] != "") {
      $texturl = "<a href='$url[$index]'>$word</a>";
    } else {
      $texturl = $word;
    }
    $textwithstyle = "<span style='$style[$index]'>$texturl</span>";
    $text = str_replace($word, $textwithstyle, $text);
  }

  echo $text;
  echo "<br>";
  var_dump($index);
    echo "<br>";
  var_dump($url);
    echo "<br>";

  var_dump($style);


  ?>

</body>

</html>