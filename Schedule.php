<?php

class Schedule {
    /*  rozvrh - array of objects
     *  {
     *      subject_code;
     *      subject_name;
     *      type;
     *      duration;
     *      day;
     *      time;
     *      title1;
     *      name;
     *      surname;
     *      title2;
     *      room;
     *      text;    
     *  }
     */

    var $schedule;

    const cellWidth = 60;
    const cellHeight = 90;

    public function Schedule($schedule, $lang = "SK") {
        $this->schedule = $schedule;
        $this->makeStyledSchedule($lang);
    }

    public function printScheduleTEXT() {
        var_dump($this->schedule);
    }

    private function makeStyledSchedule($lang = "SK") {

        $monday = array();
        $tuesday = array();
        $wednesday = array();
        $thursday = array();
        $friday = array();

        foreach ($this->schedule as $row) {
            if ($row->day === "monday")
                $monday[] = $row;
            if ($row->day === "tuesday")
                $tuesday[] = $row;
            if ($row->day === "wednesday")
                $wednesday[] = $row;
            if ($row->day === "thursday")
                $thursday[] = $row;
            if ($row->day === "friday")
                $friday[] = $row;
        }

        $mon = array(array($monday[0]));
        $tue = array(array($tuesday[0]));
        $wed = array(array($wednesday[0]));
        $thu = array(array($thursday[0]));
        $fri = array(array($friday[0]));


        // MONDAY
        for ($i = 1; $i < count($monday); $i++) {
            $collision = false;
            for ($j = 0; $j < count($mon); $j++) {
                $collision = false;
                for ($k = 0; $k < count($mon[$j]); $k++) {
                    if ((((int) ($monday[$i]->time) + (int) ($monday[$i]->duration)) <= ((int) ($mon[$j][$k]->time) + (int) ($mon[$j][$k]->duration)) &&
                            ((int) ($monday[$i]->time) + (int) ($monday[$i]->duration)) > ((int) ($mon[$j][$k]->time))) ||
                            (((int) ($monday[$i]->time)) < ((int) ($mon[$j][$k]->time) + (int) ($mon[$j][$k]->duration)) &&
                            ((int) ($monday[$i]->time)) >= ((int) ($mon[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $mon[$j][] = $monday[$i];
                    break;
                }
            }
            if ($collision == true) {
                $mon[] = array($monday[$i]);
            }
        }

        // TUESDAY
        for ($i = 1; $i < count($tuesday); $i++) {
            $collision = false;
            for ($j = 0; $j < count($tue); $j++) {
                $collision = false;
                for ($k = 0; $k < count($tue[$j]); $k++) {
                    if ((((int) ($tuesday[$i]->time) + (int) ($tuesday[$i]->duration)) <= ((int) ($tue[$j][$k]->time) + (int) ($tue[$j][$k]->duration)) &&
                            ((int) ($tuesday[$i]->time) + (int) ($tuesday[$i]->duration)) > ((int) ($tue[$j][$k]->time))) ||
                            (((int) ($tuesday[$i]->time)) < ((int) ($tue[$j][$k]->time) + (int) ($tue[$j][$k]->duration)) &&
                            ((int) ($tuesday[$i]->time)) >= ((int) ($tue[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $tue[$j][] = $tuesday[$i];
                    break;
                }
            }
            if ($collision == true) {
                $tue[] = array($tuesday[$i]);
            }
        }

        // WEDNESDAY
        for ($i = 1; $i < count($wednesday); $i++) {
            $collision = false;
            for ($j = 0; $j < count($wed); $j++) {
                $collision = false;
                for ($k = 0; $k < count($wed[$j]); $k++) {
                    if ((((int) ($wednesday[$i]->time) + (int) ($wednesday[$i]->duration)) <= ((int) ($wed[$j][$k]->time) + (int) ($wed[$j][$k]->duration)) &&
                            ((int) ($wednesday[$i]->time) + (int) ($wednesday[$i]->duration)) > ((int) ($wed[$j][$k]->time))) ||
                            (((int) ($wednesday[$i]->time)) < ((int) ($wed[$j][$k]->time) + (int) ($wed[$j][$k]->duration)) &&
                            ((int) ($wednesday[$i]->time)) >= ((int) ($wed[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $wed[$j][] = $wednesday[$i];
                    break;
                }
            }
            if ($collision == true) {
                $wed[] = array($wednesday[$i]);
            }
        }

        // THURSDAY
        for ($i = 1; $i < count($thursday); $i++) {
            $collision = false;
            for ($j = 0; $j < count($thu); $j++) {
                $collision = false;
                for ($k = 0; $k < count($thu[$j]); $k++) {
                    if ((((int) ($thursday[$i]->time) + (int) ($thursday[$i]->duration)) <= ((int) ($thu[$j][$k]->time) + (int) ($thu[$j][$k]->duration)) &&
                            ((int) ($thursday[$i]->time) + (int) ($thursday[$i]->duration)) > ((int) ($thu[$j][$k]->time))) ||
                            (((int) ($thursday[$i]->time)) < ((int) ($thu[$j][$k]->time) + (int) ($thu[$j][$k]->duration)) &&
                            ((int) ($thursday[$i]->time)) >= ((int) ($thu[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $thu[$j][] = $thursday[$i];
                    break;
                }
            }
            if ($collision == true) {
                $thu[] = array($thursday[$i]);
            }
        }

        // FRIDAY
        for ($i = 1; $i < count($friday); $i++) {
            $collision = false;
            for ($j = 0; $j < count($fri); $j++) {
                $collision = false;
                for ($k = 0; $k < count($fri[$j]); $k++) {
                    if ((((int) ($friday[$i]->time) + (int) ($friday[$i]->duration)) <= ((int) ($fri[$j][$k]->time) + (int) ($fri[$j][$k]->duration)) &&
                            ((int) ($friday[$i]->time) + (int) ($friday[$i]->duration)) > ((int) ($fri[$j][$k]->time))) ||
                            (((int) ($friday[$i]->time)) < ((int) ($fri[$j][$k]->time) + (int) ($fri[$j][$k]->duration)) &&
                            ((int) ($friday[$i]->time)) >= ((int) ($fri[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $fri[$j][] = $friday[$i];
                    break;
                }
            }
            if ($collision == true) {
                $fri[] = array($friday[$i]);
            }
        }

        if ($lang === "EN")
            $this->schedule = array("Mon" => $mon, "Tue" => $tue, "Wed" => $wed, "Thu" => $thu, "Fri" => $fri);
        else
            $this->schedule = array("Pon" => $mon, "Uto" => $tue, "Str" => $wed, "Štv" => $thu, "Pia" => $fri);
    }

    private function properText($text) {
        header('Content-Type: text/html; charset=utf-8');
        mb_internal_encoding('utf-8');
        $text = mb_convert_encoding($text, "ISO-8859-2", "UTF-8");
        return($text);
    }

    private function stringToArray($string, $maxSize) {
        $array = explode(" ", $string);
        $result = array();
        $str = "";
        foreach ($array as $a) {
            if (strlen($str . $a) > $maxSize) {
                $result[] = $str;
                $str = $a;
            } else {
                if ($str === "")
                    $str .= $a;
                else
                    $str .= " " . $a;
            }
        }
        $result[] = $str;
        return $result;
    }

    private function imageRectangleWithRoundedCorners($im, $x1, $y1, $x2, $y2, $radius, $color) {
        // draw rectangle without corners
        imagefilledrectangle($im, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
        imagefilledrectangle($im, $x1, $y1 + $radius, $x2, $y2 - $radius, $color);
        // draw circled corners
        imagefilledellipse($im, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($im, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($im, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($im, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    }

    private function drawSubject($image, $x, $y, $subject) {
        $font = '../fonts/Inconsolata.ttf';
        $fontSize = 10;
        imagefontheight(10);
        $RGB = hexrgb($subject->color);
        $c = imagecolorallocate($image, $RGB['red'], $RGB['green'], $RGB['blue']);
        $cc = imagecolorallocate($image, $RGB['red'] - 30, $RGB['green'] - 30, $RGB['blue'] - 30);
        $black = imagecolorallocate($image, 0x00, 0x00, 0x00);
        $white = imagecolorallocate($image, 0xff, 0xff, 0xff);
        $width = $subject->duration * Schedule::cellWidth;
        $this->imageRectangleWithRoundedCorners($image, $x + 1, $y + 1, $x + $width - 3, $y + Schedule::cellHeight - 1, 10, $c);

        if ($subject->type === "exercise") {
            imageline($image, $x, $y + 14, $x + $width, $y + 14, $white);
            imageline($image, $x, $y + Schedule::cellHeight - 14, $x + $width, $y + Schedule::cellHeight - 14, $white);
        }
        if ($subject->type === "consultation") {
            imageline($image, $x, $y + 20, $x + $width, $y + 20, $white);
            imageline($image, $x, $y + 24, $x + $width, $y + 24, $white);
            imageline($image, $x, $y + Schedule::cellHeight - 20, $x + $width, $y + Schedule::cellHeight - 20, $white);
            imageline($image, $x, $y + Schedule::cellHeight - 24, $x + $width, $y + Schedule::cellHeight - 24, $white);
        }

        // ROOM
        imagettftext($image, $fontSize, 0, $x + $width / 2 - 6.5 * strlen($subject->room) / 2, $y + 12, $black, $font, $subject->room);

        // NAME OF SUBJECT AND TEACHER
        $subject_name = "";
        $teacher_name = "";
        if ($subject->type === "lecture") {
            $subject_name = $this->stringToArray($subject->subject_name, 20);
            $teacher_name = $subject->name[0] . ". " . $subject->surname;
            if (mb_strlen($teacher_name, 'UTF-8') > 20) {
                $teacher_name = substr($teacher_name, 0, 17);
                $teacher_name.="...";
            }
        }
        if ($subject->type === "exercise") {
            $subject_name = $this->stringToArray($subject->subject_name, 15);
            $teacher_name = $subject->name[0] . ". " . $subject->surname;
            if (mb_strlen($teacher_name, 'UTF-8') > 15) {
                $teacher_name = substr($teacher_name, 0, 12);
                $teacher_name.="...";
            }
        }
        if ($subject->type === "consultation") {
            $subject_name = $this->stringToArray($subject->subject_acronym, 8);
            $teacher_name = $subject->name[0] . ". " . $subject->surname;
            if (mb_strlen($teacher_name, 'UTF-8') > 8) {
                $teacher_name = substr($teacher_name, 0, 5);
                $teacher_name.="...";
            }
        }

        // SUBJECT
        $vyska = Schedule::cellHeight / 2 - count($subject_name) * ($fontSize + 2) / 2;
        foreach ($subject_name as $s) {
            imagettftext($image, $fontSize + 1, 0, $x + $width / 2 - 7.5 * mb_strlen($s, 'UTF-8') / 2, $y + $vyska + $fontSize + 1, $black, $font, $s);
            $vyska += $fontSize + 2;
        }

        // TEACHER
        imagettftext($image, $fontSize, 0, $x + $width / 2 - 6.5 * mb_strlen($teacher_name, 'UTF-8') / 2, $y + Schedule::cellHeight - 2, $black, $font, $teacher_name);
    }

    function getScheduleImage() {
        // FIND OUT WIDTH AND HEIGHT
        $count = 0;
        foreach ($this->schedule as $row) {
            $count += count($row);
        }
        $width = 15 * Schedule::cellWidth;
        $height = $count * Schedule::cellHeight + 40 + 160; // 40 - pre hlavicku, 160 pre legendu
        // CREATE IMAGE
        $image = imagecreate($width, $height);
        $width = $width - 2;
        // COLORS
        //$transparent = imagecolorallocatealpha($image, 255, 255, 255, 100);
        //$gray = imagecolorallocate($image, 0xcc, 0xcc, 0xcc);
        $white = imagecolorallocate($image, 0xff, 0xff, 0xff);
        $gray_lite2 = imagecolorallocate($image, 0xde, 0xde, 0xde);
        $gray_lite = imagecolorallocate($image, 0xfa, 0xfa, 0xfa);
        $gray_dark = imagecolorallocate($image, 0x7f, 0x7f, 0x7f);

        $black = imagecolorallocate($image, 0x00, 0x00, 0x00);

        // FONT
        $font = '../fonts/Inconsolata.ttf';

        // TABLE
        $this->imageRectangleWithRoundedCorners($image, 1, 1, $width + 1, $count * Schedule::cellHeight + 40, 10, $black);
        $this->imageRectangleWithRoundedCorners($image, 0, 0, $width, $count * Schedule::cellHeight + 39, 10, $gray_lite);
        for ($i = 1; $i < 15; $i++) {
            $this->imageRectangleWithRoundedCorners($image, $i * Schedule::cellWidth + 1, 1, ($i + 1) * Schedule::cellWidth - 1, 39, 2, $gray_dark);
            $zac = ($i + 6) . ":00";
            $kon = ($i + 6) . ":50";
            imagettftext($image, 13, 0, $i * Schedule::cellWidth + Schedule::cellWidth / 2 - 9 * strlen($zac) / 2, 15, $white, $font, $zac);
            imagettftext($image, 13, 0, $i * Schedule::cellWidth + Schedule::cellWidth / 2 - 9 * strlen($kon) / 2, 36, $white, $font, $kon);
        }
        $vyska = 40;
        $i = 0;
        foreach ($this->schedule as $key => $row) {
            if (count($row) > 0) {
                if ($i % 2 == 1)
                    $this->imageRectangleWithRoundedCorners($image, Schedule::cellWidth, $vyska, $width, $vyska + count($row) * Schedule::cellHeight - 1, 10, $gray_lite2);
                else
                    $this->imageRectangleWithRoundedCorners($image, Schedule::cellWidth, $vyska, $width, $vyska + count($row) * Schedule::cellHeight - 1, 10, $gray_lite);
                $this->imageRectangleWithRoundedCorners($image, 1, $vyska + 1, Schedule::cellWidth - 1, $vyska + count($row) * Schedule::cellHeight - 1, 2, $gray_dark);
                imagettftext($image, 15, 0, Schedule::cellWidth / 2 - 9 * mb_strlen($key, 'UTF-8') / 2, $vyska + count($row) * Schedule::cellHeight / 2 + 7, $white, $font, $key);
                $vyska += count($row) * Schedule::cellHeight;
            }
            $i++;
        }

        // rr - ulozene riadky rozvrhu
        $rr = array();
        foreach ($this->schedule as $day) {
            foreach ($day as $row) {
                $rr[] = $row;
            }
        }

        // DRAW
        $vyska = 40;
        foreach ($rr as $row) {
            foreach ($row as $r) {
                $this->drawSubject($image, ((int) ($r->time) - 6) * Schedule::cellWidth, $vyska, $r);
            }
            $vyska+=Schedule::cellHeight;
        }
        $vyska+=20;

        // DRAW LEGEND
        $this->imageRectangleWithRoundedCorners($image, 20, $vyska + 1, 20 + Schedule::cellWidth - 1, $vyska + 39, 5, $gray_dark);
        imagettftext($image, 13, 0, 20 + Schedule::cellWidth, $vyska + 25, $black, $font, "  - prednáška");
        $vyska+=45;

        $this->imageRectangleWithRoundedCorners($image, 20, $vyska + 1, 20 + Schedule::cellWidth - 1, $vyska + 39, 5, $gray_dark);
        imageline($image, 20, $vyska + 7, 20 + Schedule::cellWidth - 1, $vyska + 7, $white);
        imageline($image, 20, $vyska + 33, 20 + Schedule::cellWidth - 1, $vyska + 33, $white);
        imagettftext($image, 13, 0, 20 + Schedule::cellWidth, $vyska + 25, $black, $font, "  - cvičenie");
        $vyska+=45;

        $this->imageRectangleWithRoundedCorners($image, 20, $vyska + 1, 20 + Schedule::cellWidth - 1, $vyska + 39, 5, $gray_dark);
        imageline($image, 20, $vyska + 9, 20 + Schedule::cellWidth - 1, $vyska + 9, $white);
        imageline($image, 20, $vyska + 12, 20 + Schedule::cellWidth - 1, $vyska + 12, $white);
        imageline($image, 20, $vyska + 40 - 9, 20 + Schedule::cellWidth - 1, $vyska + 40 - 9, $white);
        imageline($image, 20, $vyska + 40 - 12, 20 + Schedule::cellWidth - 1, $vyska + 40 - 12, $white);
        imagettftext($image, 13, 0, 20 + Schedule::cellWidth, $vyska + 25, $black, $font, "  - konzultácia");

        return $image;
    }

}
