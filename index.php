<?php
session_start();
require('inc/db.php');

function dump($value) {
    echo '<pre style="color:#fff;"><br><br><br><br><br><br>';
    var_dump($value);
    echo '</pre>';
    exit();
}
if(isset($_COOKIE['role']) && base64_decode($_COOKIE['role']) == ROLE_ADMIN)
{
    require_once ('admin.php');
}else{
    require_once ('main.php');
    //resize_images();
}

function resize_images(){
    $images= glob("uploads/profile/*.png");
   // $images= ['uploads/profile/+234704713345.png'];

    foreach ($images as $filename) {
        //resize the image
        if(resizeImage($filename,$filename,350,450,80)){
            echo $filename.' resize Success!<br />';
        }
    }
    dump($images);
}


function resizeImage($SrcImage,$DestImage, $MaxWidth,$MaxHeight,$Quality)
{
    list($iWidth,$iHeight,$type)    = getimagesize($SrcImage);

    //if you dont want to rescale image

    $NewWidth=$MaxWidth;
    $NewHeight=$MaxHeight;
    $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
    $newImage= imagecreatefromjpeg($SrcImage);
    // Resize Image
    if(imagecopyresampled($NewCanves, $newImage,0, 0, 0, 0, $NewWidth, $NewHeight, $iWidth, $iHeight))
    {
        // copy file
        if(imagejpeg($NewCanves,$DestImage,$Quality))
        {
            imagedestroy($NewCanves);
            return true;
        }
    }
}