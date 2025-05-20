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

function getWuXingDistribution($bazi) {
    $stemElements = [
        '甲' => '木', '乙' => '木', '丙' => '火', '丁' => '火', '戊' => '土',
        '己' => '土', '庚' => '金', '辛' => '金', '壬' => '水', '癸' => '水'
    ];
    $branchElements = [
        '子' => '水', '丑' => '土', '寅' => '木', '卯' => '木', '辰' => '土',
        '巳' => '火', '午' => '火', '未' => '土', '申' => '金', '酉' => '金',
        '戌' => '土', '亥' => '水'
    ];
    $pillars = explode(' ', $bazi);
    $elements = ['木' => 0, '火' => 0, '土' => 0, '金' => 0, '水' => 0];
    foreach ($pillars as $pillar) {
        if (strlen($pillar) >= 2) {
            $stem = mb_substr($pillar, 0, 1);
            $branch = mb_substr($pillar, 1, 1);
            if (isset($stemElements[$stem])) $elements[$stemElements[$stem]]++;
            if (isset($branchElements[$branch])) $elements[$branchElements[$branch]]++;
        }
    }
    $total = array_sum($elements);
    if ($total == 0) {
        return ['木' => 2, '火' => 2, '土' => 2, '金' => 2, '水' => 2];
    }
    $factor = 10 / $total;
    foreach ($elements as &$value) {
        $value = round($value * $factor);
    }
    $diff = 10 - array_sum($elements);
    $elements['木'] += $diff;
    return array_values($elements);
}

function getZiweiBar($stars) {
    $starList = explode('、', str_replace('入命宮','',$stars));
    $strengthMap = [
        '紫微' => 90, '天機' => 80, '太陽' => 85, '武曲' => 85, '天同' => 75,
        '廉貞' => 80, '天府' => 90, '太陰' => 75, '貪狼' => 80, '巨門' => 75,
        '天相' => 80, '天梁' => 85, '七殺' => 80, '破軍' => 80
    ];
    $data = [];
    foreach ($starList as $s) {
        $data[$s] = $strengthMap[$s] ?? 70; // Default strength if not mapped
    }
    return $data;
}

function getAnnualTrend($bazi, $currentYear) {
    $years = [];
    $values = [];
    $elements = ['木', '火', '土', '金', '水'];
    $stemElements = ['甲' => '木', '乙' => '木', '丙' => '火', '丁' => '火', '戊' => '土',
                     '己' => '土', '庚' => '金', '辛' => '金', '壬' => '水', '癸' => '水'];
    $stems = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
    $wuxing = getWuXingDistribution($bazi);
    $maxElementIdx = array_search(max($wuxing), $wuxing);
    $strongElement = $elements[$maxElementIdx];
    for ($i = -2; $i <= 2; $i++) {
        $year = $currentYear + $i;
        $years[] = $year;
        $yearIndex = ($year - 4) % 60;
        $yearStem = $stems[$yearIndex % 10];
        $yearElement = $stemElements[$yearStem];
        // Simple scoring based on Five Elements interaction
        if ($yearElement == $strongElement) {
            $values[] = 85; // Strong year
        } elseif (in_array($yearElement, ['木' => ['水'], '火' => ['木'], '土' => ['火'], '金' => ['土'], '水' => ['金']][$strongElement] ?? [])) {
            $values[] = 75; // Supported year
        } else {
            $values[] = 65; // Neutral or weak year
        }
    }
    return ['years' => $years, 'values' => $values];
}

