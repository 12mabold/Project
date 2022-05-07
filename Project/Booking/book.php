<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $supervisor = $_POST['supervisor'];
	$timeslot = $_POST['timeslot'];
    $mysqli = new mysqli('localhost', 'root', '', 'project');
    $stmt = $mysqli->prepare("INSERT INTO bookings (name, supervisor, date, timeslot) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $name, $supervisor, $date, $timeslot);
    $stmt->execute();
    $msg = "<div class='alert alert-success'>Booking Successfull</div>";
    $stmt->close();
    $mysqli->close();
}

$duration = 20;
$cleanup = 0;
$start = "09:00";
$end = "17:00";

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:iA")." - ". $endPeriod->format("H:iA");
        
    }
    
    return $slots;
}
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>

  <body>
    <div class="container">
        <h1 class="text-center">Confirm booking</h1><hr>
        <div class="row">
   <div class="col-md-12">
       <?php echo(isset($msg))?$msg:""; ?>
   </div>
    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
        foreach($timeslots as $ts){
    ?>
    <div class="col-md-2">
        <div class="form-group">
           <button class="btn btn-success book"><?php echo $ts; ?> </button>
        </div>
    </div>
    <?php } ?>
</div>

<!--Modal-->
<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!--Content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Booking for: <span id="slot"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                               <div class="form-group">
                                    <label for="">Time Slot</label>
                                    <input readonly type="text" class="form-control" id="timeslot" name="timeslot">
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input required type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="">Supervisor</label>
                                    <input required type="supervisor" class="form-control" name="supervisor">
                                </div>
                                <div class="form-group pull-right">
                                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
    $(".book").click(function(){
      var timeslot = $(this).attr('data-timeslot');
      $("#slot").html(timeslot);
      $("#timeslot").val(timeslot);
      $("#myModal").modal("show");
    });
</script>
  </body>

</html>
