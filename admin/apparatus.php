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
            <h1>Apparatus</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Apparatus</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                         <div class="text-end my-4">
                            
                            <button type="button" class="btn btn-warning btn-sm shadow-none mb-2" data-bs-toggle="modal" data-bs-target="#add-room">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                            <input type="text" oninput="search_apparatus(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search..">
                        </div>


                           <div class="table-responsive-lg" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border text-center">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">brand</th>
                                <th scope="col">size</th> 
                                <th scope="col" >Unit</th>
                                <th scope="col">Current Stock</th> 
                                <th scope="col">Date Added</th> 
                                <th scope="col">Status</th> 
                                <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody id="room_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>
               
                            
            </div>
         </div>
      
  
      </main>


      
        <!----Rooms Modal-->

        <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="room_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fw-bold"><i class="bi bi-plus-square"></i> Add Apparatus</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Brand</label>
                                <input type="text" name="brand" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3  mb-3">
                                <label class="form-label fw-bold">Size</label>
                                <input type="number" min="1" name="size" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Unit</label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='unit' required>
                                <option disabled selected value="">Select a Unit...</option> <!-- placeholder option -->
                                <?php
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Stock</label>
                                <input type="number" name="quantity" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date" class="form-control shadow-none">
                            </div>
                          
                          
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

            <!----edit Modal-->

            <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="edit_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fw-bold"><i class='i bi-pencil-square'></i> Edit Appratus</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Brand</label>
                                <input type="text" name="brand" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3  mb-3">
                                <label class="form-label fw-bold">Size</label>
                                <input type="number" min="1" name="size" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Unit</label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='unit' required>
                                <option disabled selected value="">Select a Unit...</option> <!-- placeholder option -->
                                <?php
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" name="quantity" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date" class="form-control shadow-none">
                            </div>  
                      
                            <input type="hidden" name="room_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success shadow-none">Submit</button>
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

let room_form = document.getElementById('room_form');

room_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_rooms();
});

function add_rooms(){
    let data= new FormData();
    data.append('add_rooms','');
        data.append('name',room_form.elements['name'].value);
        data.append('brand',room_form.elements['brand'].value);
        data.append('size',room_form.elements['size'].value);
        data.append('unit',room_form.elements['unit'].value);
        data.append('quantity',room_form.elements['quantity'].value);
        data.append('date',room_form.elements['date'].value);


        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/apparatus_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('add-room')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Apparatus Added',
                'success'
                )
                room_form.reset();
                get_rooms();
                
            }else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                })
            }

        }
        xhr.send(data);
}

function get_rooms(){
        
    let xhr = new XMLHttpRequest();
    xhr.open("POST","./ajax/apparatus_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('room_data').innerHTML = this.responseText;
        }
        xhr.send('get_rooms');

}


let edit_form = document.getElementById('edit_form');

edit_form.addEventListener('submit', function(e){
    e.preventDefault();
    submit_edit_rooms();
});


 function edit_details(id){


         let xhr = new XMLHttpRequest();
         xhr.open("POST","./ajax/apparatus_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
           let data = JSON.parse(this.responseText);
           edit_form.elements['name'].value = data.roomdata.name;
           edit_form.elements['brand'].value = data.roomdata.brand;
           edit_form.elements['size'].value = data.roomdata.size;
           edit_form.elements['unit'].value = data.roomdata.unit;
           edit_form.elements['quantity'].value = data.roomdata.quantity;
           edit_form.elements['date'].value = data.roomdata.date;
           edit_form.elements['room_id'].value = data.roomdata.id;

        //    edit_form.elements['features'].forEach(el => {
        //     if(data.features.includes(Number(el.value))){
        //        el.checked = true;
        //     }
        // });


        }
        xhr.send('edit_get_room='+id);
    }



  
function submit_edit_rooms(){
    let data= new FormData();
    data.append('edit_rooms','');
        data.append('room_id',edit_form.elements['room_id'].value);
        data.append('name',edit_form.elements['name'].value);
        data.append('brand',edit_form.elements['brand'].value);
        data.append('size',edit_form.elements['size'].value);
        data.append('unit',edit_form.elements['unit'].value);
        data.append('quantity',edit_form.elements['quantity'].value);
        data.append('date',edit_form.elements['date'].value);



        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/apparatus_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('edit-room')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                     Swal.fire(
                    'Updated!',
                    'Apparatus Updated',
                    'success'
                    )
                edit_form.reset();
                get_rooms();
                
            }else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                })
            }

        }
        xhr.send(data);
}






function toggleStatus(id,val){
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/apparatus_ajax.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
            xhr.onload = function(){
                if(this.responseText==1){
                    // alert('success','Status Active');
                    get_rooms();
                }
                else{
                    alert('error','Status Not Active');
                }
            }
            xhr.send('toggleStatus='+id+'&value='+val);
    
    }


    

    
    function search_apparatus(apparatusname){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/apparatus_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('room_data').innerHTML = this.responseText;
        }
        xhr.send('search_apparatus&name='+apparatusname);
    }



    window.onload = function(){
        get_rooms();
    }
    
    



</script>



    



    


       

    
    
             

   </body>
</html>