function getPersonalStrengthRadar($bazi, $ziwei) {
    $categories = ['智慧', '勇氣', '耐心', '創意', '人緣', '決斷力'];
    $starList = explode('、', str_replace('入命宮','',$ziwei));
    $wuxing = getWuXingDistribution($bazi);
    $scores = [];
    $starInfluence = [
        '紫微' => ['智慧' => 90, '決斷力' => 85],
        '天機' => ['智慧' => 85, '創意' => 80],
        '太陽' => ['勇氣' => 85, '人緣' => 80],
        '武曲' => ['決斷力' => 85, '耐心' => 80],
        '天同' => ['人緣' => 85, '耐心' => 80],
        '廉貞' => ['勇氣' => 80, '決斷力' => 80],
        '天府' => ['耐心' => 85, '智慧' => 80],
        '太陰' => ['創意' => 80, '人緣' => 75],
        '貪狼' => ['創意' => 85, '人緣' => 80],
        '巨門' => ['智慧' => 80, '人緣' => 75],
        '天相' => ['人緣' => 85, '耐心' => 80],
        '天梁' => ['智慧' => 85, '耐心' => 80],
        '七殺' => ['勇氣' => 85, '決斷力' => 80],
        '破軍' => ['勇氣' => 80, '創意' => 80]
    ];
    $wuxingInfluence = [
        0 => ['創意' => 10, '智慧' => 5], // 木
        1 => ['勇氣' => 10, '決斷力' => 5], // 火
        2 => ['耐心' => 10, '人緣' => 5], // 土
        3 => ['決斷力' => 10, '智慧' => 5], // 金
        4 => ['智慧' => 10, '人緣' => 5] // 水
    ];
    $baseScores = array_fill_keys($categories, 60);
    foreach ($starList as $star) {
        if (isset($starInfluence[$star])) {
            foreach ($starInfluence[$star] as $cat => $score) {
                $baseScores[$cat] = max($baseScores[$cat], $score);
            }
        }
    }
    $maxWuxingIdx = array_search(max($wuxing), $wuxing);
    if (isset($wuxingInfluence[$maxWuxingIdx])) {
        foreach ($wuxingInfluence[$maxWuxingIdx] as $cat => $bonus) {
            $baseScores[$cat] += $bonus;
        }
    }
    foreach ($categories as $cat) {
        $scores[] = min(100, $baseScores[$cat]);
    }
    return ['categories' => $categories, 'scores' => $scores];
}

function getHealthIndexBar($bazi) {
    $indices = ['心肺功能', '免疫力', '精神狀態', '睡眠品質', '飲食習慣'];
    $wuxing = getWuXingDistribution($bazi);
    $elements = ['木', '火', '土', '金', '水'];
    $maxWuxingIdx = array_search(max($wuxing), $wuxing);
    $minWuxingIdx = array_search(min($wuxing), $wuxing);
    $strongElement = $elements[$maxWuxingIdx];
    $weakElement = $elements[$minWuxingIdx];
    $healthMap = [
        '木' => ['心肺功能' => 85, '免疫力' => 80],
        '火' => ['精神狀態' => 85, '心肺功能' => 80],
        '土' => ['飲食習慣' => 85, '免疫力' => 80],
        '金' => ['心肺功能' => 85, '睡眠品質' => 80],
        '水' => ['睡眠品質' => 85, '精神狀態' => 80]
    ];
    $values = array_fill(0, 5, 70);
    if (isset($healthMap[$strongElement])) {
        foreach ($healthMap[$strongElement] as $idx => $score) {
            $index = array_search($idx, $indices);
            if ($index !== false) $values[$index] = $score;
        }
    }
    if (isset($healthMap[$weakElement])) {
        foreach ($healthMap[$weakElement] as $idx => $score) {
            $index = array_search($idx, $indices);
            if ($index !== false) $values[$index] = max(60, $values[$index] - 10);
        }
    }
    return ['indices' => $indices, 'values' => $values];
}

function getWuXingDescription($wuxing) {
    $elements = ['木', '火', '土', '金', '水'];
    $maxIdx = array_search(max($wuxing), $wuxing);
    $desc = [
        0 => '木旺：創意與生機充沛，適合從事教育、設計或自然相關領域，宜多親近大自然。',
        1 => '火旺：熱情奔放，具領導力，適合行銷或管理，注意情緒與心血管健康。',
        2 => '土旺：穩重務實，適合金融、地產或行政，建議多運動以調節身心。',
        3 => '金旺：果斷有執行力，適合法律或管理，宜多與人交流以平衡個性。',
        4 => '水旺：聰慧靈活，適合創意或傳播，注意腎臟與泌尿系統健康。'
    ];
    return $desc[$maxIdx];
}

