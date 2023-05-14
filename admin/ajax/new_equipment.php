<?php 


require('.././db_config.php');
require('.././alert.php');
adminLogin();


if(isset($_POST['get_bookings_equipment'])){  

    $frm_data = filteration($_POST);
    
    $query = "SELECT eo.*, ed.*  FROM `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id WHERE (eo.order_id LIKE ? OR ed.course LIKE ? OR ed.username LIKE ? ) AND  (eo.booking_status =?  AND eo.arrival=?) ORDER BY eo.booking_id DESC ";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","approved",0],'sssss');

    $i=1;

    $table_data = "";

    if(mysqli_num_rows($res)==0){
      echo"<b>No Data Found!</b>";
      exit;
    }

    while($data = mysqli_fetch_array($res)){

      $date = date('F j Y',strtotime($data['datentime']));
        
        $checkin= date("d-m-Y g:i a",strtotime($data['check_in']));
                    
        $checkout= date("d-m-Y g:i a",strtotime($data['check_out']));

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
            <b>Subject: </b> $data[lab] 
            <br>
            <b>Teacher Name: </b> $data[teacher]
            <br>
            <b>Room Number: </b> $data[apr_no]
            <br>
            <b>Group No: </b> $data[group_no]
            </td>
            <td>
            <b>$data[group_mate]</b>
            </td>
            <td>
            <b>Item: </b> $data[equipment_name]
            <br>
            <b>Quantity: </b> $data[quantity] pcs
            </td>
            <td>
                <b>Start Class: </b> $checkin
                <br>
                <b>End Class: </b> $checkout
                <br>
                <b>Date: </b> $date
            </td>
            <td>
            <button type='button' onclick='assign_equipment($data[booking_id])' class='btn text-white btn-sm fw-bold bg-success shadow-none' data-bs-toggle='modal' data-bs-target='#assign-equipment'>
              Return
            </button>
            <br>

            <button type='button' onclick='quantity_equipment($data[booking_id])' class='btn text-white btn-sm fw-bold bg-danger shadow-none mt-2' data-bs-toggle='modal' data-bs-target='#quantity-equipment'>
           Remarks
          </button>
          <br>
          
 

            
        </tr>
        
        ";

        $i++;
    }

    echo $table_data;

}



if(isset($_POST['assign_equipment'])){  
    
  $frm_data = filteration($_POST);
  
  $query = "UPDATE `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id SET eo.arrival = ? WHERE eo.booking_id = ? ";
  
  $values = [1,$frm_data['booking_id']];
  
  $res = update($query,$values,'ii');
   // Check if the update was successful
   if ($res == 1) {
    // Update the rooms availability by adding the quantity from booking_details
    $booking_id = $frm_data['booking_id'];

    // Retrieve the quantity from the booking_details
    $quantity_query = "SELECT `quantity`, `equipment_name` FROM `equipment_details_final` WHERE `booking_id` = ?";
    $quantity_res = select($quantity_query, [$booking_id], 'i');

    if (mysqli_num_rows($quantity_res) > 0) {
      $quantity_row = mysqli_fetch_assoc($quantity_res);
      $quantity = $quantity_row['quantity'];
      $room_name = $quantity_row['equipment_name'];

      // Update the rooms availability
      $update_avail_query = "UPDATE `equipment` SET `avail` = `avail` + ? WHERE `name` = ?";
      update($update_avail_query, [$quantity, $room_name], 'is');
    }
  }

  
  echo ($res==1) ? 1 : 0;  //it will update 1 rows so it will return 2 
  
  }





