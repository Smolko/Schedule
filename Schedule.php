<?php

class Schedule {
    /*  schedule - array of objects
     *  {
     *      subject_name;
     *      duration;
     *      day;
     *      time;
     *      name;
     *      surname;
     *      room; 
     *  }
     */

    private $schedule;
    private $cellWidth = 60;
    private $cellHeight = 90;
    private $fontSize = 10;
    private $maxLettersInRow = 20;
    private $fontRatio = 0.5;

    public function Schedule($schedule, $cellWidth, $cellHeight, $fontSize) {
        $this->schedule = $this->makeStyledSchedule($schedule);   
    }
    
    private function calcMinWidth($schedule, $fontWidth){
        $maxLength = 0;
        
        foreach($schedule as $row){
            $sub = explode(" ",$row->subject_name);
            foreach($sub as $r){
                if (strlen($r) >$maxLength)
                    $maxLength = strlen ($r);
            }
        }   
        
        return $maxLength*$fontWidth;
    }
    
        private function calcMinHeight($schedule, $fontHeight){
        $maxLength = 0;
        
        foreach($schedule as $row){
            $sub = explode(" ",$row->subject_name);
            foreach($sub as $r){
                if (strlen($r) >$maxLength)
                    $maxLength = strlen ($r);
            }
        }   
        
        return $maxLength*$fontWidth;
    }

    // $schedule - array of subjects
    // $dayName - name of day (ie "monday");
    // returns array with given $dayName 
    private function getSubjectsByDayName($schedule, $dayName) {
        $array = array();
        foreach ($schedule as $row) {
            if ($row->day === $dayName)
                $array[] = $row;
        }

        return $array;
    }

    // $subjects - array of subjects
    // returns array of arrays because some subjects are in the same time, so they cant be in the same row in schedule
    private function getSubjectsInRows($subjects) {

        $array = array();
        if (count($subjects) > 0)
            $array = array(array($subjects[0]));

        for ($i = 1; $i < count($subjects); $i++) {
            $collision = false;
            for ($j = 0; $j < count($array); $j++) {
                $collision = false;
                for ($k = 0; $k < count($array[$j]); $k++) {
                    if ((((int) ($subjects[$i]->time) + (int) ($subjects[$i]->duration)) <= ((int) ($array[$j][$k]->time) + (int) ($array[$j][$k]->duration)) &&
                            ((int) ($subjects[$i]->time) + (int) ($subjects[$i]->duration)) > ((int) ($array[$j][$k]->time))) ||
                            (((int) ($subjects[$i]->time)) < ((int) ($array[$j][$k]->time) + (int) ($array[$j][$k]->duration)) &&
                            ((int) ($subjects[$i]->time)) >= ((int) ($array[$j][$k]->time)))
                    ) {
                        $collision = true;
                        break;
                    }
                }
                if ($collision == false) {
                    $array[$j][] = $subjects[$i];
                    break;
                }
            }
            if ($collision == true) {
                $array[] = array($subjects[$i]);
            }
        }

        return $array;
    }

    // sets variable $schedule where key is dayName and value is array of rows
    private function makeStyledSchedule($schedule) {

        $monday = $this->getSubjectsByDayName($schedule, "monday");
        $tuesday = $this->getSubjectsByDayName($schedule, "tuesday");
        $wednesday = $this->getSubjectsByDayName($schedule, "wednesday");
        $thursday = $this->getSubjectsByDayName($schedule, "thursday");
        $friday = $this->getSubjectsByDayName($schedule, "friday");

        $mon = $this->getSubjectsInRows($monday);
        $tue = $this->getSubjectsInRows($tuesday);
        $wed = $this->getSubjectsInRows($wednesday);
        $thu = $this->getSubjectsInRows($thursday);
        $fri = $this->getSubjectsInRows($friday);

        $sch = array("Mon" => $mon, "Tue" => $tue, "Wed" => $wed, "Thu" => $thu, "Fri" => $fri);
        
        return $sch;
    }

    // for special unicode characters
    private function properText($text) {
        header('Content-Type: text/html; charset=utf-8');
        mb_internal_encoding('utf-8');
        $text = mb_convert_encoding($text, "ISO-8859-2", "UTF-8");
        return($text);
    }

    // for no overflowing
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

    private function hexrgb($hexstr) {
        $int = hexdec($hexstr);

        return array(
            "red" => 0xFF & ($int >> 0x10),
            "green" => 0xFF & ($int >> 0x8),
            "blue" => 0xFF & $int
        );
    }

