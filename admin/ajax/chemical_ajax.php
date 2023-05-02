<?php 



require('.././db_config.php');
require('.././alert.php');
adminLogin();

if(isset($_POST['add_chemical'])){
    // Filter form data
    $frm_data = filteration($_POST);

    // Check if code already exists in database
    $q1 = "SELECT COUNT(*) FROM `chemical` WHERE `code`=?";
    $values = array($frm_data['code']);
    $result = select($q1, $values, 's');

    if ($result) {
        $count = $result->fetch_array()[0];
        if ($count > 0) {
            // Code already exists, return error
            echo "error";
        } else {
            // Code does not exist, insert new record
            $q2 = "INSERT INTO `chemical`(`name`, `area`, `unit`, `quantity`, `date_added`, `date_exp`, `code`) VALUES (?,?,?,?,?,?,?)";
            $values = array($frm_data['name'], $frm_data['area'], $frm_data['unit'], $frm_data['quantity'], $frm_data['date_added'], $frm_data['date_expiration'], $frm_data['code']);
    
            // Insert new record
            if (insert($q2, $values, 'sssisss')) {
                // Return success
                echo "success";
            } else {
                // Return error
                echo "error";
            }
        }
    } else {
        // Return error
        echo "error";
    }
    
}




if(isset($_POST['get_chemical'])){  
    $res = selectAll('chemical');
    $i=1;

    $data = "";

    while($row = mysqli_fetch_assoc($res)){
        $date_added = date('F j Y',strtotime($row['date_added']));
        $date_exp = date('F j Y',strtotime($row['date_exp']));
        if($row['status']==1){
       
            $status = "<button  onclick='toggleStatus($row[id],0)'class='btn btn-success btn-sm shadow-none'>Active</button>";
    
    }else{
    
        $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
    
    }
       
    $data.= "
    <tr class='align-middle'>
        <td>$i</td>
    
        <td> <span class='badge bg-info'>
        Chemical ID: $row[code]
        </span> <br> $row[name]</td>
        
        <td><span class='badge rounded-pill bg-light text-dark'>$row[unit]</span></td>
        <td>$row[quantity] </td>
        <td>$date_added</td>
        <td>$date_exp</td>
        <td>$status</td>
        <td>
         

            <button type='button' onclick='chemical_details($row[id])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-chemical'>
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


if(isset($_POST['edit_chemical'])){
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `chemical` WHERE  `id`=?",[$frm_data['edit_chemical']],'i');
    $res2 = select("SELECT * FROM `chemical_facilities` WHERE `chemical_id`=?",[$frm_data['edit_chemical']],'i');


    $chemicaldata = mysqli_fetch_assoc($res1);
    // $features =[];

    // if(mysqli_num_rows($res2)>0){
    //      while($row = mysqli_fetch_assoc($res2)){
    //         array_push($features,$row['facilities_id']);
    //      }
    // }

    $data = ["chemicaldata"=>$chemicaldata];

    
    $data = json_encode($data);

    echo $data;
}

if(isset($_POST['submit_edit_chemical'])){
    // $features = filteration(json_decode($_POST['features']));

    $frm_data = filteration($_POST);

    $flag = 0;

    $q1 = "UPDATE `chemical` SET `name`=?, `area`=?, `unit`=?, `quantity`=?, `date_added`=?,`date_exp`=? WHERE `id`=?";
    $values = [$frm_data['name'],$frm_data['area'],$frm_data['unit'],$frm_data['quantity'],$frm_data['date_added'],$frm_data['date_expiration'],$frm_data['chemical_id']];

    if(update($q1,$values,'sssissi')){
        $flag =1;
    }
    
  

    
    if($flag){
        echo 1;
    }else{
        echo 0;
    }
}





if(isset($_POST['toggleStatus'])){
    $frm_data = filteration($_POST);

    $q= "UPDATE `chemical` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'],$frm_data['toggleStatus']];

    if(update($q,$v,'ii')){
        echo 1;
    }else{
        echo 0; 
    }

}

if(isset($_POST['search_chemical'])){
    $frm_data = filteration($_POST);
    $query = "SELECT * FROM  `chemical` WHERE `name` LIKE?";
    $res = select($query,["%$frm_data[name]%"],'s');
    $i=1;
    $data= "";
    while($row = mysqli_fetch_array($res)){

        $date_added = date('F j Y',strtotime($row['date_added']));
        $date_exp = date('F j Y',strtotime($row['date_exp']));
        if($row['status']==1){
       
            $status = "<button  onclick='toggleStatus($row[id],0)'class='btn btn-success btn-sm shadow-none'>Active</button>";
    
    }else{
    
        $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
    
    }


        $data.= "
        <tr class='align-middle'>
        <td>$i</td>
    
        <td> <span class='badge bg-info'>
        Chemical ID: $row[code]
        </span> <br> $row[name]</td>
      
        <td><span class='badge rounded-pill bg-light text-dark'>$row[unit]</span></td>
        <td>$row[quantity] </td>
        <td>$date_added</td>
        <td>$date_exp</td>
        <td>$status</td>
        <td>
         

            <button type='button' onclick='chemical_details($row[id])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-chemical'>
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