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
            <h1>New Records Data</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">New Records</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 fw-bold"> Apparatus Unit</h5>
                            <button type="button" class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#facilities">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                        </div>


                           <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border">
                            <thead>
                                <tr class="text-white"  style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col"width="65%">Name</th>
                                <th scope="col"  width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="facilities_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>


                       
         </div>
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 fw-bold"> Chemical Unit</h5>
                            <button type="button" class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#chemical">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                        </div>


                           <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border">
                            <thead>
                                <tr class="text-white"  style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col"width="65%">Name</th>
                                <th scope="col"  width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="chemical_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>


                       
         </div>
         </div>
         
         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 fw-bold"> Made Products</h5>
                            <button type="button" class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#made">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                        </div>


                           <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border">
                            <thead>
                                <tr class="text-white"  style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col"width="65%">Name</th>
                                <th scope="col"  width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="made_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>


                       
         </div>
         </div>

         
         <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 fw-bold"> Faculty Member</h5>
                            <button type="button" class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#features">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                        </div>


                           <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border">
                            <thead>
                                <tr class="text-white"  style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">Faculty Name</th>
                                <th scope="col" width="40%">Department</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="features_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 fw-bold"> Add Course</h5>
                            <button type="button" class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#course">
                            <i class="bi bi-file-plus"></i> Add
                            </button>
                        </div>


                           <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                           <table class="table table-hover border">
                            <thead>
                                <tr class="text-white"  style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">Course </th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="course_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

                        </div>
                    </div>


  
      </main>

    
      <div class="modal fade" id="facilities" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="facilities_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-bell"></i> Add Apparatus Unit</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" id="facilities_name" class="form-control shadow-none">
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

        <div class="modal fade" id="chemical" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="chemical_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-bell"></i> Add Chemical Unit</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" id="chemical_name" class="form-control shadow-none">
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

        <div class="modal fade" id="made" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="made_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-bell"></i> Add Made</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" id="made_name" class="form-control shadow-none">
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


           <!---- Features Modal-->

           <div class="modal fade" id="features" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="features_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-chat-square-heart"></i> Add Faculty Member</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="features_name" class="form-control shadow-none">
                            </div>
                            <div class="mb-3">
                                
                <label class="form-label mb-3"> Select Department
                <select class='form-select shadow-none' aria-label='Default select example' name='features_desc' required>
                                <option disabled selected value="">Select a Department...</option> <!-- placeholder option -->
                                <?php
                                $res = selectAll('course');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo "<option value='$opt[name]'>$opt[name]</option>";
                                }
                                ?>
                            </select>
            </label>
                                

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

        
        <div class="modal fade" id="course" data-bs-backdrop="static" data-bs-keyboard= "true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="course_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="bi bi-bell"></i> Add Course</div>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label class="form-label fw-bold">Course Name</label>
                                <input type="text" id="course_name" class="form-control shadow-none">
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


    let facilities_form = document.getElementById('facilities_form');
    let chemical_form = document.getElementById('chemical_form');
    let made_form = document.getElementById('made_form');
    let features_form = document.getElementById('features_form');
    let course_form = document.getElementById('course_form');

    facilities_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_facilities();
    });

    function add_facilities(){
        let data= new FormData();
        data.append('name',facilities_form.elements['facilities_name'].value);
        data.append('add_facilities','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('facilities')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'New Appratues Unit',
                'success'
                )

                facilities_form.elements['facilities_name'].values='';
                get_facilities();
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

    function get_facilities(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
        xhr.onload = function (){
            document.getElementById('facilities_data').innerHTML = this.responseText;
        }

        xhr.send('get_facilities');
    } 


    function rem_facilities(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
 
        xhr.onload = function (){
            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Appartus Unit Removed',
                'success'
                )
                get_facilities();
            }
            else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Server Down.',
                })
            }
        }

        xhr.send('rem_facilities='+val);
    }




  chemical_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_chemical();
    });

    function add_chemical(){
        let data= new FormData();
        data.append('name',chemical_form.elements['chemical_name'].value);
        data.append('add_chemical','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('chemical')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'New Chemical Unit',
                'success'
                )

                chemical_form.elements['chemical_name'].values='';
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

    function get_chemical(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
        xhr.onload = function (){
            document.getElementById('chemical_data').innerHTML = this.responseText;
        }

        xhr.send('get_chemical');
    } 

    
    function rem_chemical(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
 
        xhr.onload = function (){
            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Chemical Unit Removed',
                'success'
                )
                get_chemical();
            }
            else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Server Down.',
                })
            }
        }

        xhr.send('rem_chemical='+val);
    }









    made_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_made();
    });

    function add_made(){
        let data= new FormData();
        data.append('name',made_form.elements['made_name'].value);
        data.append('add_made','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('made')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'New Made Added',
                'success'
                )

                made_form.elements['made_name'].values='';
                get_made();
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


    function get_made(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
        xhr.onload = function (){
            document.getElementById('made_data').innerHTML = this.responseText;
        }

        xhr.send('get_made');
    } 

    function rem_made(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
 
        xhr.onload = function (){
            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Made Removed Successfully',
                'success'
                )
                get_made();
            }

            else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Server Down',
                })
            }
        }

        xhr.send('rem_made='+val);
    }








    features_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_features();
    });


    function add_features(){
        let data= new FormData();
        data.append('name',features_form.elements['features_name'].value);
        // data.append('icon',features_form.elements['features_icon'].files[0]);
        data.append('desc',features_form.elements['features_desc'].value);
        data.append('add_features','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);

        xhr.onload = function(){

         
            var myModalEl = document.getElementById('features')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText== 'inv_img'){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Only SVG images are supported',
                })
                
            }
            else if(this.responseText== 'inv_size'){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Image shoud be less than 1MB in size',
                })
               
            }
            else if(this.responseText == 'upd_failed'){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Image Upload failed',
                })
           
            }
            else{
                                Swal.fire(
                'Good job!',
                'New Faculty Added',
                'success'
                )
             
                features_form.reset();
                get_features();
                
            }

        }
        xhr.send(data);
    }

    function get_features(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
        xhr.onload = function (){
            document.getElementById('features_data').innerHTML = this.responseText;
        }

        xhr.send('get_features');
    } 

    function rem_features(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
 
        xhr.onload = function (){
            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Faculty Removed Successfully',
                'success'
                )
                
                get_features();
            }
            else if(this.responseText== 'room_added'){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A Policy is added to the room.',
                })
               
            }
            else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A Faculty is added to the Faculty Member.',
                })
            }
        }

        xhr.send('rem_features='+val);
    }


    course_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_course();
    });

    function add_course(){
        let data= new FormData();
        data.append('name',course_form.elements['course_name'].value);
        data.append('add_course','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);

        xhr.onload = function(){
            var myModalEl = document.getElementById('course')
            var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instanceof
            modal.hide();

            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'New Course Added Success',
                'success'
                )

                course_form.elements['course_name'].values='';
                get_course();
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

    function get_course(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        
        xhr.onload = function (){
            document.getElementById('course_data').innerHTML = this.responseText;
        }

        xhr.send('get_course');
    } 

    function rem_course(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./ajax/new_records_ajax.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
 
        xhr.onload = function (){
            if(this.responseText==1){
                Swal.fire(
                'Good job!',
                'Course Removed Successfully',
                'success'
                )
                get_course();
            }
            else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong.',
                })
            }
        }

        xhr.send('rem_course='+val);
    }



    window.onload = function(){
        get_facilities();
        get_chemical();
        get_features();
        get_course();
        get_made();
    }
    



</script>



    



    


       

    
    
             

   </body>
</html>

