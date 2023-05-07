<?php 
require("alert.php");
require("db_config.php");

// Start by defining the headers to force the browser to download the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="equipment_records_list.xls"');

// Then start the HTML table and add the headers
echo "<table>
        <thead>
            <tr>
              
                <th>User Details</th>
                <th>Item Description</th>
                <th>Time Details</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>";


        $res = mysqli_query($con, "SELECT eo.*, ed.* FROM `equipment_order_final` eo INNER JOIN `equipment_details_final` ed ON eo.booking_id = ed.booking_id WHERE  ( (eo.booking_status ='approved'  AND eo.arrival=1) OR (eo.booking_status='breakage' AND eo.arrival=0) OR (eo.booking_status='payment failed'))  ORDER BY eo.booking_id DESC ");

        if (!$res) {
            // handle query error
            echo "Error executing query: " . mysqli_error($con);
            exit;
        }

while($data = mysqli_fetch_array($res)){

    $date = date("F j Y",strtotime($data['datentime']));
      
    $checkin= date("F j Y g:i a",strtotime($data['check_in']));
                
    $checkout= date("F j Y g:i a",strtotime($data['check_out']));



      if($data['booking_status']=='approved'){
        $status_bg = 'bg-success';
      }else if($data['booking_status']=='breakage'){
        $status_bg = 'bg-danger';
      }else{
        $status_bg = 'bg-warning text-dark';
      }




      echo "
      <tr>
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
  </tr>";
      


    
  }

// Close the table and output the HTML code
echo "</tbody></table>";
?>