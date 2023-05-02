<?php 



require('.././db_config.php');
require('.././alert.php');
adminLogin();

if(isset($_POST['get_bookings'])){  

    $frm_data = filteration($_POST);
    
    $query = "SELECT bo.*, bd.*  FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE (bo.order_id LIKE ? OR bd.course LIKE ? OR bd.user_name LIKE ? ) AND  (bo.booking_status =?  AND bo.refund=?) ORDER BY bo.booking_id DESC ";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","breakage",0],'sssss');

    $i=1;

    $table_data = "";

    if(mysqli_num_rows($res)==0){
      echo"<b>No Data Found!</b>";
      exit;
    }

    while($data = mysqli_fetch_array($res)){

        $date = date("d-m-Y",strtotime($data['datentime']));
        
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
            <b>Name: </b> $data[user_name]
            <br>
            <b>Course: </b> $data[course]
            <br>
            <b>Year: </b> $data[year] year
            <br>
            <b>Teacher: </b> $data[teacher]
            </td>
        
            <td>
                <b>Item: </b> $data[room_name]
                <br>
                <b>Remarks: </b> $data[quantity_no] pcs
                <br>
                <b>Check in: </b> $checkin
                <br>
                <b>Check out: </b> $checkout
                <br>
                <b>Date: </b> $date
            </td>
            
         
            
            <td>
        

            <button type='button' onclick='refund_booking($data[booking_id])' class='btn mt-2 btn-outline-success  btn-sm fw-bold shadow-none'>
            <i class='bi bi-cash'></i> Already Complied
          </button>
            </td>
        </tr>
        
        ";

        $i++;
    }

    echo $table_data;

}



if(isset($_POST['assign_room'])){  
    
$frm_data = filteration($_POST);

$query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id SET bo.arrival = ?, bo.rate_review=?, bd.room_no = ? WHERE bo.booking_id = ? ";

$values = [1,0,$frm_data['room_no'],$frm_data['booking_id']];

$res = update($query,$values,'iisi');

echo ($res==2) ? 1 : 0;  //it will update 2 rows so it will return 2 

}




if(isset($_POST['quantity_room'])){

$frm_data = filteration($_POST);

$breakage_qty = $frm_data['quantity_no'];
$room_id = $_SESSION['room']['id'];

// Update the quantity of the room in the `rooms` table based on the breakage:
$update_query = "UPDATE `rooms` SET `quantity` = `quantity` - ? WHERE `id` = ?";
$update_values = [$breakage_qty, $room_id];
$res = update($update_query, $update_values, 'ii');

// Update the `quantity_no` field in the `booking_details` table for the booking that had the breakage:
$booking_id = $frm_data['booking_id'];
$update_query = "UPDATE `booking_details` SET `quantity_no` = ? WHERE `booking_id` = ?";
$update_values = [$breakage_qty, $booking_id];
$res = update($update_query, $update_values, 'ii');

// Check if the remaining quantity of the room is zero and update the status of the room in the `rooms` table:
$select_query = "SELECT `quantity` FROM `rooms` WHERE `id` = ?";
$select_values = [$room_id];
$rq_result = select($select_query, $select_values, 'i');
$rq_fetch = mysqli_fetch_assoc($rq_result);

if ($rq_fetch['quantity'] == 0) {
$update_query = "UPDATE `rooms` SET `status` = 'unavailable' WHERE `id` = ?";
$update_values = [$room_id];
$res = update($update_query, $update_values, 'i');
}

// Update the booking status and refund in the `booking_order` table:
$query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id SET bo.booking_status = ?, bo.refund = ? WHERE bo.booking_id = ?";
$values = ['breakage', 0, $booking_id];
$res = update($query, $values, 'sii');

echo ($res == 1) ? 1 : 0;



}





if(isset($_POST['refund_booking'])){


$frm_data = filteration($_POST);

$room_id = $_SESSION['room']['id'];

// Get the quantity_no value from the booking_details table
$booking_id = $frm_data['booking_id'];
$select_query = "SELECT `quantity_no` FROM `booking_details` WHERE `booking_id` = ?";
$select_values = [$booking_id];
$qty_result = select($select_query, $select_values, 'i');
$qty_fetch = mysqli_fetch_assoc($qty_result);
$breakage_qty = $qty_fetch['quantity_no'];

// Update the quantity of the room in the `rooms` table based on the breakage:
$update_query = "UPDATE `rooms` SET `quantity` = `quantity` + ? WHERE `id` = ?";
$update_values = [$breakage_qty, $room_id];
$res = update($update_query, $update_values, 'ii');

// Check if the remaining quantity of the room is zero and update the status of the room in the `rooms` table:
$select_query = "SELECT `quantity` FROM `rooms` WHERE `id` = ?";
$select_values = [$room_id];
$rq_result = select($select_query, $select_values, 'i');
$rq_fetch = mysqli_fetch_assoc($rq_result);

if ($rq_fetch['quantity'] == 1) {
  $update_query = "UPDATE `rooms` SET `status` = 'available' WHERE `id` = ?";
  $update_values = [$room_id];
  $res = update($update_query, $update_values, 'i');
}

// Update the booking status and refund in the `booking_order` table:
$query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=? ";

$values = [1 ,$booking_id];
$res = update($query, $values, 'ii');
echo $res;

 

   


 

}




?>