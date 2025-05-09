<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Roboto Mono', 'Courier New', monospace;
        }
    </style>

</head>

<body>
    <h2>三角形</h2>
    <?php
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if($i >= $j){
            echo "*";
        }
    }
    echo "<br>";
}
?>
    <h2>倒三角形</h2>
    <?php    
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if($i <= $j){
            echo "*";
        }
    }
    echo "<br>";
}
?>


    <h2>正三角形</h2>
    <?php
for($i = 0; $i < 5; $i++){
    for($k = 0; $k < 5 - $i - 1; $k++){
        echo "&nbsp;";
    }
    for($j = 0; $j < $i * 2 + 1; $j++){
        echo "*";
    }

    echo "<br>";
}
?>

    <h2>正三角形</h2>
    <?php
$rows = 5;
for($i = 0; $i < $rows; $i++){
    for($k = 0; $k < $rows - $i - 1; $k++){
        echo "&nbsp;";
    }

    for($j = 0; $j < $i * 2 + 1; $j++){
        echo "*";
    }

    echo "<br>";
}
?>
    <h2>菱形</h2>
    <?php

$stars=11;

if($stars%2==0){
    $stars=$stars+1;
}

for($i=0;$i<$stars;$i++){

    if($i<=floor($stars/2)){
        $y=$i;
    }else{
        $y=$stars-1-$i;
    }

    for($j=0;$j<floor($stars/2)-$y;$j++){
        echo "&nbsp;";
    }

    for($k=0;$k<$y*2+1;$k++){
        echo "*";
    }
    echo "<br>";
}
?>
    <h2>矩形</h2>
    <?php
$w=5;
for($i = 0; $i < $w;$i++){

    for($j = 0;$j < $w;$j++){
        
        if($i == 0 || $i == $w-1 || $j == 0 || $j == $w-1){
            echo "*";}
            else{
            echo "&nbsp;";
        }
            }
        echo "<br>";
            }
?>
    <h2>矩形對角線</h2>
    <?php
    $w=5;
    for($i = 0; $i < $w;$i++){

        for($j = 0;$j < $w;$j++){
            
            if($i == 0 || $i == $w-1 || $j == 0 || $j == $w-1 || $i == $j || $i== $w-1-$j){
                echo "*";}
                else{
                echo "&nbsp;";
            }
                }
            echo "<br>";
                }
    ?>

<h2>菱形對角</h2>
    <?php

$stars=11;

if($stars%2==0){
    $stars=$stars+1;
}

for($i=0;$i<$stars;$i++){

    if($i<=floor($stars/2)){
        $y=$i;
    }else{
        $y=$stars-1-$i;
    }

    for($j=0;$j<floor($stars/2)-$y;$j++){
        echo "&nbsp;";
    }

    for($k=0;$k<$y*2+1;$k++){
        if($y+$k+$j == 4 || abs($y-($k+$j)) == 4){
            echo "*";
        }

    }
    echo "<br>";
}
?>
</body>

</html>