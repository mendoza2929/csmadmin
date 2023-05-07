<?php 


require('.././db_config.php');
require('.././alert.php');
adminLogin();



if(isset($_POST['get_booking_chemical'])){  

  $frm_data = filteration($_POST);
  
  $query = "SELECT co.*, cd.*  FROM `chemical_order_final` co INNER JOIN `chemical_details_final` cd ON co.booking_id = cd.booking_id WHERE (co.order_id LIKE ? OR cd.course LIKE ? OR cd.username LIKE ? ) AND  (co.booking_status =?  AND co.arrival=?) ORDER BY co.booking_id DESC ";

  $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","approved",0],'sssss');

  $i=1;

  $table_data = "";

  if(mysqli_num_rows($res)==0){
    echo"<b>No Data Found!</b>";
    exit;
  }

  while($data = mysqli_fetch_array($res)){

      $date = date("F j Y",strtotime($data['datentime']));
      
      $checkin= date("F j Y",strtotime($data['check_in']));
                  
      $checkout= date("F j Y",strtotime($data['check_out']));

      $table_data .="
      
      <tr>
          <td>$i</td>
          <td>
          <span class='badge bg-primary'>
              Student ID: $data[email]
          </span>
          <br>
          <b>Representative: </b> $data[username]
          <br>
          <b>Course: </b> $data[course]
          <br>
          <b>Year: </b> $data[year] year
          <br>
          <b>Teacher Name: </b> $data[teacher]
          <br>
          <b>Room Number: </b> $data[apr_no]
          <br>
          <b>Group No: </b> $data[group_no]
          </td>
          <td>
          <b>Item: </b> $data[chemical_name]
          <br>
          <b>Concentration/State: </b> $data[state] percent
          <br>
          <b>Volume: </b> $data[volume] Needed
          </td>
          <td>
              <b>Date Requested: </b> $checkin
              <br>
              <b>Date Needed: </b> $checkout
              <br>
              <b>Date: </b> $date
          </td>
          <td>
         
          <br>

          <button type='button' onclick='quantity_chemical($data[booking_id])' class='btn text-white btn-sm fw-bold bg-success shadow-none mt-2' data-bs-toggle='modal' data-bs-target='#quantity-chemical'>
          <i class='bi bi-clipboard-plus'></i> Approved Chemical
        </button>
        <br>
        


          
      </tr>
      
      ";

      $i++;
  }

  echo $table_data;

}

// <button type='button' onclick='assign_chemical($data[booking_id])' class='btn text-white btn-sm fw-bold bg-success shadow-none' data-bs-toggle='modal' data-bs-target='#assign-chemical'>
// <i class='bi bi-clipboard-plus'></i> Approved Chemical
// </button>


if(isset($_POST['assign_chemical'])){  
      
$frm_data = filteration($_POST);

$query = "UPDATE `chemical_order_final` co INNER JOIN `chemical_details_final` cd ON co.booking_id = cd.booking_id SET co.arrival = ?, cd.room_no = ? WHERE co.booking_id = ? ";

$values = [1,$frm_data['chemical_no'],$frm_data['booking_id']];

$res = update($query,$values,'isi');

echo ($res==2) ? 1 : 0;  //it will update 2 rows so it will return 2 

}



if(isset($_POST['quantity_chemical'])){


  $frm_data = filteration($_POST);

  $breakage_qty = $frm_data['quantity_no'];
  $room_id = $_SESSION['chemical']['id'];
  
  // Update the quantity of the room in the `rooms` table based on the breakage:
  $update_query = "UPDATE `chemical` SET `quantity` = `quantity` - ? WHERE `id` = ?";
  $update_values = [$breakage_qty, $room_id];
  $res = update($update_query, $update_values, 'ii');
  
  // Update the `quantity_no` field in the `booking_details` table for the booking that had the breakage:
  $booking_id = $frm_data['booking_id'];
  $update_query = "UPDATE `chemical_details_final` SET `quantity_no` = ? WHERE `booking_id` = ?";
  $update_values = [$breakage_qty, $booking_id];
  $res = update($update_query, $update_values, 'ii');
  
  // Check if the remaining quantity of the room is zero and update the status of the room in the `rooms` table:
  $select_query = "SELECT `quantity` FROM `chemical` WHERE `id` = ?";
  $select_values = [$room_id];
  $rq_result = select($select_query, $select_values, 'i');
  $rq_fetch = mysqli_fetch_assoc($rq_result);
  
  if ($rq_fetch['quantity'] == 0) {
    $update_query = "UPDATE `chemical` SET `status` = 'unavailable' WHERE `id` = ?";
    $update_values = [$room_id];
    $res = update($update_query, $update_values, 'i');
  }
  
  // Update the booking status and refund in the `booking_order` table:
  $query = "UPDATE `chemical_order_final` co INNER JOIN `chemical_details_final` cd ON co.booking_id = cd.booking_id SET co.booking_status = ?, co.arrival = ? WHERE co.booking_id = ?";
  $values = ['approved', 1, $booking_id];
  $res = update($query, $values, 'sii');
  
  echo ($res == 1) ? 1 : 0;
  




 

}


?>