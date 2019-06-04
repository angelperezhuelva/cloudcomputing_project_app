<?php

    include("funciones.inc.php");

    if(isset($_POST['enviar'])){

    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dni = trim($_POST['dni']);
    $password = trim($_POST['password']);
    
    $apellidos=filter_var($apellidos, FILTER_SANITIZE_STRING);
    $nombre=filter_var($nombre, FILTER_SANITIZE_STRING);
    $mensaje='';  
        
        if(!validar_texto($nombre, 20)){
            $mensaje.="El nombre puede tener como máximo 20 caracteres.\n";
        }
        
        if(!validar_texto($apellidos, 30)){
            $mensaje.="Los apellidos pueden tener como máximo 30 caracteres.\n";
        }
        
        if(!validar_dni($dni, 9)){
            $mensaje.="El DNI debe tener como máximo 9 caracteres.\n";
        }
        
        if(!validar_password($password)){
            $mensaje.="La contraseña debe tener como mínimo 5 caracteres.\n";
        }
        
        if($mensaje == ''){
            header('location: index.php');
            
            conectar_BD();
            
            
            
            exit;
        }
        else{
            $mensaje = hacia_pagina($mensaje);
        }
        
    }else{
        exit;        
    }
        
?>

<?php include "header.php" ?>

<body>
    <h3>Error en el registro.</h3>
    <p><?php echo $mensaje; ?></p>
</body>
