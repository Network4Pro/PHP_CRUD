<?php

require("connexion.php");

function image_remove($img){
    if(unlink(UPLOAD_SRC.$img)){
        echo "deleted";
    }
    else{
        echo "not deleted";
    }
}

function image_upload($img){
    $tmp_loc = $img["tmp_name"];
    $new_name = random_int(11111,99999).'_'.$img['name'];
    $new_loc = UPLOAD_SRC.$new_name;
    if(!move_uploaded_file($tmp_loc,$new_loc)){
        header("location: index.php?alert=img_upload");
        exit;
    }
    else{ return $new_name; }
}



echo "<pre>";
if(isset($_POST['addproduct'])){
    foreach($_POST as $key => $value){
        $_POST[$key] = mysqli_real_escape_string($connexion,$value);
    }
$imgpath = image_upload($_FILES["image"]);

$query ="INSERT INTO `products` (`name`,`price`,`description`,`image`) 
VALUES ('$_POST[name]','$_POST[price]','$$_POST[desc]','$imgpath')";

if(mysqli_query($connexion,$query)){
    header("location: index.php?success=added");
}
else{
     header("location: index.php?alert=add_failed");
}

}

if(isset($_GET['rem']) && $_GET['rem']>0){
    $query = "SELECT * FROM products WHERE ID=$_GET[rem]";
    $result = mysqli_query($connexion,$query);
    $fetch=mysqli_fetch_assoc($result);
    image_remove($fetch['image']);
}


echo "</pre>";
