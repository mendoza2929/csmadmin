<?php 


require('.././db_config.php');
require('.././alert.php');
adminLogin();


if(isset($_POST['get_users'])){  
    $res = selectAll('user_cred');
    $i=1;

    

    $data= "";

    while($row = mysqli_fetch_array($res)){
        
        $del_btn = "
        <button type='button' onclick='remove_user($row[id])' class='btn btn-danger btn-sm shadow-none'>
        <i class='i bi-trash'></i>
        </button>
        ";


     

     



        $date = date("d-m-y",strtotime($row['datentime']));

        $data.= "
           <tr>
            <td>$i</td>
            <td>$row[name] $row[lname] $row[suffix]</td>
            <td>$row[student_id]</td>
            <td>$row[email]</td>
            <td>$row[course]</td>
            <td>$row[year]</td>
            <td>$row[phonenum]</td>
          
      
            <td>$date</td>
         
           </tr>
        ";
        $i++;
}
echo $data;
}



if(isset($_POST['toggleStatus'])){
    $frm_data = filteration($_POST);

    $q= "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'],$frm_data['toggleStatus']];

    if(update($q,$v,'ii')){
        echo 1;
    }else{
        echo 0; 
    }

}


if(isset($_POST['remove_user'])){
    $frm_data = filteration($_POST);


  $res = delete("DELETE FROM `user_cred` WHERE `id`=? AND  `is_verified`=?",[$frm_data['user_id'],0],'ii');
 
  if($res){
    echo 1;
  }else{
    echo 0;
  }

}


if (isset($_POST['search_user'])) {
  $frm_data = filteration($_POST);
  $query = "SELECT * FROM `user_cred` WHERE CONCAT(`name`, ' ', `lname`, ' ', `suffix`) LIKE ?";

  $res = select($query, ["%$frm_data[name]%"], 's');
  $i = 1;

  $data = "";

  while ($row = mysqli_fetch_array($res)) {

      $del_btn = "
      <button type='button' onclick='remove_user($row[id])' class='btn btn-danger btn-sm shadow-none'>
      <i class='i bi-trash'></i>
      </button>
      ";

      $date = date("d-m-y", strtotime($row['datentime']));

      $data .= "
      <tr>
      <td>$i</td>
      <td>$row[name] $row[lname] $row[suffix]</td>
      <td>$row[student_id]</td>
      <td>$row[email]</td>
      <td>$row[course]</td>
      <td>$row[year]</td>
      <td>$row[phonenum]</td>
      <td>$date</td>
      </tr>
      ";
      $i++;
  }
  echo $data;
}




?>