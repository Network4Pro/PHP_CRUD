<?php

require("connexion.php");

function image_remove($img){
    if(!unlink(UPLOAD_SRC.$img)){
        header("location:index.php?alert=Echec_Delete_Image");
    }
}

function image_upload($img){
    $tmp_loc = $img["tmp_name"];
    $new_name = random_int(11111,99999).'_'.$img['name'];
    $new_loc = UPLOAD_SRC.$new_name;
    if(!move_uploaded_file($tmp_loc,$new_loc)){
        header("location: index.php?alert=Echec_Upload_Image_!!!");
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
    header("location: index.php?success=Ajoute_Produit_( $_POST[name] )_Avec_Succes_!!!");
}
else{
     header("location: index.php?alert=Echec_Ajoute_Produit__( $_POST[name] )");
}

}

if(isset($_GET['rem']) && $_GET['rem']>0){
    $query = "SELECT * FROM products WHERE ID=$_GET[rem]";
    $result = mysqli_query($connexion,$query);
    $fetch=mysqli_fetch_assoc($result);
    image_remove($fetch['image']);

    $query="DELETE FROM products where id= {$_GET['rem']}";
    if(mysqli_query($connexion,$query)){
        header("location: index.php?success=Delete_Produit__( $_POST[name] )_Avec_Sucess_!!!!");
    }else{
        header("location: index.php?alert=Echec_Delete_Produit__( $_POST[name] )");
    }
}



  if(isset($_POST['editproduct'])){
    foreach($_POST as $key => $value){
        $_POST[$key] = mysqli_real_escape_string($connexion,$value);
    }

    if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])){
        $query = "SELECT * FROM products WHERE ID=$_POST[editpid]";
        $result = mysqli_query($connexion,$query);
        $fetch=mysqli_fetch_assoc($result);
        $name = $fetch['name'];
        image_remove($fetch['image']);
        $imgpath= image_upload($_FILES['image']);
        $update = "UPDATE products SET `name`='$_POST[name]',`price`=$_POST[price], `description`='$_POST[desc]',`image`='$imgpath' 
        WHERE ID= $_POST[editpid]";
    }
    else{
        $update = "UPDATE products SET `name`='$_POST[name]',`price`=$_POST[price], `description`='$_POST[desc]'
        WHERE ID= $_POST[editpid]";
    }

    if(mysqli_query($connexion,$update)){
        header("location: index.php?success=Modifie_Produit__(  $name )_Avec_Sucess_!!!");
    }else{
        header("location: index.php?alert=Echec_Modifier_Produit__(  $name )");
    }
}



echo "</pre>";
