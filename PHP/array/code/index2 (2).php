<?php
for ($i = 2; $i <= 100; $i++) {
    for ($j = 2; $j < $i; $j++) {
        if ($i % $j == 0) {
            break; // 有被整除，不是質數，跳出
        }
    }
    if ($j == $i) { // 如果 j 跑到等於 i，代表中間沒 break 過，是質數
        echo $i . "\n";
    }
}
