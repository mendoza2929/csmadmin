<?php 



require('.././db_config.php');
require('.././alert.php');
adminLogin();



if(isset($_POST['add_equipment'])){
    // $features = filteration(json_decode($_POST['features']));

    $frm_data = filteration($_POST);
    $flag = 0;


    // Check if the room with the same name already exists
    $q_check = "SELECT COUNT(*) FROM `equipment` WHERE `name` = ?";
    $check_values = [$frm_data['name']];
    $result = select($q_check, $check_values, 's');
    $count = $result->fetch_row()[0];  // Fetch the result as a row and access the count value

    if($count > 0 ){
        
    }else{
        
        $q1 = "INSERT INTO `equipment`(`name`, `brand`,`made`,`unit`,`quantity`,`cost`,`date_added`) VALUES (?,?,?,?,?,?,?)";
        $values = [$frm_data['name'],$frm_data['brand'],$frm_data['made'],$frm_data['unit'],$frm_data['quantity'],$frm_data['cost'],$frm_data['date_added']];
    
    
        if(insert($q1,$values,'ssssiis')){
            $flag=1;
        }
    
        
        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }


}



if(isset($_POST['get_equipment'])){  
    $res = selectAll('equipment');
    $i=1;

    $data= "";

    while($row = mysqli_fetch_array($res)){
        $date = date('F j Y',strtotime($row['date_added']));
        if($row['status']==1){
   
                $status = "<button  onclick='toggleStatus($row[id],0)'class='btn btn-success btn-sm shadow-none'>Active</button>";
        
        }else{
        
            $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
        
        }


        $data.= "
            <tr class='align-middle'>
                <td>$i</td>
                <td><b>$row[name]</b></td>
                <td><span class='badge rounded-pill bg-light text-dark'>$row[brand]</span></td>
                <td><span class='badge rounded-pill bg-light text-dark'>$row[made]</span></td>
                <td>$row[cost]</td>
                <td>$row[unit]</td>
                <td>$row[quantity]</td>
                <td>$date</td>
                <td>$status</td>
                <td>
                  

                    <button type='button' onclick='equipment_details($row[id])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-equipment'>
                    <i class='i bi-pencil-square'></i>
                    </button>
                  
                    </button>
                </td>
            </tr>
        ";
        $i++;

        //  <button type='button' onclick='remove_room($row[id])' class='btn btn-danger btn-sm shadow-none'>
 
}
echo $data;
}



if (isset($_POST['edit_equipment'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `equipment` WHERE  `id`=?", [$frm_data['edit_equipment']], 'i');
    // $res2 = select("SELECT * FROM `equipment_facilities` WHERE `equipment_id`=?", [$frm_data['edit_equipment']], 'i');


    $equipmentdata = mysqli_fetch_assoc($res1);


    $data = ["equipmentdata" => $equipmentdata];


    $data = json_encode($data);

    echo $data;
}






if (isset($_POST['submit_edit_equipment'])) {
    // $features = filteration(json_decode($_POST['features']));

    $frm_data = filteration($_POST);

    $flag = 0;

    $q1 = "UPDATE `equipment` SET `name`=?, `brand`=?, `made`=?, `unit`=?,`quantity`=?, `cost`=?, `date_added`=? WHERE `id`=?";
    $values = [$frm_data['name'], $frm_data['brand'], $frm_data['made'] , $frm_data['unit'], $frm_data['quantity'], $frm_data['cost'], $frm_data['date_added'], $frm_data['equipment_id']];

  
    if(update($q1,$values,'ssssiisi')){
        $flag =1;
    }
    
  

    
    if($flag){
        echo 1;
    }else{
        echo 0;
    }
}





if (isset($_POST['toggleStatus'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `equipment` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggleStatus']];

    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }

}

if (isset($_POST['search_equipment'])) {
    $frm_data = filteration($_POST);
    $query = "SELECT * FROM  `equipment` WHERE `name` LIKE?";
    $res = select($query, ["%$frm_data[name]%"], 's');
    $i = 1;
    $data = "";
    while ($row = mysqli_fetch_array($res)) {
        $date = date('F j Y',strtotime($row['date_added']));
        if($row['status']==1){
   
                $status = "<button  onclick='toggleStatus($row[id],0)'class='btn btn-success btn-sm shadow-none'>Active</button>";
        
        }else{
        
            $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
        
        }


        $data .= "
        <tr class='align-middle'>
                <td>$i</td>
                <td><b>$row[name]</b></td>
                <td><span class='badge rounded-pill bg-light text-dark'>$row[brand]</span></td>
                <td><span class='badge rounded-pill bg-light text-dark'>$row[made]</span></td>
                <td>$row[cost]</td>
                <td>$row[unit]</td>
                <td>$row[quantity]</td>
                <td>$date</td>
                <td>$status</td>
                <td>
                  

                    <button type='button' onclick='equipment_details($row[id])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-equipment'>
                    <i class='i bi-pencil-square'></i>
                    </button>
                  
                    </button>
                </td>
            </tr>
        ";
        $i++;

        //  <button type='button' onclick='remove_room($row[id])' class='btn btn-danger btn-sm shadow-none'>

    }
    echo $data;
}





?>