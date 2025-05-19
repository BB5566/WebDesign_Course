<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生管理系統</title>
    <!-- 連結style.css樣式 -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- include header.php 頂端列 -->
    <?php include "header.php";    ?> <!-- 載入網站頂部(header)內容 -->

    <?php
    // 取得網址參數 page，若無則預設為'main'
    $page = $_GET['page'] ?? 'main';

    // 組合要載入的檔案名稱，例如 'about' -> 'about.php'
    $file = $page . ".php";

    // 檢查檔案是否存在，存在就載入對應內容
    if (file_exists($file)) {
        include $file; // 載入指定頁面內容
    } else {
        include "main.php"; // 若檔案不存在，載入主頁(main.php)
    }

    /*  
        備用寫法（已註解）：
        用 switch-case 決定要載入哪個頁面，比較安全但需手動維護。
        switch($page){
            case 'list':
                include "list.php";
                break;
            case 'new':
                include "new.php";
                break;
            case 'query':
                include "query.php";
                break;
            case 'about':
                include "about.php";
                break;
            default:
                include "main.php";
        }
    */
    ?>

    <?php include "footer.php"; ?> <!-- 載入網站底部(footer)內容 -->
</body>

</html>
