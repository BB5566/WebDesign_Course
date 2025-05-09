<?php
$lotterynum = [];
while (count($lotterynum) < 6) {
    $num = rand(1, 49);
    if (!in_array($num, $lotterynum)) {
        $lotterynum[] = $num;
    }
}
foreach ($lotterynum as $num) {
    echo $num . ",";
}


echo "<br>" . "GPT寫法" . "<br>";
//第二種寫法

// 建立一個包含 1 到 49 的陣列
$pool = range(1, 49);

// 將整個號碼池打亂順序
shuffle($pool);

// 取出前 6 個號碼
$lotterynum = array_slice($pool, 0, 6);

// 將這 6 個號碼排序
sort($lotterynum);

// 輸出每個號碼
foreach ($lotterynum as $num) {
    echo $num . " ";
}


