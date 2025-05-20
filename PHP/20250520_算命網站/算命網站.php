<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ====== 命理資料產生函式 ======
function getZodiac($month, $day) {
    $zodiac = [
        ['name'=>'摩羯座', 'start'=>[1,1],   'end'=>[1,19]],
        ['name'=>'水瓶座', 'start'=>[1,20],  'end'=>[2,18]],
        ['name'=>'雙魚座', 'start'=>[2,19],  'end'=>[3,20]],
        ['name'=>'牡羊座', 'start'=>[3,21],  'end'=>[4,19]],
        ['name'=>'金牛座', 'start'=>[4,20],  'end'=>[5,20]],
        ['name'=>'雙子座', 'start'=>[5,21],  'end'=>[6,20]],
        ['name'=>'巨蟹座', 'start'=>[6,21],  'end'=>[7,22]],
        ['name'=>'獅子座', 'start'=>[7,23],  'end'=>[8,22]],
        ['name'=>'處女座', 'start'=>[8,23],  'end'=>[9,22]],
        ['name'=>'天秤座', 'start'=>[9,23],  'end'=>[10,23]],
        ['name'=>'天蠍座', 'start'=>[10,24], 'end'=>[11,22]],
        ['name'=>'射手座', 'start'=>[11,23], 'end'=>[12,21]],
        ['name'=>'摩羯座', 'start'=>[12,22], 'end'=>[12,31]]
    ];
    foreach ($zodiac as $z) {
        if (
            ($month == $z['start'][0] && $day >= $z['start'][1]) ||
            ($month == $z['end'][0] && $day <= $z['end'][1])
        ) {
            return $z['name'];
        }
    }
    return '未知';
}
function getWuXingDistribution() {
    $base = [rand(1,4), rand(1,4), rand(1,4), rand(1,4), rand(1,4)];
    $sum = array_sum($base);
    $target = 10;
    $factor = $target / $sum;
    foreach($base as &$v) $v = round($v * $factor);
    $diff = $target - array_sum($base);
    $base[0] += $diff;
    return $base;
}
function getZiweiBar($stars) {
    $starList = explode('、', str_replace('入命宮','',$stars));
    $data = [];
    foreach($starList as $s) {
        $data[$s] = rand(60,100);
    }
    return $data;
}
function getAnnualTrend() {
    $years = [];
    $values = [];
    $currentYear = (int)date('Y');
    for ($i = 4; $i >= 0; $i--) {
        $years[] = $currentYear - $i;
        $values[] = rand(50, 100);
    }
    return ['years' => $years, 'values' => $values];
}
function getPersonalStrengthRadar() {
    $categories = ['智慧','勇氣','耐心','創意','人緣','決斷力'];
    $scores = [];
    foreach ($categories as $cat) {
        $scores[] = rand(60, 100);
    }
    return ['categories' => $categories, 'scores' => $scores];
}
function getHealthIndexBar() {
    $indices = ['心肺功能', '免疫力', '精神狀態', '睡眠品質', '飲食習慣'];
    $values = [];
    foreach ($indices as $idx) {
        $values[] = rand(50, 100);
    }
    return ['indices' => $indices, 'values' => $values];
}
function getWuXingDescription($wuxing) {
    $elements = ['木','火','土','金','水'];
    $maxIdx = array_keys($wuxing, max($wuxing))[0];
    $desc = [
        0 => '木旺：具創意、仁慈，適合教育與設計領域，多接觸大自然有助運勢。',
        1 => '火旺：熱情、積極，適合領導與行銷，注意情緒管理。',
        2 => '土旺：務實、穩重，適合金融與地產，宜多運動調節身心。',
        3 => '金旺：果斷、執行力強，適合法律、管理，建議多與人交流。',
        4 => '水旺：聰明、適應力佳，適合創意與傳播，注意腎臟與泌尿健康。'
    ];
    return $desc[$maxIdx];
}
function getZiweiDescription($ziwei) {
    $stars = [
        '紫微'=>'領導力強，適合管理、教育。',
        '天機'=>'思維敏捷，宜從事諮詢、設計。',
        '太陽'=>'積極進取，適合外務、行銷。',
        '武曲'=>'理財能力佳，適合金融、軍警。',
        '天同'=>'善良溫和，適合服務、教育。',
        '廉貞'=>'果敢堅毅，適合管理、司法。',
        '天府'=>'穩重可靠，適合行政、管理。',
        '太陰'=>'細膩體貼，適合藝術、醫護。',
        '貪狼'=>'多才多藝，適合創意、娛樂。',
        '巨門'=>'口才佳，適合傳媒、法律。',
        '天相'=>'協調力強，適合公職、管理。',
        '天梁'=>'正直仁愛，適合醫療、教育。',
        '七殺'=>'衝勁十足，適合創業、軍警。',
        '破軍'=>'變革創新，適合科技、冒險。'
    ];
    $mainStars = explode('、', str_replace('入命宮','', $ziwei));
    $desc = [];
    foreach($mainStars as $star) {
        if(isset($stars[$star])) $desc[] = $star.'：'.$stars[$star];
    }
    return implode('； ', $desc);
}
function getHoroscope($zodiac) {
    $horoscope = [
        '牡羊座'=>'事業穩定，財運提升，感情需耐心溝通，健康注意休息。',
        '金牛座'=>'事業有貴人，財運平穩，感情甜蜜，健康注意飲食。',
        '雙子座'=>'事業需主動，財運波動，感情多變，健康注意呼吸道。',
        '巨蟹座'=>'事業穩健，財運小進，感情和諧，健康注意腸胃。',
        '獅子座'=>'事業有突破，財運旺盛，感情熱烈，健康注意心血管。',
        '處女座'=>'事業細膩，財運穩定，感情溫和，健康注意腸胃。',
        '天秤座'=>'事業合作佳，財運平順，感情和諧，健康注意腰部。',
        '天蠍座'=>'事業進展快，財運提升，感情深刻，健康注意泌尿系統。',
        '射手座'=>'事業有機會，財運提升，感情愉快，健康注意肝膽。',
        '摩羯座'=>'事業穩步，財運穩定，感情需溝通，健康注意骨骼。',
        '水瓶座'=>'事業創新，財運穩健，感情自由，健康注意血液循環。',
        '雙魚座'=>'事業需堅持，財運平穩，感情浪漫，健康注意足部。'
    ];
    return $horoscope[$zodiac] ?? '本月運勢平穩，適合規劃未來。';
}
function getOverallAdvice($result) {
    $wuxing = $result['五行分布'];
    $wuxingMax = max($wuxing);
    $wuxingMin = min($wuxing);
    $wuxingBalance = ($wuxingMax - $wuxingMin) <= 2;
    $ziweiBar = $result['主星影響'];
    $mainStar = array_keys($ziweiBar, max($ziweiBar))[0];
    $mainStarScore = max($ziweiBar);
    $annualAvg = array_sum($result['流年運勢']['values']) / count($result['流年運勢']['values']);
    $radarAvg = array_sum($result['個人優勢雷達']['scores']) / count($result['個人優勢雷達']['scores']);
    $healthAvg = array_sum($result['健康指數']['values']) / count($result['健康指數']['values']);
    $horoscope = $result['星座運勢'];

    $advice = [];
    if($wuxingBalance) {
        $advice[] = "你的五行分布均衡，運勢較為穩定。";
    } else {
        $advice[] = "五行有強弱，建議多補足弱項五行，提升整體能量。";
    }
    $advice[] = "主星「{$mainStar}」影響力最強，建議發揮其優勢，勇於展現自我。";
    if($annualAvg >= 80) {
        $advice[] = "近年運勢整體高漲，適合積極爭取新機會。";
    } elseif($annualAvg >= 65) {
        $advice[] = "運勢平穩向上，持續努力會有收穫。";
    } else {
        $advice[] = "近期運勢起伏，宜保守穩健，耐心等待時機。";
    }
    if($radarAvg >= 85) {
        $advice[] = "個人優勢明顯，善用天賦將大有可為。";
    } elseif($radarAvg >= 70) {
        $advice[] = "綜合能力佳，建議持續精進強項。";
    } else {
        $advice[] = "可加強自信與學習，提升綜合競爭力。";
    }
    if($healthAvg >= 85) {
        $advice[] = "健康狀況良好，維持良好生活習慣即可。";
    } elseif($healthAvg >= 70) {
        $advice[] = "健康尚可，注意飲食與作息平衡。";
    } else {
        $advice[] = "健康需多留意，建議規律運動與健康檢查。";
    }
    $advice[] = "星座運勢提醒：{$horoscope}";

    return implode(' ', $advice);
}
function getLunarFortune($name, $birthday, $hour) {
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $birthday, $m)) {
        return null;
    }
    $month = intval($m[2]);
    $day = intval($m[3]);
    $zodiac = getZodiac($month, $day);

    $ganzhi = ['甲','乙','丙','丁','戊','己','庚','辛','壬','癸'];
    $zhi = ['子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥'];
    $bazi = $ganzhi[rand(0,9)].$zhi[rand(0,11)].' '.$ganzhi[rand(0,9)].$zhi[rand(0,11)];

    $stars = ['紫微','天機','太陽','武曲','天同','廉貞','天府','太陰','貪狼','巨門','天相','天梁','七殺','破軍'];
    shuffle($stars);
    $ziwei = implode('、', array_slice($stars,0,3)).'入命宮';

    $wuxing = getWuXingDistribution();
    $ziweiBar = getZiweiBar($ziwei);
    $annualTrend = getAnnualTrend();
    $personalRadar = getPersonalStrengthRadar();
    $healthBar = getHealthIndexBar();

    $wuxingDesc = getWuXingDescription($wuxing);
    $ziweiDesc = getZiweiDescription($ziwei);
    $horoscope = getHoroscope($zodiac);

    $tempResult = [
        '八字命盤' => $bazi,
        '紫微主星' => $ziwei,
        '星座' => $zodiac,
        '五行分布' => $wuxing,
        '主星影響' => $ziweiBar,
        '流年運勢' => $annualTrend,
        '個人優勢雷達' => $personalRadar,
        '健康指數' => $healthBar,
        '五行解讀' => $wuxingDesc,
        '紫微解讀' => $ziweiDesc,
        '星座運勢' => $horoscope
    ];
    $tempResult['綜合運勢'] = getOverallAdvice($tempResult);

    return $tempResult;
}
$result = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"] ?? '');
    $birthday = $_POST["birthday"] ?? '';
    $hour = $_POST["hour"] ?? '';
    $result = getLunarFortune($name, $birthday, $hour);
}
$isFormValid = (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && !empty($_POST["name"])
    && !empty($_POST["birthday"])
    && !empty($_POST["hour"])
    && $result
);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>台灣命理算命｜八字‧紫微‧星座</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fffbe7 0%, #f8b500 100%);
            font-family: 'Noto Serif TC', serif;
            margin: 0;
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
        }
        .fortune-container {
            max-width: 840px;
            margin: 40px auto 24px auto;
            background: rgba(255,255,255,0.98);
            border-radius: 22px;
            box-shadow: 0 10px 32px rgba(140,120,80,0.14);
            padding: 2.6rem 2.1rem 2rem 2.1rem;
            position: relative;
        }
        .fortune-header {
            text-align: center;
            margin-bottom: 2.1rem;
        }
        .fortune-header h1 {
            color: #c1942e;
            font-size: 2.3rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            margin: 0;
        }
        .fortune-header p {
            color: #8a6d1d;
            font-size: 1.13rem;
            margin: 0.7rem 0 0 0;
        }
        form {
            margin-bottom: 1.7rem;
        }
        .input-group {
            margin-bottom: 1.25rem;
        }
        label {
            color: #c1942e;
            font-weight: 600;
            display: block;
            margin-bottom: 0.32rem;
            font-size: 1.07rem;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #f8b500;
            border-radius: 8px;
            font-size: 1.08rem;
            font-family: 'Noto Serif TC', serif;
            background: #fffbe7;
            color: #8a6d1d;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, #f8b500 60%, #fffbe7 100%);
            color: #fff;
            font-size: 1.13rem;
            font-weight: 700;
            border: none;
            border-radius: 9px;
            padding: 0.85rem 0;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(248,181,0,0.10);
            letter-spacing: 2px;
            transition: background 0.18s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #d89b00 60%, #f8b500 100%);
        }
        .result-block {
            background: #fffbe7;
            border-radius: 12px;
            padding: 1.3rem 1rem;
            margin-bottom: 1.1rem;
            box-shadow: 0 2px 8px rgba(200,180,120,0.08);
        }
        .result-block.collapsible .block-content { display: none; }
        .result-block.collapsible.active .block-content { display: block; }
        .result-block.collapsible h3 { cursor: pointer; position: relative; }
        .result-block.collapsible h3::after {
            content: "▼";
            position: absolute; right: 0; top: 0; color: #c1942e; font-size: 0.9em;
            transition: transform 0.2s;
        }
        .result-block.collapsible.active h3::after { transform: rotate(-180deg);}
        .result-block h3 {
            color: #c1942e;
            margin: 0 0 0.5rem 0;
            font-size: 1.19rem;
        }
        .result-block p, .result-block ul {
            color: #8a6d1d;
            margin: 0;
            font-size: 1.07rem;
        }
        .footer {
            text-align: center;
            color: #c1942e;
            font-size: 0.97rem;
            margin-top: 1.7rem;
            letter-spacing: 1px;
        }
        .zodiac-tag {
            display: inline-block;
            background: linear-gradient(90deg, #fffbe7 60%, #f8b500 100%);
            color: #8a6d1d;
            border-radius: 12px;
            padding: 0.3em 1em;
            font-size: 1.06rem;
            margin-bottom: 1.1rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .chart-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 1.4rem;
            justify-content: center;
            align-items: flex-start;
            margin-bottom: 1.1rem;
        }
        .chart-box {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(200,180,120,0.10);
            padding: 1rem 1rem 0.5rem 1rem;
            margin-bottom: 0.5rem;
            flex: 1 1 330px;
            max-width: 330px;
            border: 2px solid #fff;
            transition: box-shadow 0.25s, transform 0.25s, border-color 0.25s;
            cursor: pointer;
        }
        .chart-box:hover {
            box-shadow: 0 8px 32px rgba(248,181,0,0.20);
            transform: translateY(-6px) scale(1.04);
            border-color: #f8b500;
        }
        .chart-box h3 {
            text-align: center;
            margin-bottom: 0.8rem;
            color: #c1942e;
            font-size: 1.08rem;
            letter-spacing: 1px;
        }
        /* 夜間模式 */
        body.night {
            background: linear-gradient(135deg, #232323 0%, #5c3a00 100%);
            color: #f8e7b5;
        }
        body.night .fortune-container { background: #2a2a2a; color: #f8e7b5; }
        body.night .result-block { background: #3b2f1c; color: #f8e7b5; }
        body.night input, body.night select { background: #232323; color: #f8e7b5; border-color: #a77c2a; }
        body.night input[type="submit"] { background: linear-gradient(90deg, #a77c2a 60%, #232323 100%); color: #fff; }
        /* 手機優化 */
        @media (max-width: 600px) {
            .fortune-container { padding: 1rem 0.5rem; }
            .input-group label { font-size: 1rem; }
            input, select { font-size: 1rem; padding: 0.7rem; }
            input[type="submit"] { font-size: 1.05rem; }
            .chart-box { padding: 0.5rem 0.2rem; }
        }
    </style>
</head>
<body>
    <button id="toggle-dark" style="position:fixed;top:10px;right:10px;z-index:99;">🌙 夜間</button>
    <div class="fortune-container">
        <div class="fortune-header">
            <h1>台灣命理算命</h1>
            <p>八字、紫微、星座、五行、健康、優勢一次看懂！</p>
        </div>
        <form method="POST" autocomplete="off">
            <div class="input-group">
                <label for="name">姓名</label>
                <input type="text" name="name" id="name" maxlength="8" required placeholder="請輸入姓名">
            </div>
            <div class="input-group">
                <label for="birthday">出生日期</label>
                <input type="date" name="birthday" id="birthday" required>
            </div>
            <div class="input-group">
                <label for="hour">出生時辰</label>
                <select name="hour" id="hour" required>
                    <option value="">請選擇</option>
                    <option value="子時">子時 (23:00-00:59)</option>
                    <option value="丑時">丑時 (01:00-02:59)</option>
                    <option value="寅時">寅時 (03:00-04:59)</option>
                    <option value="卯時">卯時 (05:00-06:59)</option>
                    <option value="辰時">辰時 (07:00-08:59)</option>
                    <option value="巳時">巳時 (09:00-10:59)</option>
                    <option value="午時">午時 (11:00-12:59)</option>
                    <option value="未時">未時 (13:00-14:59)</option>
                    <option value="申時">申時 (15:00-16:59)</option>
                    <option value="酉時">酉時 (17:00-18:59)</option>
                    <option value="戌時">戌時 (19:00-20:59)</option>
                    <option value="亥時">亥時 (21:00-22:59)</option>
                </select>
            </div>
            <input type="submit" value="開始算命">
        </form>
        <?php if ($isFormValid): ?>
            <div class="zodiac-tag">
                你的星座：<?= htmlspecialchars($result['星座']) ?>
            </div>
            <div class="chart-wrap">
                <div class="chart-box">
                    <h3>五行分布圖</h3>
                    <canvas id="baziChart" width="300" height="300"></canvas>
                    <p style="text-align:center;font-size:0.98em;color:#b88a1a;">五行強弱一目瞭然</p>
                </div>
                <div class="chart-box">
                    <h3>主星影響力</h3>
                    <canvas id="ziweiBar" width="300" height="300"></canvas>
                    <p style="text-align:center;font-size:0.98em;color:#b88a1a;">紫微主星影響力分布</p>
                </div>
                <div class="chart-box">
                    <h3>流年運勢折線圖</h3>
                    <canvas id="annualTrend" width="300" height="300"></canvas>
                    <p style="text-align:center;font-size:0.98em;color:#b88a1a;">近五年整體運勢走勢</p>
                </div>
                <div class="chart-box">
                    <h3>個人優勢雷達圖</h3>
                    <canvas id="personalRadar" width="300" height="300"></canvas>
                    <p style="text-align:center;font-size:0.98em;color:#b88a1a;">六大優勢綜合評比</p>
                </div>
                <div class="chart-box">
                    <h3>健康指數條狀圖</h3>
                    <canvas id="healthBar" width="300" height="300"></canvas>
                    <p style="text-align:center;font-size:0.98em;color:#b88a1a;">身體各項健康指標</p>
                </div>
            </div>
            <div class="result-block collapsible">
                <h3>綜合運勢建議</h3>
                <div class="block-content">
                    <p style="font-weight:bold;color:#a77c2a;"><?= htmlspecialchars($result['綜合運勢']) ?></p>
                </div>
            </div>
            <div class="result-block collapsible">
                <h3>八字命盤</h3>
                <div class="block-content">
                    <p><b><?= $result['八字命盤'] ?></b></p>
                    <p style="color:#a77c2a;"><?= htmlspecialchars($result['五行解讀']) ?></p>
                    <ul>
                        <li>五行分布依據命盤隨機生成，僅供娛樂參考。</li>
                        <li>八字命盤可作為個人運勢參考，建議搭配專業命理師諮詢。</li>
                    </ul>
                </div>
            </div>
            <div class="result-block collapsible">
                <h3>紫微主星</h3>
                <div class="block-content">
                    <p><b><?= $result['紫微主星'] ?></b></p>
                    <p style="color:#a77c2a;"><?= htmlspecialchars($result['紫微解讀']) ?></p>
                    <ul>
                        <li>主星影響力為隨機模擬，真實命盤需專業軟體計算。</li>
                        <li>建議多發揮主星優勢，提升個人運勢。</li>
                    </ul>
                </div>
            </div>
            <div class="result-block collapsible">
                <h3>星座運勢</h3>
                <div class="block-content">
                    <p>星座：<?= htmlspecialchars($result['星座']) ?>，<?= htmlspecialchars($result['星座運勢']) ?></p>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            // Chart.js動畫
            const wuxingData = <?= json_encode($result['五行分布']) ?>;
            const wuxingLabels = ['木','火','土','金','水'];
            new Chart(document.getElementById('baziChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: wuxingLabels,
                    datasets: [{
                        data: wuxingData,
                        backgroundColor: ['#8bc34a','#ff7043','#ffe082','#b0bec5','#4fc3f7']
                    }]
                },
                options: { animation: { duration: 1200, easing: 'easeOutBounce' }, plugins: {legend: {display:true, position:'bottom'}} }
            });
            const ziweiBarLabels = <?= json_encode(array_keys($result['主星影響'])) ?>;
            const ziweiBarData = <?= json_encode(array_values($result['主星影響'])) ?>;
            new Chart(document.getElementById('ziweiBar').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ziweiBarLabels,
                    datasets: [{
                        label: '影響力',
                        data: ziweiBarData,
                        backgroundColor: ['#ce93d8','#ffb74d','#80cbc4']
                    }]
                },
                options: { animation: { duration: 1200, easing: 'easeOutBounce' }, indexAxis: 'y', plugins: {legend: {display:false}}, scales: {x: { min: 0, max: 100, ticks: { stepSize: 20 } } } }
            });
            const annualYears = <?= json_encode($result['流年運勢']['years']) ?>;
            const annualValues = <?= json_encode($result['流年運勢']['values']) ?>;
            new Chart(document.getElementById('annualTrend').getContext('2d'), {
                type: 'line',
                data: {
                    labels: annualYears,
                    datasets: [{
                        label: '流年運勢指數',
                        data: annualValues,
                        fill: false,
                        borderColor: '#a77c2a',
                        backgroundColor: '#a77c2a',
                        tension: 0.3
                    }]
                },
                options: { animation: { duration: 1200 }, scales: { y: { min: 0, max: 100, ticks: { stepSize: 20 } } }, plugins: { legend: { display: true, position: 'top' } } }
            });
            const personalRadarLabels = <?= json_encode($result['個人優勢雷達']['categories']) ?>;
            const personalRadarData = <?= json_encode($result['個人優勢雷達']['scores']) ?>;
            new Chart(document.getElementById('personalRadar').getContext('2d'), {
                type: 'radar',
                data: {
                    labels: personalRadarLabels,
                    datasets: [{
                        label: '個人優勢指數',
                        data: personalRadarData,
                        backgroundColor: 'rgba(167,124,42,0.18)',
                        borderColor: '#a77c2a'
                    }]
                },
                options: { animation: { duration: 1200 }, scales: { r: { min: 0, max: 100, ticks: { stepSize: 20 } } }, plugins: { legend: { display: true, position: 'top' } } }
            });
            const healthBarLabels = <?= json_encode($result['健康指數']['indices']) ?>;
            const healthBarData = <?= json_encode($result['健康指數']['values']) ?>;
            new Chart(document.getElementById('healthBar').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: healthBarLabels,
                    datasets: [{
                        label: '健康指數',
                        data: healthBarData,
                        backgroundColor: ['#ff8a65','#4db6ac','#ba68c8','#9575cd','#4fc3f7']
                    }]
                },
                options: { animation: { duration: 1200 }, indexAxis: 'y', scales: { x: { min: 0, max: 100, ticks: { stepSize: 20 } } }, plugins: { legend: { display: true, position: 'top' } } }
            });
            </script>
        <?php endif; ?>
        <div class="footer">
            <span>© 2025 台灣命理算命 | 設計 by Perplexity AI</span>
        </div>
    </div>
    <!-- UX優化：即時驗證、localStorage、夜間模式、折疊區塊 -->
    <script>
    // 夜間模式
    document.getElementById('toggle-dark').onclick = function() {
        document.body.classList.toggle('night');
    };
    // 折疊區塊
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.result-block.collapsible h3').forEach(function(h3){
            h3.addEventListener('click', function() {
                h3.parentElement.classList.toggle('active');
            });
        });
    });
    // 表單即時驗證與localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const birthdayInput = document.getElementById('birthday');
        const hourInput = document.getElementById('hour');
        const submitBtn = document.querySelector('input[type="submit"]');
        // localStorage載入
        if (localStorage.getItem('fortune_name')) nameInput.value = localStorage.getItem('fortune_name');
        if (localStorage.getItem('fortune_birthday')) birthdayInput.value = localStorage.getItem('fortune_birthday');
        if (localStorage.getItem('fortune_hour')) hourInput.value = localStorage.getItem('fortune_hour');
        function validate() {
            let valid = true;
            if (nameInput.value.trim().length < 2 || nameInput.value.trim().length > 8) {
                nameInput.style.borderColor = "#e53935"; valid = false;
            } else { nameInput.style.borderColor = "#f8b500"; }
            if (!birthdayInput.value) {
                birthdayInput.style.borderColor = "#e53935"; valid = false;
            } else { birthdayInput.style.borderColor = "#f8b500"; }
            if (!hourInput.value) {
                hourInput.style.borderColor = "#e53935"; valid = false;
            } else { hourInput.style.borderColor = "#f8b500"; }
            submitBtn.disabled = !valid;
            return valid;
        }
        nameInput.addEventListener('input', validate);
        birthdayInput.addEventListener('input', validate);
        hourInput.addEventListener('change', validate);
        validate();
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validate()) { e.preventDefault(); alert('請正確填寫所有欄位！'); }
            // localStorage儲存
            localStorage.setItem('fortune_name', nameInput.value);
            localStorage.setItem('fortune_birthday', birthdayInput.value);
            localStorage.setItem('fortune_hour', hourInput.value);
        });
    });
    </script>
</body>
</html>
