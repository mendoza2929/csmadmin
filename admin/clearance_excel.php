<?php 
require("alert.php");
require("db_config.php");

// Start by defining the headers to force the browser to download the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="clearance_records_list.xls"');

// Then start the HTML table and add the headers
echo "<table>
        <thead>
            <tr>
              
            <th>Date</th>
            <th>CAIS</th>
            <th>CArch</th> 
            <th>CCIE</th>
            <th >CoE</th>
            <th>CCS</th> 
            <th>CFES</th> 
            <th>CHE</th> 
            <th>CLA</th> 
            <th>CLaw</th> 
            <th>CPERS</th> 
            <th>CSM</th> 
            <th>CSWCD</th> 
            <th>CTE</th> 
            <th>ESU</th> 
            <th>Graduate</th> 
            
            </tr>
        </thead>
        <tbody>";


        $res = selectAll('clearance');

        if (!$res) {
            // handle query error
            echo "Error executing query: " . mysqli_error($con);
            exit;
        }

while($data = mysqli_fetch_array($res)){

  $date = date('F j Y',strtotime($data['date']));






      echo "
      <tr>
      <td>$date</td>
      <td>$data[cais]</td>
      <td>$data[carch]</td>
      <td>$data[ccie]</td>
      <td>$data[coe]</td>
      <td>$data[ccs]</td>
      <td>$data[cfes]</td>
      <td>$data[che]</td>
      <td>$data[cla]</td>
      <td>$data[claw]</td>
      <td>$data[cpers]</td>
      <td>$data[csm]</td>
      <td>$data[cswcd]</td>
      <td>$data[cte]</td>
      <td>$data[esu]</td>
      <td>$data[graduate]</td>

      <td>
  </tr>";
      


    
  }

// Close the table and output the HTML code
echo "</tbody></table>";
?>