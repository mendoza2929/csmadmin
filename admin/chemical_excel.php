<?php 
require("alert.php");
require("db_config.php");

// Start by defining the headers to force the browser to download the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="chemical_records_list.xls"');

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


         $res = selectAll('chemical ORDER BY name ASC, date_added ASC');

        if (!$res) {
            // handle query error
            echo "Error executing query: " . mysqli_error($con);
            exit;
        }

 while($row = mysqli_fetch_assoc($res)){
            $date_added = date('F j Y',strtotime($row['date_added']));
            $date_exp = date('F j Y',strtotime($row['date_exp']));
    
            // Get the current date
            $current_date = strtotime(date('Y-m-d'));
    
            // Get the expiration date
            $expiration_date = strtotime($row['date_exp']);
    
            // Calculate the difference between the current date and the expiration date in days
            $days_diff = ($expiration_date - $current_date) / 86400; //86400 seconds in a day
    
            // Check if the expiration date has already passed
            if ($expiration_date < $current_date) {
                $expiration_notice = "<span class='badge rounded-pill bg-danger'>Expired!</span>";
            }
            // Check if the expiration date is within one month
            else if ($days_diff < 60) {
                $expiration_notice = "<span class='badge rounded-pill bg-warning'>Expiring soon!</span>";
            }
            // If the expiration date is not close, set the notice to an empty string
            else {
                $expiration_notice = "";
            }
    
            // Check if the chemical is out of stock
            if ($row['quantity'] == 0) {
                $quantity_notice = "<span class='badge rounded-pill bg-danger'>Out of Stock</span>";
                $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
            }
            else {
                $quantity_notice = $row['quantity'];
                if($row['status']==1){
                    $status = "<button  onclick='toggleStatus($row[id],0)'class='btn btn-success btn-sm shadow-none'>Active</button>";
                } else {
                    $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Not active</button>";
                }
            }



      echo "
      <tr class='align-middle'>
                
    
                <td> <span class='badge bg-info'>
                Chemical ID: $row[code]
                </span> <br> $row[name] <br> $expiration_notice</td>
                <td><span class='badge rounded-pill bg-light text-dark'>$row[unit]</span></td>
                <td> $quantity_notice </td>
                <td>$row[concentration] </td>
                <td>$row[area] </td>
                <td>$date_added</td>
                <td>$date_exp</td>
                <td>$row[shelf] </td>
                <td>$status</td>
                <td>
                    <button type='button' onclick='chemical_details($row[id])' class='btn btn-warning btn-sm shadow-none me-3' data-bs-toggle='modal' data-bs-target='#edit-chemical'>
                    <i class='i bi-pencil-square'></i>
                    </button>
                </td>
            </tr>";
      


    
  }

// Close the table and output the HTML code
echo "</tbody></table>";
?>