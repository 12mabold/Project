<?php
    $mysqli = new mysqli('localhost', 'root', '', 'project');
    function build_calendar($month, $year){
	
	$datetoday = date('Y-m-d'); 
    $calendar = "<table class='table table-bordered'>"; 
    $calendar.= "<center><h2>$monthName $year</h2>"; 
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month-1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</button> "; 
    $calendar.= " <button class='changemonth btn btn-xs btn-primary' data-month='".date('m')."' data-year='".date('Y')."'>Current Month</button> "; 
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month+1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</button></center><br>"; 
    $calendar.= "<tr>";
	
	$daysOfWeek =array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);	
	
	$numberDays = date('t', $firstDayOfMonth);
	
	$dateComponents = getdate($firstDayOfMonth);
	
	$monthName = $dateComponents['month'];
	
	$daysOfWeek = $dateComponents['wday'];
	
	$dateToday = date('Y-m-d');
	
	$calendar = "<table class='table table-bordered'>";
	$calendar .="<center><h2>$monthName $year</h2></center>";
	$calendar .=
	
	$calendar .= "<tr>";
	
	if (is_array($daysOfWeek) || is_object($daysOfWeek))
{
    foreach ($daysOfWeek as $day)
    {
       $calendar .= "<th class='header'>$day</th>"; 
    }
	
	$calendar .= "</tr></tr>";
	
    if($daysOfWeek > 0){
		for($k=0;$k<$dayOfWeek;$k++){
			$calendar .= "<td></td>";
		}
	}
	
	$currentDay = 1;
	
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	
	while($currentDay <= $numberDays){
		
		if($daysOfWeek ==7){
		   $daysOfWeek = 0;
		   $calendar .= "</tr><tr>";
		}
		
		$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		$date = "$year-$month-$currentDayRel";
		
		if($dateToday==$date){
		   $calendar .= "<td class='today'><h4>$currentDay</h4>";
		}
		else {
		   $calendar .= "<td><h4>$currentDay</h4>";
		}
		
		$calendar .= "</td>";
		
		$currentDay++;
	    $daysOfWeek++;
	}
	if($daysOfWeek != 7){
		$remainingDays = 7-$daysOfWeek;
		for($i=0;$i<$remainingDays;$i++){
			$calendar .= "<td></td>";
		}
	}
	
	$calendar .= "</tr>";
	$calendar .= "</table>";
	
	echo $calendar;
}

?>



<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<title>Book a meeting</title>
<style>
  table{
	  table-layout: fixed;
  }
  
  td{
	  width: 33%;
  }
  
  .today{
	  background: yellow;
  }
</style>
</head>
<body>
  <div class="container">
   <div class="row">
    <div class="col-md-12">
	<?php
	  $dateComponents = getdate();
	  $month = $dateComponents['mon'];
	  $year = $dateComponents['year'];
	  echo build_calendar($month, $year);
	?>
    </div>
   </div>	
  </div>
</body>
</html>