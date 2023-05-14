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
            <h1>Chemical</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Chemical</li>
               </ol>

               <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="notifications-dropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Notifications<i class="bi bi-bell"></i>
                        <?php
                        $res = selectAll('chemical');
                        $num_expiring = 0;
                        $num_expired = 0;
                        $num_critical = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                            $current_date = strtotime(date('Y-m-d'));
                            $expiration_date = strtotime($row['date_exp']);
                            $days_diff = ($expiration_date - $current_date) / 86400; //86400 seconds in a day
                            if ($expiration_date < $current_date) {
                                $num_expired++;
                            } else if ($days_diff < 60) {
                                $num_expiring++;
                            }
                            if ($row['quantity'] <= 100) {
                                $num_critical++;
                            }
                        }
                        ?>
                        <?php if ($num_expiring > 0 || $num_expired > 0 || $num_critical > 0) { ?>
                            <span class="badge rounded-pill" style="background-color: red;">
                                <?php echo $num_expiring + $num_expired + $num_critical; ?>
                            </span>
                        <?php } ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="notifications-dropdown">
                        <?php if ($num_expiring > 0) { ?>
                            <a class="dropdown-item" href="#">Expiring soon:
                                <?php echo $num_expiring; ?>
                            </a>
                        <?php } ?>
                        <?php if ($num_expired > 0) { ?>
                            <a class="dropdown-item" href="#">Expired:
                                <?php echo $num_expired; ?>
                            </a>
                        <?php } ?>
                        <?php if ($num_critical > 0) { ?>
                            <a class="dropdown-item" href="#">Critical:
                                <?php echo $num_critical; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

          <form action="chemical_excel.php" method="post">
                        <button type="submit" name="export_excel" class="btn btn-success btn-sm shadow-none mt-2 text-start me-2">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Export to excel
                            </button>
                        </form>


                         <div class="text-end my-4">
                            
                            <button type="button" class="btn btn-warning btn-sm shadow-none mb-2" data-bs-toggle="modal" data-bs-target="#add-chemical">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                            <input type="text" oninput="search_chemical(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search..">
                        </div>


                           <div class="table-responsive-lg" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border text-center">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Unit</th> 
                                <th scope="col">Current Unit</th>
                                <th scope="col">Concentration</th>
                                <th scope="col">Material</th>
                                <th scope="col" >Date Added</th>
                                <th scope="col" >Expiration Date</th>
                                <th scope="col" style="background-color: #ED8B5A;">
                                    <select id="shelf-filter">
                                        <option value="all">Overall</option>
                                        <option value="Shelf 1">Shelf 1</option>
                                        <option value="Shelf 2">Shelf 2</option>
                                        <option value="Shelf 3">Shelf 3</option>
                                    </select>
                                </th>
                                <th scope="col">Status</th> 
                                <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody id="chemical_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

               
                            
            </div>
         </div>
      
  
      </main>

      <style>
        #shelf-filter {
            border-color: white;
            border-width: 2px;
            color: white;
            background-color: #ED8B5A;
            font-weight: bold;
        }

        .dropdown-toggle .badge {
            background-color: red;
        }

        #notifications-dropdown {
            background-color: #ED8B5A;
            border-color: white;
        }

        option {
            font-family: "Open Sans", sans-serif;

        }
    </style>
    <script>
        function filterByShelf() {
            var filter = document.getElementById("shelf-filter").value;
            var rows = document.getElementById("chemical_data").getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var shelf = cells[8].innerText;
                if (filter === "all" || shelf === filter) {
                    rows[i].style.display = "table-row";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        document.getElementById("shelf-filter").addEventListener("change", filterByShelf);
    </script>


   <!----chemical Modal-->

      <div class="modal fade" id="add-chemical" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="add_chemical_form" autocomplete="off" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fw-bold"><i class="bi bi-plus-square"></i> Add Chemical</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Name of Reagent</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-bold">Current Unit</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Concentration</label>
                                <select name="concentration" class="form-select shadow-none">
                                    <option value="None">None</option>
                                    <?php
                                    for ($i = 0; $i <= 100; $i++) {
                                        echo "<option value='$i%'>$i%</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label fw-bold">Unit </label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='unit' required>
                                <option disabled selected value="">Select a Unit...</option> <!-- placeholder option -->
                                <?php
                                $res = selectAll('chemical_unit');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Material</label>
                                <select name="area" class="form-select shadow-none">
                                    <option value="0rganic">Organic</option>
                                    <option value="Inorganic">Inorganic</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date_added" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Expiration Date</label>
                                <input type="date" name="date_expiration" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Location</label>
                                <select name="shelf" class="form-control shadow-none">
                                    <option value="Shelf 1">Shelf 1</option>
                                    <option value="Shelf 2">Shelf 2</option>
                                    <option value="Shelf 3">Shelf 3</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Code ID Chemical</label>
                                <input type="text" name="code" class="form-control shadow-none">
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

            <div class="modal fade" id="edit-chemical" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="edit_chemical" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fw-bold"><i class='i bi-pencil-square'></i> Edit Chemical</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="row">
                            <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Name of Reagent</label>
                                <input type="text" name="name" class="form-control shadow-none">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-bold">Current Unit</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Concentration</label>
                                <select name="concentration" class="form-select shadow-none">
                                    <option value="None">None</option>
                                    <?php
                                    for ($i = 0; $i <= 100; $i++) {
                                        echo "<option value='$i%'>$i%</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label fw-bold">Unit </label>
                                <select class='form-select shadow-none' aria-label='Default select example' name='unit' required>
                                <option disabled selected value="">Select a Unit...</option> <!-- placeholder option -->
                                <?php
                                $res = selectAll('chemical_unit');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Material</label>
                                <select name="area" class="form-select shadow-none">
                                    <option value="0rganic">Organic</option>
                                    <option value="Inorganic">Inorganic</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Date Added</label>
                                <input type="date" name="date_added" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Expiration Date</label>
                                <input type="date" name="date_expiration" class="form-control shadow-none">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Location</label>
                                <select name="shelf" class="form-control shadow-none">
                                    <option value="Shelf 1">Shelf 1</option>
                                    <option value="Shelf 2">Shelf 2</option>
                                    <option value="Shelf 3">Shelf 3</option>
                                </select>
                            </div>
                    
                           
                            <input type="hidden" name="chemical_id">
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
let add_chemical_form = document.getElementById('add_chemical_form');



add_chemical_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_chemical();
});

function add_chemical(){
    let data= new FormData();
        data.append('add_chemical','');
        data.append('name',add_chemical_form.elements['name'].value);
        data.append('area',add_chemical_form.elements['area'].value);
        data.append('shelf', add_chemical_form.elements['shelf'].value);
         data.append('quantity', add_chemical_form.elements['quantity'].value);
         data.append('concentration', add_chemical_form.elements['concentration'].value);
        data.append('unit',add_chemical_form.elements['unit'].value);
        data.append('date_added',add_chemical_form.elements['date_added'].value);
        data.append('date_expiration',add_chemical_form.elements['date_expiration'].value);
        data.append('code',add_chemical_form.elements['code'].value);
   
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/chemical_ajax.php",true);

        xhr.onload = function() {
    var myModalEl = document.getElementById('add-chemical')
    var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
    modal.hide();

    if (this.responseText == 'success') {
        Swal.fire(
            'Good job!',
            'Chemical Added',
            'success'
        )
        add_chemical_form.reset();
        get_chemical();
    }else if(this.responseText == 'code_name'){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Code or name already exist',
        })
    }else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'The code already exists!',
        })
    }
}

        xhr.send(data);
}