    private function drawSubject($image, $x, $y, $subject) {
        $font = '../fonts/Inconsolata.ttf';
        imagefontheight($this->fontSize);
        $RGB = $this->hexrgb($subject->color);
        $subjectColor = imagecolorallocate($image, $RGB['red'], $RGB['green'], $RGB['blue']);
        $black = imagecolorallocate($image, 0x00, 0x00, 0x00);
        $white = imagecolorallocate($image, 0xff, 0xff, 0xff);
        $width = $subject->duration * $this->cellWidth;
        $this->imageRectangleWithRoundedCorners($image, $x + 1, $y + 1, $x + $width - 3, $y + $this->cellHeight - 1, 10, $subjectColor);

        // ROOM
        imagettftext($image, $this->fontSize, 0, $x + $width / 2 - 6.5 * strlen($subject->room) / 2, $y + 12, $black, $font, $subject->room);

        // NAME OF SUBJECT AND TEACHER
        $subject_name = $this->stringToArray($subject->subject_name, $this->maxLettersInRow);
        $teacher_name = $subject->name[0] . ". " . $subject->surname;
        if (mb_strlen($teacher_name, 'UTF-8') > $this->maxLettersInRow) {
            $teacher_name = substr($teacher_name, 0, $this->maxLettersInRow - 3);
            $teacher_name.="...";
        }

        // SUBJECT
        $vyska = $this->cellHeight / 2 - count($subject_name) * ($this->fontSize + 2) / 2;
        foreach ($subject_name as $s) {
            imagettftext($image, $this->fontSize + 1, 0, $x + $width / 2 - 7.5 * mb_strlen($s, 'UTF-8') / 2, $y + $vyska + $this->fontSize + 1, $black, $font, $s);
            $vyska += $this->fontSize + 2;
        }

        // TEACHER
        imagettftext($image, $this->fontSize, 0, $x + $width / 2 - 6.5 * mb_strlen($teacher_name, 'UTF-8') / 2, $y + $this->cellHeight - 2, $black, $font, $teacher_name);
    }

    function getScheduleImage() {
        // FIND OUT WIDTH AND HEIGHT
        $count = 0;
        foreach ($this->schedule as $row) {
            $count += count($row);
        }
        $width = 15 * $this->cellWidth;
        $height = $count * $this->cellHeight + 42; // 40 - pre hlavicku, 160 pre legendu
        // CREATE IMAGE
        $image = imagecreate($width, $height);
        $width = $width - 2;

        // COLORS
        $transparent = imagecolorallocatealpha($image, 255, 255, 255, 100);
        //$gray = imagecolorallocate($image, 0xcc, 0xcc, 0xcc);
        $white = imagecolorallocate($image, 0xff, 0xff, 0xff);
        $gray_lite2 = imagecolorallocate($image, 0xde, 0xde, 0xde);
        $gray_lite = imagecolorallocate($image, 0xfa, 0xfa, 0xfa);
        $gray_dark = imagecolorallocate($image, 0x7f, 0x7f, 0x7f);

        $black = imagecolorallocate($image, 0x00, 0x00, 0x00);

        // FONT
        $font = '../fonts/Inconsolata.ttf';
        // TABLE
        $this->imageRectangleWithRoundedCorners($image, 1, 1, $width + 1, $count * $this->cellHeight + 40, 10, $black);
        $this->imageRectangleWithRoundedCorners($image, 0, 0, $width, $count * $this->cellHeight + 39, 10, $gray_lite);
        for ($i = 1; $i < 15; $i++) {
            $this->imageRectangleWithRoundedCorners($image, $i * $this->cellWidth + 1, 1, ($i + 1) * $this->cellWidth - 1, 39, 2, $gray_dark);
            $zac = ($i + 6) . ":00";
            $kon = ($i + 6) . ":50";
            imagettftext($image, 13, 0, $i * $this->cellWidth + $this->cellWidth / 2 - 9 * strlen($zac) / 2, 15, $white, $font, $zac);
            imagettftext($image, 13, 0, $i * $this->cellWidth + $this->cellWidth / 2 - 9 * strlen($kon) / 2, 36, $white, $font, $kon);
        }
        $vyska = 40;
        $i = 0;
        foreach ($this->schedule as $key => $row) {
            if (count($row) > 0) {
                if ($i % 2 == 1)
                    $this->imageRectangleWithRoundedCorners($image, $this->cellWidth, $vyska, $width, $vyska + count($row) * $this->cellHeight - 1, 10, $gray_lite2);
                else
                    $this->imageRectangleWithRoundedCorners($image, $this->cellWidth, $vyska, $width, $vyska + count($row) * $this->cellHeight - 1, 10, $gray_lite);
                $this->imageRectangleWithRoundedCorners($image, 1, $vyska + 1, $this->cellWidth - 1, $vyska + count($row) * $this->cellHeight - 1, 2, $gray_dark);
                imagettftext($image, 15, 0, $this->cellWidth / 2 - 9 * mb_strlen($key, 'UTF-8') / 2, $vyska + count($row) * $this->cellHeight / 2 + 7, $white, $font, $key);
                $vyska += count($row) * $this->cellHeight;
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
                $this->drawSubject($image, ((int) ($r->time) - 6) * $this->cellWidth, $vyska, $r);
            }
            $vyska+=$this->cellHeight;
        }
        $vyska+=20;


        return $image;
    }

}
