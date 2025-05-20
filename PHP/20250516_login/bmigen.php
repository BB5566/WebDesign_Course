<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BMI 計算結果</title>
  <style>
    /* 基本排版 */
    .result-container {
      max-width: 400px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-family: "Microsoft JhengHei", sans-serif;
      background-color: #f9f9f9;
    }

    .result-item {
      margin-bottom: 15px;
      text-align: center;
      font-size: 1.2rem;
    }

    /* BMI 狀態顏色 */
    .bmi-underweight {
      color: #1e90ff;
      font-weight: bold;
    }

    .bmi-normal {
      color: #28a745;
      font-weight: bold;
    }

    .bmi-overweight {
      color: #ffc107;
      font-weight: bold;
    }

    .bmi-obese1 {
      color: #fd7e14;
      font-weight: bold;
    }

    .bmi-obese2 {
      color: #dc3545;
      font-weight: bold;
    }

    .bmi-obese3 {
      color: #6f42c1;
      font-weight: bold;
    }

    a.back-link {
      display: block;
      text-align: center;
      margin-top: 25px;
      text-decoration: none;
      color: #007bff;
      font-weight: 600;
    }

    a.back-link:hover {
      text-decoration: underline;
    }

    .bmi-img {
      width: 200px;
      height: 400px;
      overflow: hidden;
      /* 防止圖片超出 */
      margin: 0 auto 15px auto;
      display: block;
      text-align: center;
    }

    .bmi-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      /* 或 contain，看你要裁切還是完整顯示 */
      display: block;
    }
  </style>
</head>

<body>
  <div class="result-container">
    <?php
    if (isset($_POST["height"])) {
      echo '<div class="result-item height-info">身高為：' . htmlspecialchars($_POST["height"]) . ' 公分</div>';
    }
    if (isset($_POST["weight"])) {
      echo '<div class="result-item weight-info">體重為：' . htmlspecialchars($_POST["weight"]) . ' 公斤</div>';
    }

    // 計算 BMI
    $height = isset($_POST["height"]) ? floatval($_POST["height"]) : 0;
    $weight = isset($_POST["weight"]) ? floatval($_POST["weight"]) : 0;

    if ($height > 0 && $weight > 0) {
      $bmi = round($weight / pow($height / 100, 2), 1);
      echo '<div class="result-item bmi-value">BMI 為：' . $bmi . '</div>';

      // 判斷 BMI 狀態並加上 class
      if ($bmi < 18.5) {
        $bmiClass = "bmi-underweight";
        $bmiStatus = "體重過輕";
      } elseif ($bmi >= 18.5 && $bmi < 24) {
        $bmiClass = "bmi-normal";
        $bmiStatus = "體重正常";
      } elseif ($bmi >= 24 && $bmi < 27) {
        $bmiClass = "bmi-overweight";
        $bmiStatus = "體重過重";
      } elseif ($bmi >= 27 && $bmi < 30) {
        $bmiClass = "bmi-obese1";
        $bmiStatus = "輕度肥胖";
      } elseif ($bmi >= 30 && $bmi < 35) {
        $bmiClass = "bmi-obese2";
        $bmiStatus = "中度肥胖";
      } else {
        $bmiClass = "bmi-obese3";
        $bmiStatus = "重度肥胖";
      }

      echo '<div class="result-item ' . $bmiClass . '">' . $bmiStatus . '</div>';
    } else {
      echo '<div class="result-item" style="color:red;">請輸入有效的身高和體重！</div>';
    }
    ?>

    <a href="./index.php" class="back-link">返回重新輸入</a>

    <div class="bmi-img"><img src="./img/generated-image (1).png"></div>
  </div>
</body>

</html>