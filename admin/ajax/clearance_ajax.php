<?php


require('.././db_config.php');
require('.././alert.php');
adminLogin();


if(isset($_POST['add_clearance'])){
    // $features = filteration(json_decode($_POST['features']));

    $frm_data = filteration($_POST);
    $flag = 0;

    $q1 = "INSERT INTO `clearance`(`date`, `cais`, `carch`, `ccie`, `coe`, `ccs`, `cfes`, `che`, `cla`, `claw`, `cpers`, `csm`, `cswcd`,`cte`, `esu`, `graduate`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $values = [$frm_data['date'],$frm_data['cais'],$frm_data['carch'],$frm_data['ccie']
    ,$frm_data['coe'],$frm_data['ccs'],$frm_data['cfes'],$frm_data['che'],$frm_data['cla']
    ,$frm_data['claw'],$frm_data['cpers'],$frm_data['csm'],$frm_data['cswcd'],$frm_data['cte'],$frm_data['esu'],$frm_data['graduate']];

    
    if(insert($q1,$values,'siiiiiiiiiiiiiii')){
        $flag=1;
    }

    
    if($flag){
        echo 1;
    }else{
        echo 0;
    }


}

if(isset($_POST['get_clearance'])){  
    $res = selectAll('clearance');
    $i=0;

    $data= "";

    while($row = mysqli_fetch_array($res)){
        $date = date('F j Y',strtotime($row['date']));
    
        $data.= "
            <tr class='align-middle'>
                <td>$date</td>
                <td>$row[cais]</td>
                <td>$row[carch]</td>
                <td>$row[ccie]</td>
                <td>$row[coe]</td>
                <td>$row[ccs]</td>
                <td>$row[cfes]</td>
                <td>$row[che]</td>
                <td>$row[cla]</td>
                <td>$row[claw]</td>
                <td>$row[cpers]</td>
                <td>$row[csm]</td>
                <td>$row[cswcd]</td>
                <td>$row[cte]</td>
                <td>$row[esu]</td>
                <td>$row[graduate]</td>

                <td>
     

                <button type='button' onclick='clearance_details($row[sr_no])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-clearance'>
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

if(isset($_POST['edit_clearance'])){
$frm_data = filteration($_POST);

$res1 = select("SELECT * FROM `clearance` WHERE  `sr_no`=?",[$frm_data['edit_clearance']],'i');



$clearancedata = mysqli_fetch_assoc($res1);



$data = ["clearancedata"=>$clearancedata];


$data = json_encode($data);

echo $data;
}



if(isset($_POST['submit_edit_clearance'])){

$frm_data = filteration($_POST);

$flag = 0;

// check if clearance_id is present
if(isset($frm_data['clearance_id'])){

    $q1 = "UPDATE `clearance` SET `date`=?,`cais`=?,`carch`=?,`ccie`=?,`coe`=?,`ccs`=?,`cfes`=?,`che`=?,`cla`=?,`claw`=?,`cpers`=?,`csm`=?,`cswcd`=?,`cte`=?,`esu`=?,`graduate`=? WHERE `sr_no`=?";
    $values = [$frm_data['date'],$frm_data['cais'],$frm_data['carch'],$frm_data['ccie']
    ,$frm_data['coe'],$frm_data['ccs'],$frm_data['cfes'],$frm_data['che'],$frm_data['cla']
    ,$frm_data['claw'],$frm_data['cpers'],$frm_data['csm'],$frm_data['cswcd'],$frm_data['cte'],$frm_data['esu'],$frm_data['graduate'],$frm_data['clearance_id']];

    if(update($q1,$values,'siiiiiiiiiiiiiiii')){
        $flag=1;
    }
} else {
    // display an error message or redirect the user
    echo "Error: clearance_id is not defined";
}

if($flag){
    echo 1;
}else{
    echo 0;
}
}



?>