if(isset($_POST['quantity_equipment'])){


  $frm_data = filteration($_POST);

  $breakage_qty = $frm_data['quantity_no'];
  // $res_group = $frm_data['res_group'];
  $res_breakage = $frm_data['res_breakage'];
  $room_id = $_SESSION['equipment']['id'];

  $booking_id = $frm_data['booking_id'];
  $select_query = "SELECT `group_mate` FROM `equipment_details_final` WHERE `booking_id` = ?";
  $select_values = [$booking_id];
  $bd_result = select($select_query, $select_values, 'i');
  $bd_fetch = mysqli_fetch_assoc($bd_result);
  $group_mates = $bd_fetch['group_mate'];
  $group_mate_list = explode(",", $group_mates);

// Check if the names entered in `res_breakage` field match the group mates in the booking details:
  $res_breakages = explode(",", $frm_data['res_breakage']);
  $validated_names = array();
  foreach ($res_breakages as $res_breakage) {
    $res_breakage = trim($res_breakage);
    if (!empty($res_breakage) && in_array($res_breakage, $group_mate_list)) {
      $validated_names[] = $res_breakage;
    } else {
      echo "same_name";
      return;
    }
  }
  
  if (empty($validated_names)) {
    echo "same_name";
    return;
  }

  // Get the booking details for the given booking ID:
    $booking_id = $frm_data['booking_id'];
    $select_query = "SELECT `quantity` FROM `equipment_details_final` WHERE `booking_id` = ?";
    $select_values = [$booking_id];
    $bd_result = select($select_query, $select_values, 'i');
    $bd_fetch = mysqli_fetch_assoc($bd_result);
    $booking_qty = $bd_fetch['quantity'];
  
    // Check if the quantity entered by the user matches the quantity in the booking details:
    if ($breakage_qty > $booking_qty) {
      echo "breakage_qty";
      return;
    }
  

  
  // Get the booking details for the given booking ID:
    // $booking_id = $frm_data['booking_id'];
    $select_query = "SELECT `quantity` FROM `equipment_details_final` WHERE `booking_id` = ?";
    $select_values = [$booking_id];
    $bd_result = select($select_query, $select_values, 'i');
    $bd_fetch = mysqli_fetch_assoc($bd_result);
    $booking_qty = $bd_fetch['quantity'];
  
    // Check if the quantity entered by the user matches the quantity in the booking details:
  if ($breakage_qty > $booking_qty) {
      echo "The breakage quantity exceeds the quantity in the booking details.";
      return;
    }

  
  
  // Update the quantity of the room in the `rooms` table based on the breakage:
  $update_query = "UPDATE `equipment` SET `quantity` = `quantity` - ? WHERE `id` = ?";
  $update_values = [$breakage_qty, $room_id];
  $res = update($update_query, $update_values, 'ii');

    // Update the availability of the room based on the updated quantity:
    $select_query = "SELECT `quantity` FROM `equipment` WHERE `id` = ?";
    $select_values = [$room_id];
    $rq_result = select($select_query, $select_values, 'i');
    $rq_fetch = mysqli_fetch_assoc($rq_result);
  
    if ($rq_fetch['quantity'] >= 0) {
      $update_query = "UPDATE `equipment` SET `avail` = `quantity` WHERE `id` = ?";
      $update_values = [$room_id];
      $res = update($update_query, $update_values, 'i');
    } else {
      $update_query = "UPDATE `equipment` SET `avail` = `avail` + ? WHERE `id` = ?";
      $update_values = [$breakage_qty, $room_id];
      $res = update($update_query, $update_values, 'ii');
    }
  
  // Update the `quantity_no` field in the `booking_details` table for the booking that had the breakage:
  // $booking_id = $frm_data['booking_id'];
  $update_query = "UPDATE `equipment_details_final` SET `quantity_no` = ? , `res_breakage` = ?  WHERE `booking_id` = ?";
  $update_values = [$breakage_qty, implode(",", $validated_names), $booking_id];
  $res = update($update_query, $update_values, 'isi');
  
  // Check if the remaining quantity of the room is zero and update the status of the room in the `rooms` table:
  $select_query = "SELECT `quantity` FROM `equipment` WHERE `id` = ?";
  $select_values = [$room_id];
  $rq_result = select($select_query, $select_values, 'i');
  $rq_fetch = mysqli_fetch_assoc($rq_result);
  
  if ($rq_fetch['quantity'] == 0) {
    $update_query = "UPDATE `equipment` SET `status` = 'unavailable' WHERE `id` = ?";
    $update_values = [$room_id];
    $res = update($update_query, $update_values, 'i');
  }
  
  // Update the booking status and refund in the `booking_order` table:
  $query = "UPDATE `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id SET eo.booking_status = ?, eo.refund = ? WHERE eo.booking_id = ?";
  $values = ['breakage', 0, $booking_id];
  $res = update($query, $values, 'sii');
  
  echo ($res == 1) ? 1 : 0;
  




 

}



?>