function get_chemical(){
        
    let xhr = new XMLHttpRequest();
    xhr.open("POST","./ajax/chemical_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
         document.getElementById('chemical_data').innerHTML = this.responseText;
        }
        xhr.send('get_chemical');

}




let edit_chemical= document.getElementById('edit_chemical');

function chemical_details(id){
    

    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/chemical_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
        
            let data = JSON.parse(this.responseText);
            edit_chemical.elements['name'].value = data.chemicaldata.name;
            edit_chemical.elements['unit'].value = data.chemicaldata.area;
            edit_chemical.elements['area'].value = data.chemicaldata.area;
            edit_chemical.elements['shelf'].value = data.chemicaldata.shelf;
            edit_chemical.elements['unit'].value = data.chemicaldata.unit;
            edit_chemical.elements['quantity'].value = data.chemicaldata.quantity;
            edit_chemical.elements['concentration'].value = data.chemicaldata.concentration;
            edit_chemical.elements['date_added'].value = data.chemicaldata.date_added;
            edit_chemical.elements['date_expiration'].value = data.chemicaldata.date_exp;
            edit_chemical.elements['chemical_id'].value = data.chemicaldata.id;
            
            
        //     edit_chemical.elements['features'].forEach(el => {
        //     if(data.features.includes(Number(el.value))){
        //        el.checked = true;
        //     }
        // });

        }
        xhr.send('edit_chemical='+id);
}


edit_chemical.addEventListener('submit', function(e){
    e.preventDefault();
    submit_edit_chemical();
});


function submit_edit_chemical(){
    let data= new FormData();
        data.append('submit_edit_chemical','');
        data.append('chemical_id',edit_chemical.elements['chemical_id'].value);
        data.append('name',edit_chemical.elements['name'].value);
        data.append('area',edit_chemical.elements['area'].value);
        data.append('concentration', edit_chemical.elements['concentration'].value);
        data.append('unit',edit_chemical.elements['unit'].value);
        data.append('quantity',edit_chemical.elements['quantity'].value);
        data.append('date_added',edit_chemical.elements['date_added'].value);
        data.append('date_expiration',edit_chemical.elements['date_expiration'].value);
        data.append('shelf', edit_chemical.elements['shelf'].value);



        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/chemical_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('edit-chemical')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Chemical Edit Successfully',
                'success'
                )
                edit_chemical.reset();
                get_chemical();
                
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
        xhr.open("POST","./ajax/chemical_ajax.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
            xhr.onload = function(){
                if(this.responseText==1){
                    // alert('success','Status Active');
                    get_chemical();
                }
                else{
                    alert('error','Status Not Active');
                }
            }
            xhr.send('toggleStatus='+id+'&value='+val);
    
    }


        
    function search_chemical(apparatusname){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/chemical_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('chemical_data').innerHTML = this.responseText;
        }
        xhr.send('search_chemical&name='+apparatusname);
    }




window.onload = function(){
    get_chemical();
}



</script>



    



    


       

    
    
             

   </body>
</html>

