<?php 



require('.././db_config.php');
require('.././alert.php');
adminLogin();



if(isset($_POST['add_facilities'])){
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $values=[$frm_data['name']];
    $res=insert($q,$values,'s');
    echo $res;

}

if(isset($_POST['get_facilities'])){
    $res = selectAll('features');
    $i=1;

    while($row = mysqli_fetch_assoc($res)){
        echo <<<data
        <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>
         <button type="button" onclick="rem_facilities($row[id])" class="btn btn-danger btn-sm shadow-none">
         <i class="bi bi-trash"></i>Delete
        </button>
        </td>
        </tr>
        data;
        $i++;
    }
}

if(isset($_POST['rem_facilities'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_facilities']];

    $check_q = select('SELECT * FROM `room_facilities` WHERE `facilities_id`=?',[$frm_data['rem_facilities']],'i');

    if(mysqli_num_rows($check_q)==0){

        $q = "DELETE FROM `features` WHERE `id`=?";
        $res = delete($q, $values,'i');
        echo $res;
    }else{
        echo 'room_added';
    }

}


if(isset($_POST['add_chemical'])){
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `chemical_unit`(`name`) VALUES (?)";
    $values=[$frm_data['name']];
    $res=insert($q,$values,'s');
    echo $res;

}

if(isset($_POST['get_chemical'])){
    $res = selectAll('chemical_unit');
    $i=1;

    while($row = mysqli_fetch_assoc($res)){
        echo <<<data
        <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>
         <button type="button" onclick="rem_chemical($row[id])" class="btn btn-danger btn-sm shadow-none">
         <i class="bi bi-trash"></i>Delete
        </button>
        </td>
        </tr>
        data;
        $i++;
    }
}



if(isset($_POST['rem_chemical'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_chemical']];

 
    $q = "DELETE FROM `chemical_unit` WHERE `id`=?";
    $res = delete($q, $values,'i');
    echo $res;
}









if(isset($_POST['add_made'])){
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `made`(`name`) VALUES (?)";
    $values=[$frm_data['name']];
    $res=insert($q,$values,'s');
    echo $res;

}

if(isset($_POST['get_made'])){
    $res = selectAll('made');
    $i=1;

    while($row = mysqli_fetch_assoc($res)){
        echo <<<data
        <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>
         <button type="button" onclick="rem_made($row[id])" class="btn btn-danger btn-sm shadow-none">
         <i class="bi bi-trash"></i>Delete
        </button>
        </td>
        </tr>
        data;
        $i++;
    }
}

if(isset($_POST['rem_made'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_made']];

 
    $q = "DELETE FROM `made` WHERE `id`=?";
    $res = delete($q, $values,'i');
    echo $res;
}




if(isset($_POST['add_features'])){
    $frm_data = filteration($_POST);

        $q = "INSERT INTO `facilities` (`name`,`description`) VALUES (?,?)";
        $values = [$frm_data['name'],$frm_data['desc']];
        $res = insert($q,$values,'ss');
        echo $res;
    

}

if(isset($_POST['get_features'])){
    $res = selectAll('facilities');
    $i=1;

    while($row = mysqli_fetch_assoc($res)){
        echo <<<data
        <tr class="align-middle">
        <td>$i</td>
        <td>$row[name]</td>
        <td>$row[description]</td>
        <td>
         <button type="button" onclick="rem_features($row[id])" class="btn btn-danger btn-sm shadow-none">
         <i class="bi bi-trash"></i>Delete
        </button>
        </td>
        </tr>
        data;
        $i++;
    }
}

if(isset($_POST['rem_features'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_features']];

 
    $q = "DELETE FROM `facilities` WHERE `id`=?";
    $res = delete($q, $values,'i');
    echo $res;
}



if(isset($_POST['add_course'])){
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `course`(`name`) VALUES (?)";
    $values=[$frm_data['name']];
    $res=insert($q,$values,'s');
    echo $res;

}

if(isset($_POST['get_course'])){
    $res = selectAll('course');
    $i=1;

    while($row = mysqli_fetch_assoc($res)){
        echo <<<data
        <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>
         <button type="button" onclick="rem_course($row[id])" class="btn btn-danger btn-sm shadow-none">
         <i class="bi bi-trash"></i>Delete
        </button>
        </td>
        </tr>
        data;
        $i++;
    }
}

if(isset($_POST['rem_course'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_course']];

 
    $q = "DELETE FROM `course` WHERE `id`=?";
    $res = delete($q, $values,'i');
    echo $res;
}




?>