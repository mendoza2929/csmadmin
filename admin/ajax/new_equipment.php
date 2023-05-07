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
            <b>Teacher Name: </b> $data[teacher]
            <br>
            <b>Room Number: </b> $data[apr_no]
            <br>
            <b>Group No: </b> $data[group_no]
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
              <i class='bi bi-clipboard-plus'></i> Approved Return
            </button>
            <br>

            <button type='button' onclick='quantity_equipment($data[booking_id])' class='btn text-white btn-sm fw-bold bg-danger shadow-none mt-2' data-bs-toggle='modal' data-bs-target='#quantity-equipment'>
            <i class='bi bi-clipboard-plus'></i> Remarks
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
  
  $query = "UPDATE `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id SET eo.arrival = ?, ed.equipment_no = ? WHERE eo.booking_id = ? ";
  
  $values = [1,$frm_data['equipment_no'],$frm_data['booking_id']];
  
  $res = update($query,$values,'isi');
  
  echo ($res==2) ? 1 : 0;  //it will update 2 rows so it will return 2 
  
  }





if(isset($_POST['quantity_equipment'])){


  $frm_data = filteration($_POST);

  $breakage_qty = $frm_data['quantity_no'];
  $res_group = $frm_data['res_group'];
  $res_breakage = $frm_data['res_breakage'];
  $room_id = $_SESSION['equipment']['id'];
  
  // Update the quantity of the room in the `rooms` table based on the breakage:
  $update_query = "UPDATE `equipment` SET `quantity` = `quantity` - ? WHERE `id` = ?";
  $update_values = [$breakage_qty, $room_id];
  $res = update($update_query, $update_values, 'ii');
  
  // Update the `quantity_no` field in the `booking_details` table for the booking that had the breakage:
  $booking_id = $frm_data['booking_id'];
  $update_query = "UPDATE `equipment_details_final` SET `quantity_no` = ? , `res_breakage` = ?  , `res_group` = ? WHERE `booking_id` = ?";
  $update_values = [$breakage_qty, $res_breakage, $res_group, $booking_id];
  $res = update($update_query, $update_values, 'issi');
  
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