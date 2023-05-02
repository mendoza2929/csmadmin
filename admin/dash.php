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
      <title>Dashboard - Inventory and Borrowing Managment Systems</title>
      <meta name="robots" content="noindex, nofollow">
      <meta content="" name="description">
      <meta content="" name="keywords">
     
      <?php 
      
        require('./includes/nav_link.php');
      
      ?>

   </head>
   <body>


   <?php 


$apparatus_breakage = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(booking_id) AS `count` FROM `booking_order` WHERE `booking_status` = 'breakage'"));

$equipment_breakage = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(booking_id) AS `count` FROM `equipment_order_final` WHERE `booking_status` = 'breakage'"));

   // // $training = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `personnel_details` WHERE course_id='35' AND training_status='1';"));

   // // $training1 = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `personnel_details` WHERE course_id='36' AND training_status='1';"));
   
   // ?>

   
   <?php 
      
      require('./includes/header.php');
         
      require('./includes/aside.php');
    
   ?>

      
   
  
   
     

     



      <main id="main" class="main">
         <div class="pagetitle mb-4">
            <h1>Dashboard</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
               </ol>

               <h1 class="fw-bold">Welcome to Inventory and Borrowing Management System</h1>

               <div class="d-flex align-items-center justify-content-between mb-3">
            <h5></h5>
            <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
              <option value="1">1st Sem</option>
              <option value="2">2nd Sem</option>
              <option value="4">All Time</option>
            </select>
          </div>
         </div>

         <section class="section dashboard">
            <div class="row">
               <div class="col-lg-8">
                  <div class="row">
                  <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                           <div class="card-body">
                              <h5 class="card-title">Appratus Records  <span>| Records</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                                 <div class="ps-3">
                                 <h6 class="card-title"><?php echo $apparatus_breakage['count']?> <span> Breakage</span> </h6>
                                 <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1 fw-bold">Records </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                           <div class="card-body">
                              <h5 class="card-title">Equipment Records  <span>| Records</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                                 <div class="ps-3">
                                 <h6 class="card-title"><?php echo $equipment_breakage['count']?> <span> Breakage</span> </h6>
                                 <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1 fw-bold">Records </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>


         </section>

         
  
      </main>


      <?php 
      
      require('./includes/footer.php');
    
    ?>
   
     
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


        
<script>




function booking_analytics(period=1){
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/dashboard_ajax.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                let data = JSON.parse(this.responseText);
   
    
                document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
               
            }
            xhr.send('booking_analytics&period='+period);
    
    }
    




    window.onload = function(){
      booking_analytics();
      // user_analytics();
    }


    




</script>




      
             
   </body>
</html>