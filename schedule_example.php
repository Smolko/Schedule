<?php

include "Schedule.php";
$sub1 = new stdClass();

$sub1->subject_name = "Biology and shit to write trlalalalal truuuuuuu byspopasda ";
$sub1->duration = "3";
$sub1->day = "monday";
$sub1->time = "15:00";
$sub1->name = "katarína";
$sub1->surname = "Zakovaaaaaaaaaaaaa";
$sub1->room = "CD150";
$sub1->color = "ffffff";

$sub2 = new stdClass();

$sub2->subject_name = "Biology and shit to write trlalalalal truuuuuuu byspopasda ";
$sub2->duration = "3";
$sub2->day = "monday";
$sub2->time = "15:00";
$sub2->name = "katarína";
$sub2->surname = "Zakovaaaaaaaaaaaaa";
$sub2->room = "CD150";
$sub2->color = "ffffff";

$roz = array();
$roz[] = $sub1;
$roz[] = $sub2;

$rozvrh = new Schedule($roz,60,60,60);
$image = $rozvrh->getScheduleImage();
header("Content-type: image/png");
imagepng($image);
