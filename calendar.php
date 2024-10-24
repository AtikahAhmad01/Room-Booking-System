<?php
include 'db_conn.php';

function build_calendar($month, $year, $conn, $venueId){
    $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getDate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');
    
    $calendar = "<table class ='table table-bordered '>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<button class='changemonth btn btn-xs btn-primary m-1' data-month='".date('m',mktime(0,0,0,$month-1,1,$year))."' data-year='".date('Y',mktime(0,0,0,$month-1,1,$year))."'>Previous Month</button>";
    $calendar .= "<button class='changemonth btn btn-xs btn-primary m-1' data-month='".date('m')."'data-year='".date('Y')."'>Current Month</button>";
    $calendar .= "<button class='changemonth btn btn-xs btn-primary m-1' data-month='".date('m',mktime(0,0,0,$month+1,1,$year))."'data-year='".date('Y',mktime(0,0,0,$month+1,1,$year))."'>Next Month</button></center><br>";
    $calendar .= "</select><br>";
    $calendar .= "<tr>";
    
    foreach($daysOfWeek as $day) {
        $calendar .= "<th class='header table-dark'>$day</th>";
    }
    
    $calendar .= "</tr><tr>";
    
    if($dayOfWeek > 0){
        for ($k=0; $k < $dayOfWeek ; $k++) { 
            $calendar .= "<td></td>";
        }
    }
    
    $currentDay = 1;
    $month = str_pad($month,2,"0",STR_PAD_LEFT);
    
    while ($currentDay <= $numberDays) {
        if($dayOfWeek == 7){
            $dayOfWeek= 0;
            $calendar .="</tr><tr>";
        }
        
        $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $today = $date == date('Y-m-d')?"today":"";
        
        if($date < date('Y-m-d')){
            $calendar .="<td><h4>$currentDay</h4><button class='btn btn-danger btn-xs'>N/A</button>";
        } else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4><a href='booking.php?date=".$date."&VenueId=".$venueId."' class='btn btn-success btn-xs'>Book</a>";
        }
        
        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }
    
    if($dayOfWeek != 7){
        $remainingDays = 7-$dayOfWeek;
        for ($i=0; $i < $remainingDays ; $i++) { 
            $calendar .= "<td></td>";
        }
    }
    
    $calendar .= "</tr>";
    $calendar .= "</table>";
    
    return $calendar;
}

$dateComponents = getDate();
if(isset($_POST['month']) && isset($_POST['year'])){
    $month = $_POST['month'];
    $year = $_POST['year'];
} else {
    $month = $dateComponents['mon'];
    $year = $dateComponents['year'];
}

$venueId = isset($_POST['VenueId']) ? $_POST['VenueId'] : ''; // Assuming VenueId is posted along with month and year

echo build_calendar($month, $year, $conn, $venueId);
?>
