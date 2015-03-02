<?php


namespace common\helpers\api;

/**
 * todo Этот класс был создан задолго до появления проекта. Нуждается в полном рефакторинге
 *
 * Class GeneratorSeasonApi
 * @package common\helpers\api
 */

class GeneratorSeason {

    /*
     * Вспомогательная функция для построянии матрицы встреч команд
     */
    private static function find_min($match, $x, $y) {

        $count = count($match[0]);

        $aTrue = array();

        for ($i = 1; $i < $count; $i++) {
            $aTrue[$i] = $i;
        }

        for ($i = 0; $i < $count; $i++) {
            $key = array_search($match[$x][$i], $aTrue);

            if ($key) {
                unset($aTrue[$key]);
            }

            $key = array_search($match[$i][$y], $aTrue);
            if ($key) {
                unset($aTrue[$key]);
            }
        }

        reset($aTrue);
        $key = current($aTrue);
        return $aTrue[$key];
    }

    private static function showMatrix($match) {
        // вывод
        for ($i = 0; $i < count($match); $i++) {
            for ($j = 0; $j < count($match); $j++) {
                echo($match[$i][$j] . " ");
            }
            echo "</br>";
        }
        echo "</br>";
    }


    public static function buildCalendar($aTeams = []) {
        // матрица матчей
        $match = [];
        $tours = [];

        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 0; $j < count($aTeams); $j++) {
                $match[$i][$j] = 0;
            }
        }

        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = count($aTeams) - $i - 1; $j > -1; $j--) {
                $match[$i][$j] = $j + $i;
            }

            $match[$i][0] = $i;
            $match[0][$i] = $i;
            $match[$i][$i] = 0;
        }

        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 0; $j < count($aTeams); $j++) {
                if ($i != $j && $match[$i][$j] == 0) {
                    $match[$i][$j] = static::find_min($match, $i, $j);
                }
            }
        }

        // готовим + и - (дома и на выезде)
        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 0; $j < count($aTeams); $j++) {
                if ($i < $j) {
                    if (substr($match[$i][$j - 1], 0, 3) != "<b>") {
                        $match[$i][$j] = "<b>" . $match[$i][$j] . "</b>";
                    } else {
                        $match[$j][$i] = "<b>" . $match[$i][$j] . "</b>";
                    }
                }
            }
        }

        // 1 Krug
        $aTrue = [];
        for ($i = 0; $i < (count($match) / 2); $i++) {
            $aTrue[$i] = $i;
        }

        shuffle($aTrue);

        $aTours = [];
        foreach ($aTrue as $item) {
            if (2 * $item != 0)
                $aTours[] = 2 * $item;
            $aTours[] = 2 * $item + 1;
        }

        //foreach($aTours as $k=>$item){
        for ($x = 0; $x < count($aTeams) - 1; $x++) {
            $item = $aTours[$x];
            $tour = ['title' => "Tour " . ($x + 1)];

            for ($i = 0; $i < count($aTeams); $i++) {
                for ($j = $i + 1; $j < count($aTeams); $j++) {

                    if ($match[$i][$j] == "$item") {
                        $tour['match'][] = ["title" => $aTeams[$i]['title'] . " - " . $aTeams[$j]['title'], "team1" => $aTeams[$i]['id'], "team2" => $aTeams[$j]['id']];
                    }

                    if ($match[$i][$j] == "<b>$item</b>") {
                        $tour['match'][] = ["title" => $aTeams[$j]['title'] . " - " . $aTeams[$i]['title'], "team1" => $aTeams[$j]['id'], "team2" => $aTeams[$i]['id']];
                    }
                }
            }

            $tours[] = $tour;
        }

        shuffle($aTrue);
        $aTours = [];
        foreach ($aTrue as $item) {
            if (2 * $item != 0)
                $aTours[] = 2 * $item;
            $aTours[] = 2 * $item + 1;
        }
        // 2 Krug

        for ($x = 0; $x < count($aTeams) - 1; $x++) {
            $item = $aTours[$x];
            $tour = ['title' => "Tour " . ($x + count($aTeams))];

            for ($i = 0; $i < count($aTeams); $i++) {
                for ($j = $i + 1; $j < count($aTeams); $j++) {
                    if ($match[$i][$j] == "<b>$item</b>") {
                        $tour['match'][] = ["title" => $aTeams[$i]['title'] . " - " . $aTeams[$j]['title'], "team1" => $aTeams[$i]['id'], "team2" => $aTeams[$j]['id']];
                    }

                    if ($match[$i][$j] == "$item") {
                        $tour['match'][] = ["title" => $aTeams[$j]['title'] . " - " . $aTeams[$i]['title'], "team1" => $aTeams[$j]['id'], "team2" => $aTeams[$i]['id']];
                    }
                }
            }

            $tours[] = $tour;
        }

        return $tours;
    }


    public function actionTest() {

        $aTeams = array("Arsenal", "Manchester City", "Manchester United", "Chelsea", "Tottenham Hotspur", "Liverpool", "Newcastle United",
            "Everton", "Sunderland", "Aston Villa", "Stoke City", "Swansea City", "Norwich City", "West Ham United", "Fulham",
            "Southampton", "Wigan Athletic", "Reading", "Queens Park Rangers", "West Bromwich Albion");

        $aLeague = array("title" => "ENG1", "season" => "12/13");

        $aMatch1 = array();
        $aMatch2 = array();

        $aScore = array();
        for ($i = 0; $i < count($aTeams); $i++) {
            $aScore[$i] = 0;
        }


        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 1; $j < count($aTeams); $j++) {
                $match[$i][$j] = 0;
            }
            //echo "</br>";
        }


        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = count($aTeams) - $i - 1; $j > -1; $j--) {
                $match[$i][$j] = $j + $i;
            }

            $match[$i][0] = $i;
            $match[0][$i] = $i;
            $match[$i][$i] = 0;
        }


        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 0; $j < count($aTeams); $j++) {
                if ($i != $j && $match[$i][$j] == 0) {
                    $match[$i][$j] = find_min($match, $i, $j);

                }
            }
        }

        showMatrix($match);
