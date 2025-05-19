<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生管理系統</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "header.php"; ?>
    <?php include "nav.php"; ?>
    <?php  
        $page=isset($_GET['page']) ? $_GET['page'] : 'main';
       
    
    ?>
    <?php include "footer.php"; ?>
</body>

</html>