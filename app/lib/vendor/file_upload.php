<?php
namespace lib\vendor;
trait file_upload
{
    private function multipleuploads($inpt,$src){
        global $con;
        $image = $_FILES[$inpt];
        $image_name = $image['name'];
        $image_type = $image['type'];
        $image_temp = $image['tmp_name'];
        $image_size = $image['size'];
        $image_eror = $image['error'];
        $allowed_extension = array('jpg','gif','png','jpeg');
        try{
                $errors = [];
                $ex_arr = explode('.',$image_name);
                $img_ex = strtolower(end($ex_arr));
                if($image_eror == 4){
                    return false;
                }else{
                    if($image_size > 10000000){
                        return false;
                    }
                    if(! in_array($img_ex,$allowed_extension)){
                        return false;
                    }
                }
                if(empty($errors)){
                    $destination_path = getcwd().DIRECTORY_SEPARATOR;
                    move_uploaded_file($image_temp,$destination_path.$src); 
                    echo "yes";
                    return true;
                }else{
                    return false;
                }
            return !empty($finalName) ? $finalName : null;
        }catch(Exception $e){
            echo 'Caught exception: '.$e->getMessage();
        }
    }
}