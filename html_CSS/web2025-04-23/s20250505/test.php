<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- html code -->

    <table>

        <!-- 1. -->
        <!-- php 與 html 分開 -->
        <?php foreach ($variable as $key => $value) : ?>
            <tr>
                <td>

                </td>
            </tr>
        <? endforeach; ?>

        <?php
        echo "<tr>";
        echo "<td>";
        echo "</td>";
        echo "</tr>";
        ?>



    </table>
    <?php

    ?>

    <!-- php code -->
</body>

</html>