<?php 


require('.././db_config.php');
require('.././alert.php');
adminLogin();


if(isset($_POST['get_bookings_equipment'])){  

    $frm_data = filteration($_POST);

    $limit = 3;
    $page = $frm_data['page'];
    $start = ($page-1) * $limit;


    
  
    $query = "SELECT eo.*, ed.*  FROM `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id WHERE  ( (eo.booking_status ='approved'  AND eo.arrival=1) OR (eo.booking_status='breakage' AND eo.arrival=0) OR (eo.booking_status='payment failed')) AND   (eo.order_id LIKE ? OR ed.course LIKE ? OR ed.username LIKE ? )  ORDER BY eo.booking_id DESC ";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    $limit_query = $query ." LIMIT $start, $limit";
    $limit_res =  select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');



    $table_data = "";

    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
      $output = json_encode(['table_data'=>"<b>No data Found!</b>","pagination"=>'']);
      echo $output;
   
      exit;
    }


    $i=$start+1;
    $table_data = "";

    while($data = mysqli_fetch_array($limit_res)){

      $date = date("d-m-Y",strtotime($data['datentime']));
        
      $checkin= date("d-m-Y g:i a",strtotime($data['check_in']));
                  
      $checkout= date("d-m-Y g:i a",strtotime($data['check_out']));



        if($data['booking_status']=='approved'){
          $status_bg = 'bg-success';
        }else if($data['booking_status']=='breakage'){
          $status_bg = 'bg-danger';
        }else{
          $status_bg = 'bg-warning text-dark';
        }



        $table_data .="
        
        <tr>
            <td>$i</td>
            <td>
            <span class='badge bg-primary'>
                Student ID: $data[email]
            </span>
            <br>
            <b>Name: </b> $data[username]
            <br>
            <b>Course: </b> $data[course]
            <br>
            <b>Year: </b> $data[year] year
          
            <br>
            <b>Teacher Name: </b> $data[teacher]
            <br>
            <b>Group No. : </b>  $data[group_no] 
            <br>
            <b>Room No. : </b>  $data[apr_no] 
            </td>
            <td>
            <b>item: </b> $data[equipment_name]
            <br>
            <b>Quantity: </b> $data[quantity]
            <br>
            <b>Remarks: </b> $data[quantity_no] pcs
            
            <br>
            <b>Volume : </b>  $data[volume] Needed
            <br>
          
            </td>
            <td>
            <b>Start Date: </b> $checkin
            <br>
            <b>End Date: </b> $checkout
            <br>
            <b>Date: </b> $date
            </td>
            <td>
            <span class='badge $status_bg' >$data[booking_status]</span>
            </td>
            <td>
           
            </td>
        </tr>
        
        ";

        $i++;
    }


    $pagination = "";

    if($total_rows>$limit){
        $total_pages = ceil($total_rows/$limit);

        if($page!=1){
          $pagination .="<li class='page-item '><button onclick='change_page(1)' class='page-link shadow-none'>First</button></li>";
        }

        $disabled = ($page==1) ? "disabled" : "";
        $prev = $page-1;
        $pagination .="<li class='page-item $disabled'><button onclick='change_page($prev)' class='page-link shadow-none'>Prev</button></li>";


        $disabled = ($page==$total_pages) ? "disabled" : "";
        $next = $page+1;
        $pagination .="<li class='page-item $disabled '><button onclick='change_page($next)' class='page-link shadow-none'>Next</button></li>";

        if($page!=$total_pages){
          $pagination .="<li class='page-item '><button onclick='change_page($total_pages)' class='page-link shadow-none'>Last</button></li>";
        }

    }

    $output = json_encode(["table_data"=>$table_data,"pagination"=>$pagination]);

    echo $output;
    

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
    
    $query = "UPDATE `equipment_order` eo INNER JOIN `equipment_details` ed ON eo.booking_id = ed.booking_id SET eo.booking_status = ?, eo.refund=?, ed.quantity_no = ? WHERE eo.booking_id = ? ";
    
    $values = ['breakage',0,$frm_data['quantity_no'],$frm_data['booking_id']];
    
    $res = update($query,$values,'siii');
    
    echo ($res==2) ? 1 : 0;
    
    
    
    }
    




?>