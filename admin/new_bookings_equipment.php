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
            <h1>New Requested Equipment</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">New Borrowing</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="text-end my-4">
                           <input type="text" oninput="get_bookings_equipment(this.value)" class="form-control shadow-none w-25 ms-auto " placeholder="Type to search..">
                        </div>


                           <div class="table-responsive">
                           <table class="table table-hover border " style="min-width:500px;">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">User Details</th>
                                <th scope="col">Group Mates</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Time Details</th> 
                                <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody id="table-data-equipment">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

                       
            </div>
         </div>
  
      </main>

      
     <!----assign Room Number Modal-->

     <div class="modal fade" id="assign-equipment" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="assign_equipment_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-clipboard-check-fill"></i>Aproved Return</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Approved Return</label>
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

               <div class="modal fade" id="quantity-equipment" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="quantity_equipment_form" novalidate>
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
                            <label class="form-label fw-bold">Responsible</label>
        <input type="email" class="form-control mb-2 shadow-none" list="personnel_list_code" name="res_breakage"  placeholder="Type to search group mate" required multiple pattern=".@">
        <datalist id="personnel_list_code">
    <?php
    $res = $con->query ('SELECT * FROM `user_cred`');
    while($opt = mysqli_fetch_assoc($res)){
    ?>
      <option value="<?php echo $opt['name'].' '. $opt['lname'].' '. $opt['suffix'] ?>"></option>
    <?php
    }
    ?>
  </datalist>
      </label>
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




function get_bookings_equipment(search=''){
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_equipment.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                document.getElementById('table-data-equipment').innerHTML = this.responseText;
            }
            xhr.send('get_bookings_equipment&search='+search);
    
    }
    
    
    

     
    let assign_equipment_form = document.getElementById('assign_equipment_form');
    
    function assign_equipment(id){
        assign_equipment_form.elements['booking_id'].value=id;
    }
    
    assign_equipment_form.addEventListener('submit',function(e){
        e.preventDefault();
    
        let data = new FormData();
    
        // data.append('equipment_no',assign_equipment_form.elements['equipment_no'].value);
        data.append('booking_id',assign_equipment_form.elements['booking_id'].value);
        data.append('assign_equipment','');
    
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_equipment.php",true);
        xhr.onload = function(){
            var myModal = document.getElementById('assign-equipment');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
    
        
    
            if(this.responseText==1){
                Swal.fire(
                    'Good job!',
                    'Approved return!',
                    'success'
                    )
                    assign_equipment_form.reset();
                    get_bookings_equipment();
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


     
    
    let quantity_equipment_form = document.getElementById('quantity_equipment_form');
    
    function quantity_equipment(id){
        quantity_equipment_form.elements['booking_id'].value=id;
    }
    
    quantity_equipment_form.addEventListener('submit',function(e){
        e.preventDefault();
    
        let data = new FormData();
        data.append('quantity_no',quantity_equipment_form.elements['quantity_no'].value);
        // data.append('res_group',quantity_equipment_form.elements['res_group'].value);
        data.append('res_breakage',quantity_equipment_form.elements['res_breakage'].value);
        data.append('booking_id',quantity_equipment_form.elements['booking_id'].value);
        data.append('quantity_equipment','');
    
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_equipment.php",true);
    
        xhr.onload = function(){
            var myModal = document.getElementById('quantity-equipment');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
    
    
    
            if(this.responseText==1){
                Swal.fire(
                    'Good job!',
                    'Breakage Item Update!',
                    'success'
                    )
                    quantity_equipment_form.reset();
                    get_bookings_equipment();
            }else if(this.responseText == 'same_name'){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The Name entered in the field does not match any of the group mate.',
                    })
            }
            else if(this.responseText == 'breakage_qty'){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The breakage quantity does not match the quantity in the equipment details.',
                    })
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
            get_bookings_equipment();
        }
    
    
    



</script>



    



    


       

    
    
             

   </body>
</html>