function getZiweiDescription($ziwei) {
    $stars = [
        '紫微' => '領導力卓越，適合管理、教育或公職，宜展現穩重氣質。',
        '天機' => '思維敏捷，擅長策劃，適合諮詢、設計或科技領域。',
        '太陽' => '積極進取，具影響力，適合行銷或公關，注意過度操勞。',
        '武曲' => '理財能力強，適合金融或軍警，宜保持耐心與彈性。',
        '天同' => '溫和善良，適合服務或教育，宜增強決斷力。',
        '廉貞' => '果敢堅毅，適合管理或司法，注意情緒管理。',
        '天府' => '穩重可靠，適合行政或管理，宜主動把握機會。',
        '太陰' => '細膩體貼，適合藝術或醫護，注意情緒波動。',
        '貪狼' => '多才多藝，適合創意或娛樂，宜專注目標。',
        '巨門' => '口才出眾，適合傳媒或法律，注意言辭謹慎。',
        '天相' => '協調力強，適合公職或管理，宜保持中立態度。',
        '天梁' => '正直仁愛，適合醫療或教育，注意過於理想化。',
        '七殺' => '衝勁十足，適合創業或軍警，宜控制衝動。',
        '破軍' => '變革創新，適合科技或冒險，注意穩定性。'
    ];
    $mainStars = explode('、', str_replace('入命宮','',$ziwei));
    $desc = [];
    foreach ($mainStars as $star) {
        if (isset($stars[$star])) $desc[] = $star.'：'.$stars[$star];
    }
    return implode('；', $desc);
}

