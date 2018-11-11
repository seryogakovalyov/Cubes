<?php
session_start();
$e = 3; //количество кубиков
$width = 7; // Количество клеток по вертикали
$height = 7; // Количество клеток по горизонтали
$_SESSION['ab'] = $_SESSION['a'];
if (isset($_GET['i']) && (isset($_GET['j']))) {
    $points = Remove($_SESSION['a'], $_GET['i'], $_GET['j']);
    $_SESSION['count'] += $points * ($points - 1) * 10;
}
if (isset($_GET['r'])) {
    if ($_GET['r'] == 1) {
        unset($_SESSION['a']);
        $_SESSION['count'] = 0;
    }
    if ($_GET['r'] == 2) {
        $map = $_SESSION['a'];
        for ($i = 1; $i <= $width; $i++) {
            for ($j = 1; $j <= $height; $j++) {
                //$_SESSION['a'][$j][$i] = $map[abs($i-($height+1))][$j];
                $_SESSION['ab'][$j][$i] = $map[$i][abs($j - ($height + 1))];
            }
        }
        Packing($_SESSION['ab']);
        header( "Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    }
}
if (empty($_SESSION['a'])) {
    for ($i = 1; $i <= $width; $i++) {
        for ($j = 1; $j <= $height; $j++) {
            $a[$i][$j] = rand(1, $e);
        }
    }
    $_SESSION['ab'] = $_SESSION['a'] = $a;
}
if (isset($_SESSION['fallen']))
    $fallen = json_encode($_SESSION['fallen']);
if (isset($_SESSION['move']))
    $move = json_encode($_SESSION['move']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Distribution" content="Global" />
        <meta name="Robots" content="index,follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script type="text/javascript" src="main.js"></script>
        <title>Кубики</title>
        <?php
        if (isset($_SESSION['fallen']))
            echo "<script type=\"text/javascript\">
            var height = $height;
            var width = $width;
            var fallen = $fallen;
                </script>";
        if (isset($_SESSION['move']))
            echo "<script type=\"text/javascript\">
            var height = $height;
            var width = $width;
            var move = $move;
                </script>";
        ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <a id="title" href ="/">Кубики</a>
            </div>
            <span class="space"></span>
            <div id="gamebody">
                <?php
                for ($i = 1; $i <= $height; $i++) { //горизонталь
                    if (isset($_SESSION['fallen'][$i]))
                        $num = count($_SESSION['fallen'][$i]) - 1;
                    echo "<div class = \"reel\">";
                    for ($j = 1; $j <= $width; $j++) { //вертикаль
                        if (($_SESSION['a'][$j][$i])) {
                            if (isset($_SESSION['move'][$i])) {
                                echo "<a class = \"cell$i\" style=\"background-image:url(img/136.png); display:inline-block; margin:0px; vertical-align:middle; position:relative; z-index: 2; height:36px; width:36px;\"><img style=\"position:absolute; top:0px; left:0px;\" src=\"img/b" . $_SESSION['a'][$j][$i] . ".png\" alt=\".\" height=\"36\" width=\"36\"></a>";
                            } else if (isset($_SESSION['fallen'][$i]) && (key($_SESSION['fallen'][$i]) >= $j)) {
                                echo "<a class = \"cell$i\" style=\"background-image:url(img/136.png); display:inline-block; margin:0px; vertical-align:middle; position:relative; z-index: 3; height:36px; width:36px;\"><img style=\"position:absolute; top:0px; left:0px;\" src=\"img/b" . $_SESSION['a'][$j][$i] . ".png\" alt=\".\" height=\"36\" width=\"36\"></a>";
                                $num--;
                            } else
                                echo "<a class = \"cell\" style=\"background-image:url(img/136.png);\" href = \"?i=$j&j=$i\"><img style=\"position:absolute; top:0px; left:0px;\" src=\"img/b" . $_SESSION['a'][$j][$i] . ".png\" alt=\".\" height=\"36\" width=\"36\"></a>";
                        } else
                            echo "<a class = \"cell\"><img style=\"position:absolute; top:0px; left:0px;\"></a>";
                    }
                    echo "</div>";
                }
                $_SESSION['a'] = $_SESSION['ab'];
                ?>
            </div>
            <div id="nav">
                <ul>
                    <li><a href="?r=1">сбросить</a></li><li><a href="?r=2">повернуть</a></li>
                </ul>
            </div>
            <div id="footer">
                <?php
                echo "Твои очки: " . $_SESSION['count'] . "<br />";
                unset($_SESSION['fallen']);
                unset($_SESSION['move']);
                ?>
            </div>
        </div>
    </body>
</html>

<?php

function Packing(&$map) {
    global $width;
    global $height;
    for ($j = 1; $j <= $height; ++$j) {
        $step = 0;
        for ($i = $width; $i > 0; --$i) {
            if ($map[$i][$j] == 0) {
                $step++;
            } else {
                if ($step) {
                    $_SESSION['fallen'][$j][$i] = $step + $i;
                }
                $map[$i + $step][$j] = $map[$i][$j];
            }
        }
        for ($i = 1; $i <= $step; ++$i) {
            $map[$i][$j] = 0;
        }
    }
    for ($i = 1; $i <= $width; ++$i) {
        $step = 0;
        for ($j = $height; $j > 0; --$j) {
            if ($map[$width][$j] == 0)
                $step++;
            else {
                $map[$i][$j + $step] = $map[$i][$j];
                if (($step) && ($map[$i][$j] != 0))
                    $_SESSION['move'][$j][$i] = $step + $i;
            }
        }
        for ($j = 1; $j <= $step; ++$j) {
            $map[$i][$j] = 0;
        }
    }
}

function Remove(
$map, $row, $col) {
    global $width;
    global $height;
    if (($col > $height) || ($row > $width) || ($map [$row][$col] == 0)) {
        return 0;
    }
    $count = RecursiveRemove($map, $row, $col, $map[$row][$col]);
    if ($count > 1) {
        $_SESSION['ab'] = $_SESSION['a'] = $map;
        Packing($_SESSION['ab']);
    }
    return $count;
}

function

RecursiveRemove(&$map, $row, $col, $val) {
    global $width;
    global $height;
    if ($map[$row][$col] != $val) {
        return 0;
    }
    $count = 1;
    $map[$row][$col] = 0;
    if ($col > 1) {
        $count += RecursiveRemove($map, $row, $col - 1, $val);
    } if ($row > 1) {
        $count += RecursiveRemove($map, $row - 1, $col, $val);
    } if ($col < $height) {
        $count += RecursiveRemove($map, $row, $col + 1, $val);
    } if ($row < $width) {
        $count += RecursiveRemove($map, $row + 1, $col, $val);
    } return $count;
}
?>