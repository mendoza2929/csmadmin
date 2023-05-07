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
            <h1>New Borrowing Apparatus</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">New Borrowing</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="text-end my-4">
                           <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto " placeholder="Type to search..">
                        </div>


                           <div class="table-responsive">
                           <table class="table table-hover border " style="min-width:200px;">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">User Details</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Time Details</th> 
                                <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody id="table-data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

                       
            </div>
         </div>
  
      </main>

      
     <!----assign Room Number Modal-->

     <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="assign_room_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-clipboard-check-fill"></i>Aproved Return</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Approved Return</label>
                                <input type="hidden" name="room_no">
                            </div>
                         <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base ">
                            Note: Are you certain this object is undamaged?
                        </span>
                        <input type="hidden" name="booking_id">
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success shadow-none">Assign</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
               <!----assign Room Number Modal-->

               <div class="modal fade" id="quantity-room" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="quantity_room_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-clipboard-check-fill"></i> Breakage Item</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Breakage Quantity</label>
                                <input type="text" name="quantity_no" class="form-control shadow-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Group Mate</label>
                        
                                <textarea class="form-control shadow-none" name="res_group"   rows="3" style="resize: none;"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Responsible For Breakage</label>
                        
                                <textarea class="form-control shadow-none" name="res_breakage"   rows="3" style="resize: none;"></textarea>
                            </div>
                           
                         <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base ">
                            Note: Check first the Item Quantity
                        </span>
                        <input type="hidden" name="booking_id">
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success shadow-none">Approved</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


      

   



    


      
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




function get_bookings(search=''){
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_reservation.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                document.getElementById('table-data').innerHTML = this.responseText;
            }
            xhr.send('get_bookings&search='+search);
    
    }
    
    
    
    
    
    let quantity_room_form = document.getElementById('quantity_room_form');
    
    function quantity_room(id){
        quantity_room_form.elements['booking_id'].value=id;
    }
    
    quantity_room_form.addEventListener('submit',function(e){
        e.preventDefault();
    
        let data = new FormData();
        data.append('quantity_no',quantity_room_form.elements['quantity_no'].value);
        data.append('res_group',quantity_room_form.elements['res_group'].value);
        data.append('res_breakage',quantity_room_form.elements['res_breakage'].value);
        data.append('booking_id',quantity_room_form.elements['booking_id'].value);
        data.append('quantity_room','');
    
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_reservation.php",true);
    
        xhr.onload = function(){
            var myModal = document.getElementById('quantity-room');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
    
    
    
            if(this.responseText==1){
                Swal.fire(
                    'Good job!',
                    'Breakage Item Update!',
                    'success'
                    )
                    quantity_room_form.reset();
                    get_bookings();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    })
            }
        }
    
        xhr.send(data);
        
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    let assign_room_form = document.getElementById('assign_room_form');
    
    function assign_room(id){
        assign_room_form.elements['booking_id'].value=id;
    }
    
    assign_room_form.addEventListener('submit',function(e){
        e.preventDefault();
    
        let data = new FormData();
    
        data.append('room_no',assign_room_form.elements['room_no'].value);
        data.append('booking_id',assign_room_form.elements['booking_id'].value);
        data.append('assign_room','');
    
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_reservation.php",true);
    
        xhr.onload = function(){
            var myModal = document.getElementById('assign-room');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
    
        
    
            if(this.responseText==1){
                Swal.fire(
                    'Good job!',
                    'Approved return!',
                    'success'
                    )
                    assign_room_form.reset();
                    get_bookings();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    })
            }
        }
    
        xhr.send(data);
        
    });
    
    

    
    
        window.onload = function(){
            get_bookings();
        }
    
    
    



</script>



    



    


       

    
    
             

   </body>
</html>

