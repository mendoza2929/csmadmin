<?php 



require('.././db_config.php');
require('.././alert.php');
adminLogin();


if(isset($_POST['booking_analytics'])){  
  $frm_data = filteration($_POST);
  $condition = "";
  if($frm_data['period']==1){
      $condition = "AND datentime BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()";
  }
  else if($frm_data['period']==2){
      $condition = "AND datentime BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()";
  }
  else if($frm_data['period']==3){
      $condition = "AND datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
  }
  // Combine the SQL query and condition into a single string
  $query = "SELECT COUNT(id) AS `count` FROM `room` WHERE `status` = 'breakage' $condition";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  $output = json_encode($row);
  echo $output;
}





?>