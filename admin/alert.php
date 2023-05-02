<?php 

// //front end
// define('SITE_URL','http://127.0.0.1/ptims/');
// define('CERTIFICATE_IMG_PATH',SITE_URL.'img/certificates/');



// //back end
// define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/ptims/img/');
// // define('PORTFOLIO_FOLDER','project/');
// // define('MAIN_FOLDER','main/');
// define('CERTIFICATE_FOLDER','certificates/');




function adminLogin(){
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        echo "
        <script>window.location.href='index.php';</script>
         ";
         exit;
    }
    
}


function redirect($url){
    echo "
        <script>window.location.href='$url';</script>
    ";
    exit;
}


function alert($type, $message){
    $bs_class = ($type == 'success') ? "alert-success" : "alert-danger";
    echo <<<alert


        <div class="alert $bs_class alert-dismissible fade show text-center custom-alert" role="alert">
        <strong class="m-3">$message</strong>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>


        alert;
        
}




// function uploadImage($image,$folder){
//     $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
//     $img_mime = $image['type'];

//     if(!in_array($img_mime,$valid_mime)){
//         return 'inv_img'; //invalid image mime or format not supported
//     }
//     else if(($image['size']/(1024*1024))>1){
//         return 'inv_size'; //invalid size greater than 1mb
//     }
//     else{
//         $ext= pathinfo($image['name'], PATHINFO_EXTENSION);
//         $rname='IMG_'.random_int(11111,99999).".$ext";

//         $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
//         if(move_uploaded_file($image['tmp_name'],$img_path)){
//             return $rname;
//         }
//         else{
//             return 'upd_failed'; //
//         }
//     }
// }


// function deleteImage($image,$folder){
//     if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
//        return true;
//     }else{
//        return false;
//     }
//  }





?>
