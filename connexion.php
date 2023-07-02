<?php  

   define("UPLOAD_SRC",$_SERVER['DOCUMENT_ROOT']."/CRUD_PHP/uploads/");
   define("FETCH_SRC","http://127.0.0.1:8000/CRUD_PHP/uploads/");

   $host = "localhost"; // Nom d'hote
   $username = "root"; // Nom d'user
   $password = "Aa@123456"; // Mot de passe
   $database = "laravel_8"; // Nom de la DB
   

   $connexion = mysqli_connect($host,$username,$password,$database);

        

   


 
?>