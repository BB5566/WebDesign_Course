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
for($i = 0; $i < 5; $i++){
    for($k = 0; $k < 5 - $i - 1; $k++){
        echo "&nbsp;";
    }
    for($j = 0; $j < $i * 2 + 1; $j++){
        echo "*";
    }
    for($k = 0; $k < 4 - $i - 1; $k++){
        echo "&nbsp;";
    }
    for($j = 9; $j < $i * 2 + 1; $j--){
        echo "*";
    }

    echo "<br>";
}

    ?>