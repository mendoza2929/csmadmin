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
            <h1>Students Records</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Students</li>
               </ol>

          
         </div>

         <div class="card border-0 shadow-sm mb-4">
         <div class="card-body mb-4">

                        <div class="text-end my-4">
                           <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search.." >
                        </div>
                     

                

                           <div class="table-responsive">
                           <table class="table table-hover border text-center" style="min-width:200px;">
                            <thead>
                                <tr class="text-white" style="background-color:#ED8B5A;">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Course</th>
                                <th scope="col">Year</th>
                               
                        
                        
                                
                                </tr>
                            </thead>
                            <tbody id="user_data">
                          
                             
                           
                            </tbody>
                            </table>
                            </div>

               
                            
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




function get_users(){
        
        let xhr = new XMLHttpRequest();
            xhr.open("POST","./ajax/users_ajax.php",true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    
            xhr.onload = function(){
                document.getElementById('user_data').innerHTML = this.responseText;
            }
            xhr.send('get_users');
    
    }
    
    
    
    
    
    
    function toggleStatus(id,val){
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST","./ajax/users_ajax.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            
                xhr.onload = function(){
                    if(this.responseText==1){
                        // alert('success','Status Active');
                        get_users();
                    }
                    else{
                        alert('error','Status Not Active');
                    }
                }
                xhr.send('toggleStatus='+id+'&value='+val);
        
        }
    
    
        
    
        
        function remove_user(user_id){
            
            if(confirm("Are you sure you want to remove this tenant?")){
                let data = new FormData();
                data.append('user_id',user_id);
                data.append('remove_user','');
                
            let xhr = new XMLHttpRequest();
            xhr.open("POST","./ajax/users_ajax.php",true);
        
    
                xhr.onload = function(){
                    if(this.responseText== 1){
                         Swal.fire(
                        'Deleted!',
                        'Student has been deleted',
                        'success'
                        )
                        get_users();
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
            get_users();
        }
    



</script>



    



    


       

    
    
             

   </body>
</html>

