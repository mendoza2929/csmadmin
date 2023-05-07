<?php 
require("alert.php");
require("db_config.php");
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>CSM - Inventory and Borrowing Management System</title>
      <meta name="robots" content="noindex, nofollow">
      <meta content="" name="description">
      <meta content="" name="keywords">
      <?php 
      
        require('./includes/nav_link.php');
      
      ?>


      
   </head>
   <body>
   
          
   <?php 
      
      require('./includes/header.php');
         
      require('./includes/aside.php');
    
   ?>

      <main id="main" class="main">
         <div class="pagetitle">
            <h1>All Chemical Records</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Chemical Records</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">


                     <form action="chemical_excel.php" method="post">
                        <button type="submit" name="export_excel" class="btn btn-success btn-sm shadow-none mt-2 mb-2 text-start me-2">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Export to excel
                            </button>
                        </form>


                        <div class="text-end mb-4">
                           <input type="text"  id="search_input" oninput="get_booking_chemical(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search..">
                        </div>


                           <div class="table-responsive">
                           <table class="table table-hover border " style="min-width:300px;">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">User Details</th>
                                <th scope="col">Item Discription</th>
                                <th scope="col">Time Details</th> 
                                <th scope="col">Status</th> 
                               
                                </tr>
                            </thead>
                            <tbody id="table-data-chemical">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>
                            <nav >
                            <ul class="pagination mt-3" id="table-pagination">
                               
                            </ul>
                            </nav>
                       
             </div>
         </div>
  
      </main>

      
 

      
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>  

        <script src="assets/js/apexcharts.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/chart.min.js"></script>
        <script src="assets/js/echarts.min.js"></script>
        <script src="assets/js/quill.min.js"></script>
        <script src="assets/js/simple-datatables.js"></script>
        <script src="assets/js/tinymce.min.js"></script>
        <script src="assets/js/validate.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       


      




   

        
   <script>




function get_booking_chemical(search='',page=1){
        
        let xhr = new XMLHttpRequest();
            xhr.open("POST","./ajax/bookings_records_chemical.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                let data = JSON.parse(this.responseText);
                document.getElementById('table-data-chemical').innerHTML = data.table_data;
                document.getElementById('table-pagination').innerHTML = data.pagination;
            }
            xhr.send('get_booking_chemical&search='+search+'&page='+page);
    
    }
    
    
    
    function change_page(page){
        get_booking_chemical(document.getElementById('search_input').value,page);
    }
    
    
    function download(id){
        window.location.href = 'generate_pdf.php?gen_pdf&id='+id;
    }
    
    
    
    

    
    
    
        function search_user(username){
            let xhr = new XMLHttpRequest();
            xhr.open("POST","./ajax/users_ajax.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                document.getElementById('user_data').innerHTML = this.responseText;
            }
            xhr.send('search_user&name='+username);
        }
    
    
 
    
    
    
        window.onload = function(){
            get_booking_chemical();
        }
    
    
        
    
    
    


</script>



    



    


       

    
    
             

   </body>
</html>

