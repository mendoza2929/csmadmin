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
            <h1>Equipment</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Equipment</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                            <div class="text-end my-4">

                        <button type="button" class="btn btn-warning btn-sm shadow-none mb-2" data-bs-toggle="modal"
                            data-bs-target="#add-equipment">
                            <i class="bi bi-file-plus"></i> Add
                        </button>
                        <input type="text" oninput="search_equipment(this.value)"
                            class="form-control shadow-none w-25 ms-auto" placeholder="Type to search..">
                        </div>


                        <div class="table-responsive-lg" style="height:450px; overflow-y:scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class=" text-white" style="background-color:#ED8B5A;">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Made</th>
                                    <th scope="col">Cost</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Date Added</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="equipment_data">



                            </tbody>
                        </table>
                        </div>
                                                    
            </div>
         </div>
      
  
      </main>





<!----equipment Modal-->

    <div class="modal fade" id="add-equipment" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_equipment_form" autocomplete="off" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title fw-bold"><i class="bi bi-plus-square"></i> Add Equipment</div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Equipment Name</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Brand</label>
                                <input type="text" name="brand" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Made In</label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='made' required>
                                                <option disabled selected value="">Select a Made...</option> <!-- placeholder option -->
                                                <?php
                                                $res = selectAll('made');
                                                while($opt = mysqli_fetch_assoc($res)){
                                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                                }
                                                ?>
                                            </select>
                            </div>
                            <div class="col-3 mb-3">
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
                                <label class="form-label fw-bold">Cost</label>
                                <input type="number" name="cost" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date_added" class="form-control shadow-none">
                            </div>
                        
        

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

         <!----edit Modal-->

    <div class="modal fade" id="edit-equipment" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_equipment" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title fw-bold"><i class='i bi-pencil-square'></i> Edit Equipment</div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Equipment Name</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Brand</label>
                                <input type="text" min="1" name="brand" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Made In</label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='made' required>
                                                <option disabled selected value="">Select a Made...</option> <!-- placeholder option -->
                                                <?php
                                                $res = selectAll('made');
                                                while($opt = mysqli_fetch_assoc($res)){
                                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                                }
                                                ?>
                                            </select>
                            </div>
                            <div class="col-3 mb-3">
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
                                <label class="form-label fw-bold">Cost</label>
                                <input type="number" name="cost" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date_added" class="form-control shadow-none">
                            </div>

                            <input type="hidden" name="equipment_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">Close</button>
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

let add_equipment_form = document.getElementById('add_equipment_form');



add_equipment_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_equipment();
});

function add_equipment() {
    let data = new FormData();
    data.append('add_equipment', '');
    data.append('name', add_equipment_form.elements['name'].value);
    data.append('brand', add_equipment_form.elements['brand'].value);
    data.append('made', add_equipment_form.elements['made'].value);
    data.append('unit', add_equipment_form.elements['unit'].value);
    data.append('quantity', add_equipment_form.elements['quantity'].value);
    data.append('cost', add_equipment_form.elements['cost'].value);
    data.append('date_added', add_equipment_form.elements['date_added'].value);




    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/equipment_ajax.php", true);

    xhr.onload = function () {
        var myModalEl = document.getElementById('add-equipment')
        var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
        modal.hide();

        if (this.responseText == 1) {
            Swal.fire(
                'Success!',
                'Equipment has been added',
                'success'
            )
            add_equipment_form.reset();

            get_equipment();

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }

    }
    xhr.send(data);
}



function get_equipment() {

let xhr = new XMLHttpRequest();
xhr.open("POST", "./ajax/equipment_ajax.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onload = function () {
    document.getElementById('equipment_data').innerHTML = this.responseText;
}
xhr.send('get_equipment');

}





let edit_equipment = document.getElementById('edit_equipment');

function equipment_details(id) {



    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/equipment_ajax.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        let data = JSON.parse(this.responseText);
        edit_equipment.elements['name'].value = data.equipmentdata.name;
        edit_equipment.elements['brand'].value = data.equipmentdata.brand;
        edit_equipment.elements['made'].value = data.equipmentdata.made;
        edit_equipment.elements['unit'].value = data.equipmentdata.unit;
        edit_equipment.elements['quantity'].value = data.equipmentdata.quantity;
        edit_equipment.elements['cost'].value = data.equipmentdata.cost;
        edit_equipment.elements['date_added'].value = data.equipmentdata.date_added;
        edit_equipment.elements['equipment_id'].value = data.equipmentdata.id;


  

    }

    xhr.send('edit_equipment=' + id);
}


edit_equipment.addEventListener('submit', function (e) {
            e.preventDefault();
            submit_edit_equipment();
        });


        function submit_edit_equipment() {
            let data = new FormData();
            data.append('submit_edit_equipment', '');
            data.append('equipment_id', edit_equipment.elements['equipment_id'].value);
            data.append('name', edit_equipment.elements['name'].value);
            data.append('brand', edit_equipment.elements['brand'].value);
            data.append('made', edit_equipment.elements['made'].value);
            data.append('unit', edit_equipment.elements['unit'].value);
            data.append('quantity', edit_equipment.elements['quantity'].value);
            data.append('cost', edit_equipment.elements['cost'].value);
            data.append('date_added', edit_equipment.elements['date_added'].value);
            // data.append('desc',add_equipment_form.elements['desc'].value);


            // let features = [];

            // edit_equipment.elements['features'].forEach(el => {
            //     if (el.checked) {
            //         features.push(el.value);
            //     }
            // });

            // data.append('features', JSON.stringify(features));


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax/equipment_ajax.php", true);

            xhr.onload = function () {
                var myModalEl = document.getElementById('edit-equipment')
                var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
                modal.hide();

                if (this.responseText == 1) {
                    Swal.fire(
                        'Success!',
                        'Equipment has been updated',
                        'success'
                    )
                    edit_equipment.reset();
                    get_equipment();

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                }

            }
            xhr.send(data);
        }










function toggleStatus(id, val) {

let xhr = new XMLHttpRequest();
xhr.open("POST", "./ajax/equipment_ajax.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onload = function () {
    if (this.responseText == 1) {
        // alert('success','Status Active');
        get_equipment();
    }
    else {
        alert('error', 'Status Not Active');
    }
}
xhr.send('toggleStatus=' + id + '&value=' + val);

}



function search_equipment(apparatusname) {
let xhr = new XMLHttpRequest();
xhr.open("POST", "./ajax/equipment_ajax.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onload = function () {
    document.getElementById('equipment_data').innerHTML = this.responseText;
}
xhr.send('search_equipment&name=' + apparatusname);
}





window.onload = function(){
    get_equipment();
}



</script>



    



    


       

    
    
             

   </body>
</html>