// готовим + и - (дома и на выезде)

        for ($i = 0; $i < count($aTeams); $i++) {
            for ($j = 1; $j < count($aTeams); $j++) {
                if ($i < $j) {
                    if (substr($match[$i][$j - 1], 0, 3) != "<b>") {

                        $match[$i][$j] = "<b>" . $match[$i][$j] . "</b>";

                    } else {
                        $match[$j][$i] = "<b>" . $match[$i][$j] . "</b>";
                    }

                }
            }
        }

        showMatrix($match);

        $aTrue = array();

        for ($i = 0; $i < (count($match) / 2); $i++) {
            $aTrue[$i] = $i;
        }

        shuffle($aTrue);

        $aTours = array();
        foreach ($aTrue as $item) {
            $aTours[] = 2 * $item;
            $aTours[] = 2 * $item + 1;
        }

        echo("<xmp>");
        print_r($aTours);
        echo("</xmp>");

        foreach ($aTours as $k => $item) {
            echo("<xmp>");
            print_r("Tour " . ($k + 1) . " ($item)");
            echo("</xmp>");

            for ($i = 0; $i < count($aTeams); $i++) {
                for ($j = $i + 1; $j < count($aTeams); $j++) {

                    if ($match[$i][$j] == "$item") {

                        $x1 = rand(0, 5);
                        $x2 = rand(0, 5);
                        echo("<xmp>");
                        print_r("$aTeams[$i] - $aTeams[$j]  ($x1 : $x2)");
                        echo("</xmp>");


                        $aMatch = array("Home" => $aTeams[$i], "Guest" => $aTeams[$j], "scores" => "$x1 : $x2", "goalHome" => $x1, "goalGuest" => $x2);

                        if ($x1 > $x2) {
                            $aScore[$i] += 3;
                        }
                        if ($x2 > $x1) {
                            $aScore[$j] += 3;
                        }
                        if ($x1 == $x2) {
                            $aScore[$i] += 1;
                            $aScore[$j] += 1;
                        }

                    }

                    if ($match[$i][$j] == "<b>$item</b>") {
                        $x1 = rand(0, 5);
                        $x2 = rand(0, 5);
                        echo("<xmp>");
                        print_r("$aTeams[$j] - $aTeams[$i]  ($x1 : $x2)");
                        echo("</xmp>");
                        $aMatch = array("Home" => $aTeams[$j], "Guest" => $aTeams[$i], "scores" => "$x1 : $x2", "goalHome" => $x1, "goalGuest" => $x2);

                        if ($x1 > $x2) {
                            $aScore[$j] += 3;
                        }
                        if ($x2 > $x1) {
                            $aScore[$i] += 3;
                        }
                        if ($x1 == $x2) {
                            $aScore[$i] += 1;
                            $aScore[$j] += 1;
                        }

                    }
                }
            }
        }

        shuffle($aTrue);
        $aTours = array();
        foreach ($aTrue as $item) {
            $aTours[] = 2 * $item;
            $aTours[] = 2 * $item + 1;
        }

        echo("<xmp>");
        print_r("2 krug");
        echo("</xmp>");

        foreach ($aTours as $k => $item) {
            echo("<xmp>");
            print_r("Tour " . ($k + 1 + count($aTeams)) . " ($item)");
            echo("</xmp>");

            for ($i = 0; $i < count($aTeams); $i++) {
                for ($j = $i + 1; $j < count($aTeams); $j++) {

                    $aMatch = array();

                    if ($match[$i][$j] == "$item") {
                        $x1 = rand(0, 5);
                        $x2 = rand(0, 5);

                        echo("<xmp>");
                        print_r("$aTeams[$i] - $aTeams[$j]  ($x1 : $x2)");
                        echo("</xmp>");


                        $aMatch = array("Home" => $aTeams[$i], "Guest" => $aTeams[$j], "scores" => "$x1 : $x2", "goalHome" => $x1, "goalGuest" => $x2);

                        if ($x1 > $x2) {
                            $aScore[$i] += 3;
                        }
                        if ($x2 > $x1) {
                            $aScore[$j] += 3;
                        }
                        if ($x1 == $x2) {
                            $aScore[$i] += 1;
                            $aScore[$j] += 1;
                        }

                    }

                    if ($match[$i][$j] == "<b>$item</b>") {
                        $x1 = rand(0, 5);
                        $x2 = rand(0, 5);
                        echo("<xmp>");
                        print_r("$aTeams[$j] - $aTeams[$i]  ($x1 : $x2)");
                        echo("</xmp>");
                        $aMatch = array("Home" => $aTeams[$j], "Guest" => $aTeams[$i], "scores" => "$x1 : $x2", "goalHome" => $x1, "goalGuest" => $x2);

                        if ($x1 > $x2) {
                            $aScore[$j] += 3;
                        }
                        if ($x2 > $x1) {
                            $aScore[$i] += 3;
                        }
                        if ($x1 == $x2) {
                            $aScore[$i] += 1;
                            $aScore[$j] += 1;
                        }

                    }
                }
            }
        }

        echo("<xmp>");
        print_r($aScore);
        echo("</xmp>");

        return;

    }
}