function getHoroscope($zodiac) {
    $horoscope = [
        '牡羊座' => '事業穩步前進，財運有小幅提升，感情需耐心，健康注意休息。',
        '金牛座' => '事業得貴人相助，財運平穩，感情溫馨，注意飲食均衡。',
        '雙子座' => '事業需積極爭取，財運略有波動，感情多變，注意呼吸道健康。',
        '巨蟹座' => '事業穩健發展，財運小有進展，感情和諧，注意腸胃保養。',
        '獅子座' => '事業有突破機會，財運旺盛，感情熱烈，注意心血管健康。',
        '處女座' => '事業進展順利，財運穩定，感情平順，注意腸胃健康。',
        '天秤座' => '事業合作順利，財運平穩，感情和諧，注意腰部保養。',
        '天蠍座' => '事業進展快速，財運提升，感情深刻，注意泌尿系統健康。',
        '射手座' => '事業機遇增多，財運上揚，感情愉快，注意肝膽健康。',
        '摩羯座' => '事業穩步成長，財運穩定，感情需多溝通，注意骨骼健康。',
        '水瓶座' => '事業創新有成，財運穩健，感情自由，注意血液循環。',
        '雙魚座' => '事業需堅持，財運平穩，感情浪漫，注意足部保養。'
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
    $annualAvg = array_sum($result['流年運勢']['values']) / count($result['流年運勢']['values']);
    $radarAvg = array_sum($result['個人優勢雷達']['scores']) / count($result['個人優勢雷達']['scores']);
    $healthAvg = array_sum($result['健康指數']['values']) / count($result['健康指數']['values']);
    $horoscope = $result['星座運勢'];

    $advice = [];
    $advice[] = $wuxingBalance ? '五行均衡，運勢穩定，宜保持現狀並穩健前行。' : '五行強弱分明，建議補足弱勢五行以平衡運勢。';
    $advice[] = "命宮主星「{$mainStar}」影響深遠，善用其特質可提升個人表現。";
    if ($annualAvg >= 80) {
        $advice[] = '近五年運勢強勁，適合積極拓展事業與人脈。';
    } elseif ($annualAvg >= 70) {
        $advice[] = '運勢平穩向上，持續努力可獲穩定回報。';
    } else {
        $advice[] = '運勢略有波動，宜謹慎規劃，靜待良機。';
    }
    if ($radarAvg >= 80) {
        $advice[] = '個人優勢突出，善用天賦可大展身手。';
    } elseif ($radarAvg >= 70) {
        $advice[] = '綜合能力穩定，持續精進可更上一層樓。';
    } else {
        $advice[] = '宜加強學習與自信，提升整體競爭力。';
    }
    if ($healthAvg >= 80) {
        $advice[] = '健康狀態良好，維持規律作息即可。';
    } elseif ($healthAvg >= 70) {
        $advice[] = '健康狀況尚可，注意飲食與運動平衡。';
    } else {
        $advice[] = '需關注健康，建議定期檢查與規律運動。';
    }
    $advice[] = "星座指引：{$horoscope}";
    return implode(' ', $advice);
}

function getBazi($year, $month, $day, $hour) {
    $stems = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
    $branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
    $yearIndex = ($year - 4) % 60;
    $yearStem = $stems[$yearIndex % 10];
    $yearBranch = $branches[$yearIndex % 12];
    $monthBranches = ['寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥', '子', '丑'];
    $monthBranch = $monthBranches[($month - 1) % 12];
    $stemCycle = [
        '甲' => ['丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁'],
        '乙' => ['戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己'],
        '丙' => ['庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛'],
        '丁' => ['壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'],
        '戊' => ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙'],
        '己' => ['丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁'],
        '庚' => ['戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己'],
        '辛' => ['庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛'],
        '壬' => ['壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'],
        '癸' => ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙']
    ];
    $monthStem = $stemCycle[$yearStem][($month - 1) % 12];
    $date = new DateTime("$year-$month-$day");
    $refDate = new DateTime('1984-01-01');
    $daysDiff = $refDate->diff($date)->days;
    $dayIndex = $daysDiff % 60;
    $dayStem = $stems[$dayIndex % 10];
    $dayBranch = $branches[$dayIndex % 12];
    $hourMap = [
        '子時' => '子', '丑時' => '丑', '寅時' => '寅', '卯時' => '卯', '辰時' => '辰',
        '巳時' => '巳', '午時' => '午', '未時' => '未', '申時' => '申', '酉時' => '酉',
        '戌時' => '戌', '亥時' => '亥'
    ];
    $hourBranch = $hourMap[$hour] ?? '子';
    $hourStemCycle = [
        '甲' => ['甲', '丙', '戊', '庚', '壬', '甲', '丙', '戊', '庚', '壬', '甲', '丙'],
        '乙' => ['乙', '丁', '己', '辛', '癸', '乙', '丁', '己', '辛', '癸', '乙', '丁'],
        '丙' => ['丙', '戊', '庚', '壬', '甲', '丙', '戊', '庚', '壬', '甲', '丙', '戊'],
        '丁' => ['丁', '己', '辛', '癸', '乙', '丁', '己', '辛', '癸', '乙', '丁', '己'],
        '戊' => ['戊', '庚', '壬', '甲', '丙', '戊', '庚', '壬', '甲', '丙', '戊', '庚'],
        '己' => ['己', '辛', '癸', '乙', '丁', '己', '辛', '癸', '乙', '丁', '己', '辛'],
        '庚' => ['庚', '壬', '甲', '丙', '戊', '庚', '壬', '甲', '丙', '戊', '庚', '壬'],
        '辛' => ['辛', '癸', '乙', '丁', '己', '辛', '癸', '乙', '丁', '己', '辛', '癸'],
        '壬' => ['壬', '甲', '丙', '戊', '庚', '壬', '甲', '丙', '戊', '庚', '壬', '甲'],
        '癸' => ['癸', '乙', '丁', '己', '辛', '癸', '乙', '丁', '己', '辛', '癸', '乙']
    ];
    $hourStem = $hourStemCycle[$dayStem][array_search($hourBranch, $branches)];
    return "$yearStem$yearBranch $monthStem$monthBranch $dayStem$dayBranch $hourStem$hourBranch";
}

function getZiweiStars($lunarDay, $hour) {
    $branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
    $hourIndex = array_search($hour, [
        '子時', '丑時', '寅時', '卯時', '辰時', '巳時',
        '午時', '未時', '申時', '酉時', '戌時', '亥時'
    ]);
    if ($hourIndex === false) $hourIndex = 0;
    $destinyPalace = ($lunarDay + $hourIndex) % 12;
    $ziweiStarPositions = [
        1 => ['紫微'], 2 => ['天機'], 3 => ['太陽'], 4 => ['武曲', '天同'],
        5 => ['廉貞'], 6 => ['天府'], 7 => ['太陰'], 8 => ['貪狼'],
        9 => ['巨門'], 10 => ['天相'], 11 => ['天梁'], 0 => ['七殺', '破軍']
    ];
    $stars = $ziweiStarPositions[$destinyPalace] ?? ['紫微'];
    return implode('、', $stars) . '入命宮';
}

function getLunarFortune($name, $birthday, $hour) {
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $birthday, $m)) {
        return null;
    }
    $year = intval($m[1]);
    $month = intval($m[2]);
    $day = intval($m[3]);
    $zodiac = getZodiac($month, $day);
    $lunarDay = $day; // Simplified, assumes Gregorian day
    $bazi = getBazi($year, $month, $day, $hour);
    $ziwei = getZiweiStars($lunarDay, $hour);
    $wuxing = getWuXingDistribution($bazi);
    $currentYear = (int)date('Y');
    $ziweiBar = getZiweiBar($ziwei);
    $annualTrend = getAnnualTrend($bazi, $currentYear);
    $personalRadar = getPersonalStrengthRadar($bazi, $ziwei);
    $healthBar = getHealthIndexBar($bazi);
    $wuxingDesc = getWuXingDescription($wuxing);
    $ziweiDesc = getZiweiDescription($ziwei);
    $horoscope = getHoroscope($zodiac);
    return [
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
        '星座運勢' => $horoscope,
        '綜合運勢' => getOverallAdvice([
            '五行分布' => $wuxing,
            '主星影響' => $ziweiBar,
            '流年運勢' => $annualTrend,
            '個人優勢雷達' => $personalRadar,
            '健康指數' => $healthBar,
            '星座運勢' => $horoscope
        ])
    ];
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
    <title>台灣命理解析｜八字・紫微・星座</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #d4a017;
            --secondary-color: #8a5522;
            --background-light: #fff8e1;
            --background-dark: #2a2a2a;
            --text-light: #3c2f1c;
            --text-dark: #f8e7b5;
            --accent-color: #b71c1c;
        }
        body {
            background: linear-gradient(135deg, var(--background-light) 0%, #f4c77d 100%);
            font-family: 'Noto Serif TC', serif;
            margin: 0;
            min-height: 100vh;
            color: var(--text-light);
            transition: all 0.3s ease;
        }
        body.night {
            background: linear-gradient(135deg, var(--background-dark) 0%, #5c3a00 100%);
            color: var(--text-dark);
        }
        .fortune-container {
            max-width: 900px;
            margin: 3rem auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            position: relative;
        }
        body.night .fortune-container {
            background: rgba(40, 40, 40, 0.95);
        }
        .fortune-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .fortune-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin: 0;
            letter-spacing: 3px;
        }
        .fortune-header p {
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin: 0.5rem 0 0;
            line-height: 1.6;
        }
        form {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        body.night form {
            background: #333;
        }
        .input-group {
            display: grid;
            gap: 0.5rem;
        }
        label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        input[type="text"], input[type="date"], select {
            padding: 0.9rem;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            font-size: 1rem;
            background: var(--background-light);
            color: var(--text-light);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        body.night input, body.night select {
            background: #444;
            color: var(--text-dark);
            border-color: #a77c2a;
        }
        input:focus, select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 8px rgba(183, 28, 28, 0.3);
        }
        input.error, select.error {
            border-color: #e53935;
        }
        .error-message {
            color: #e53935;
            font-size: 0.9rem;
            display: none;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--background-light) 100%);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        body.night input[type="submit"] {
            background: linear-gradient(90deg, #a77c2a 60%, #444 100%);
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, var(--accent-color) 60%, var(--primary-color) 100%);
            transform: translateY(-2px);
        }
        input[type="submit"]:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .result-section {
            margin-top: 2rem;
        }
        .result-block {
            background: var(--background-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        body.night .result-block {
            background: #3b2f1c;
        }
        .result-block:hover {
            transform: translateY(-4px);
        }
        .result-block.collapsible .block-content {
            display: none;
            animation: slideIn 0.3s ease forwards;
        }
        .result-block.collapsible.active .block-content {
            display: block;
        }
        .result-block h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.8rem;
            position: relative;
            cursor: pointer;
        }
        .result-block.collapsible h3::after {
            content: "▼";
            position: absolute;
            right: 0;
            top: 0;
            color: var(--primary-color);
            font-size: 0.9rem;
            transition: transform 0.3s;
        }
        .result-block.collapsible.active h3::after {
            transform: rotate(-180deg);
        }
        .result-block p, .result-block ul {
            font-size: 1rem;
            color: var(--text-light);
            line-height: 1.6;
            margin: 0.5rem 0;
        }
        body.night .result-block p, body.night .result-block ul {
            color: var(--text-dark);
        }
        .result-block ul {
            padding-left: 1.5rem;
        }
        .result-block ul li {
            margin-bottom: 0.5rem;
        }
        .zodiac-tag {
            display: inline-block;
            background: linear-gradient(90deg, var(--background-light) 60%, var(--primary-color) 100%);
            color: var(--secondary-color);
            border-radius: 8px;
            padding: 0.4rem 1.2rem;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        body.night .zodiac-tag {
            background: linear-gradient(90deg, #444 60%, #a77c2a 100%);
            color: var(--text-dark);
        }
        .chart-wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .chart-box {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        body.night .chart-box {
            background: #333;
        }
        .chart-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        .chart-box h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1rem;
        }
        .chart-box p {
            text-align: center;
            font-size: 0.95rem;
            color: var(--secondary-color);
        }
        .footer {
            text-align: center;
            font-size: 0.95rem;
            color: var(--secondary-color);
            margin-top: 2rem;
            padding: 1rem 0;
        }
        body.night .footer {
            color: var(--text-dark);
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .fortune-container {
                padding: 1.5rem;
                margin: 1.5rem;
            }
            .fortune-header h1 {
                font-size: 2rem;
            }
            .chart-box {
                padding: 1rem;
            }
            form {
                padding: 1rem;
            }
        }
        @media (max-width: 480px) {
            .fortune-header h1 {
                font-size: 1.8rem;
            }
            .fortune-header p {
                font-size: 1rem;
            }
            input, select {
                font-size: 0.95rem;
                padding: 0.8rem;
            }
            .result-block h3 {
                font-size: 1.2rem;
            }
            .chart-box {
                padding: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <button id="toggle-dark" style="position: fixed; top: 1rem; right: 1rem; z-index: 100; background: var(--primary-color); color: #fff; border: none; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;">🌙 夜間模式</button>
    <div class="fortune-container">
        <div class="fortune-header">
            <h1>台灣命理解析</h1>
            <p>結合八字、紫微與星座，洞悉您的運勢與人生方向</p>
        </div>
        <form method="POST" autocomplete="off">
            <div class="input-group">
                <label for="name">姓名</label>
                <input type="text" name="name" id="name" maxlength="8" required placeholder="請輸入您的姓名（2-8字）">
                <span class="error-message" id="name-error">姓名需為 2-8 個字</span>
            </div>
            <div class="input-group">
                <label for="birthday">出生日期</label>
                <input type="date" name="birthday" id="birthday" required>
                <span class="error-message" id="birthday-error">請選擇有效的出生日期</span>
            </div>
            <div class="input-group">
                <label for="hour">出生時辰</label>
                <select name="hour" id="hour" required>
                    <option value="">請選擇出生時辰</option>
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
                <span class="error-message" id="hour-error">請選擇出生時辰</span>
            </div>
            <input type="submit" value="開始解析命盤">
        </form>
        <?php if ($isFormValid): ?>
            <div class="result-section">
                <div class="zodiac-tag">您的星座：<?= htmlspecialchars($result['星座']) ?></div>
                <div class="chart-wrap">
                    <div class="chart-box">
                        <h3>五行分布</h3>
                        <canvas id="baziChart" width="300" height="300"></canvas>
                        <p>五行強弱一覽，了解您的命格平衡</p>
                    </div>
                    <div class="chart-box">
                        <h3>紫微主星影響</h3>
                        <canvas id="ziweiBar" width="300" height="300"></canvas>
                        <p>命宮主星的影響力分布</p>
                    </div>
                    <div class="chart-box">
                        <h3>流年運勢趨勢</h3>
                        <canvas id="annualTrend" width="300" height="300"></canvas>
                        <p>近五年運勢起伏一覽</p>
                    </div>
                    <div class="chart-box">
                        <h3>個人優勢分析</h3>
                        <canvas id="personalRadar" width="300" height="300"></canvas>
                        <p>探索您的核心競爭力</p>
                    </div>
                    <div class="chart-box">
                        <h3>健康指數分析</h3>
                        <canvas id="healthBar" width="300" height="300"></canvas>
                        <p>關注您的身心健康狀態</p>
                    </div>
                </div>
                <div class="result-block collapsible">
                    <h3>綜合運勢建議</h3>
                    <div class="block-content">
                        <p style="font-weight: 600; color: var(--accent-color);"><?= htmlspecialchars($result['綜合運勢']) ?></p>
                    </div>
                </div>
                <div class="result-block collapsible">
                    <h3>八字命盤解析</h3>
                    <div class="block-content">
                        <p><strong>八字：<?= htmlspecialchars($result['八字命盤']) ?></strong></p>
                        <p style="color: var(--accent-color);"><?= htmlspecialchars($result['五行解讀']) ?></p>
                        <ul>
                            <li>五行分布依據八字推算，顯示您的命格特性。</li>
                            <li>本結果為簡化計算，詳細命盤建議諮詢專業命理師。</li>
                        </ul>
                    </div>
                </div>
                <div class="result-block collapsible">
                    <h3>紫微命宮解析</h3>
                    <div class="block-content">
                        <p><strong>主星：<?= htmlspecialchars($result['紫微主星']) ?></strong></p>
                        <p style="color: var(--accent-color);"><?= htmlspecialchars($result['紫微解讀']) ?></p>
                        <ul>
                            <li>命宮主星依據簡化算法生成，反映核心個性。</li>
                            <li>詳細紫微斗數需專業排盤，建議進一步諮詢。</li>
                        </ul>
                    </div>
                </div>
                <div class="result-block collapsible">
                    <h3>星座運勢指引</h3>
                    <div class="block-content">
                        <p><strong>星座：<?= htmlspecialchars($result['星座']) ?></strong></p>
                        <p><?= htmlspecialchars($result['星座運勢']) ?></p>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            const wuxingData = <?= json_encode($result['五行分布']) ?>;
            const wuxingLabels = ['木', '火', '土', '金', '水'];
            new Chart(document.getElementById('baziChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: wuxingLabels,
                    datasets: [{
                        data: wuxingData,
                        backgroundColor: ['#4caf50', '#f44336', '#ffeb3b', '#78909c', '#2196f3'],
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 12, family: 'Noto Serif TC' } } },
                        tooltip: { backgroundColor: '#333', titleFont: { family: 'Noto Serif TC' }, bodyFont: { family: 'Noto Serif TC' } }
                    }
                }
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
                        backgroundColor: ['#ab47bc', '#ff8f00', '#26a69a'],
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    indexAxis: 'y',
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#333', titleFont: { family: 'Noto Serif TC' }, bodyFont: { family: 'Noto Serif TC' } } },
                    scales: { x: { min: 0, max: 100, ticks: { stepSize: 20 } } }
                }
            });
            const annualYears = <?= json_encode($result['流年運勢']['years']) ?>;
            const annualValues = <?= json_encode($result['流年運勢']['values']) ?>;
            new Chart(document.getElementById('annualTrend').getContext('2d'), {
                type: 'line',
                data: {
                    labels: annualYears,
                    datasets: [{
                        label: '運勢指數',
                        data: annualValues,
                        fill: false,
                        borderColor: '#d4a017',
                        backgroundColor: '#d4a017',
                        tension: 0.3
                    }]
                },
                options: {
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    scales: { y: { min: 0, max: 100, ticks: { stepSize: 20 } } },
                    plugins: { legend: { position: 'top', labels: { font: { family: 'Noto Serif TC' } } }, tooltip: { backgroundColor: '#333', titleFont: { family: 'Noto Serif TC' }, bodyFont: { family: 'Noto Serif TC' } } }
                }
            });
            const personalRadarLabels = <?= json_encode($result['個人優勢雷達']['categories']) ?>;
            const personalRadarData = <?= json_encode($result['個人優勢雷達']['scores']) ?>;
            new Chart(document.getElementById('personalRadar').getContext('2d'), {
                type: 'radar',
                data: {
                    labels: personalRadarLabels,
                    datasets: [{
                        label: '優勢指數',
                        data: personalRadarData,
                        backgroundColor: 'rgba(212, 160, 23, 0.2)',
                        borderColor: '#d4a017',
                        pointBackgroundColor: '#d4a017'
                    }]
                },
                options: {
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    scales: { r: { min: 0, max: 100, ticks: { stepSize: 20 } } },
                    plugins: { legend: { position: 'top', labels: { font: { family: 'Noto Serif TC' } } }, tooltip: { backgroundColor: '#333', titleFont: { family: 'Noto Serif TC' }, bodyFont: { family: 'Noto Serif TC' } } }
                }
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
                        backgroundColor: ['#ef5350', '#26a69a', '#7e57c2', '#5c6bc0', '#29b6f6'],
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: { duration: 1000, easing: 'easeOutQuart' },
                    indexAxis: 'y',
                    scales: { x: { min: 0, max: 100, ticks: { stepSize: 20 } } },
                    plugins: { legend: { position: 'top', labels: { font: { family: 'Noto Serif TC' } } }, tooltip: { backgroundColor: '#333', titleFont: { family: 'Noto Serif TC' }, bodyFont: { family: 'Noto Serif TC' } } }
                }
            });
            </script>
        <?php endif; ?>
        <div class="footer">
            <span>© 2025 台灣命理解析 | 由 xAI 設計</span>
        </div>
    </div>
    <script>
    document.getElementById('toggle-dark').onclick = function() {
        document.body.classList.toggle('night');
        this.textContent = document.body.classList.contains('night') ? '☀ 光亮模式' : '🌙 夜間模式';
    };
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.result-block.collapsible h3').forEach(h3 => {
            h3.addEventListener('click', () => {
                h3.parentElement.classList.toggle('active');
            });
        });
        const nameInput = document.getElementById('name');
        const birthdayInput = document.getElementById('birthday');
        const hourInput = document.getElementById('hour');
        const submitBtn = document.querySelector('input[type="submit"]');
        const nameError = document.getElementById('name-error');
        const birthdayError = document.getElementById('birthday-error');
        const hourError = document.getElementById('hour-error');
        if (localStorage.getItem('fortune_name')) nameInput.value = localStorage.getItem('fortune_name');
        if (localStorage.getItem('fortune_birthday')) birthdayInput.value = localStorage.getItem('fortune_birthday');
        if (localStorage.getItem('fortune_hour')) hourInput.value = localStorage.getItem('fortune_hour');
        function validate() {
            let valid = true;
            if (nameInput.value.trim().length < 2 || nameInput.value.trim().length > 8) {
                nameInput.classList.add('error');
                nameError.style.display = 'block';
                valid = false;
            } else {
                nameInput.classList.remove('error');
                nameError.style.display = 'none';
            }
            if (!birthdayInput.value) {
                birthdayInput.classList.add('error');
                birthdayError.style.display = 'block';
                valid = false;
            } else {
                birthdayInput.classList.remove('error');
                birthdayError.style.display = 'none';
            }
            if (!hourInput.value) {
                hourInput.classList.add('error');
                hourError.style.display = 'block';
                valid = false;
            } else {
                hourInput.classList.remove('error');
                hourError.style.display = 'none';
            }
            submitBtn.disabled = !valid;
            return valid;
        }
        nameInput.addEventListener('input', validate);
        birthdayInput.addEventListener('input', validate);
        hourInput.addEventListener('change', validate);
        validate();
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validate()) {
                e.preventDefault();
                alert('請正確填寫所有欄位！');
            } else {
                localStorage.setItem('fortune_name', nameInput.value);
                localStorage.setItem('fortune_birthday', birthdayInput.value);
                localStorage.setItem('fortune_hour', hourInput.value);
            }
        });
    });
    </script>
</body>
</html>