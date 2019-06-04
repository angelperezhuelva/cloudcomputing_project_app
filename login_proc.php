<?php
    include('funciones.inc.php');

    //var_dump($_POST);
    $mensaje="";
    if(isset($_POST['enviar'])){
        $dni = $_POST['dni'];
        $password = $_POST['password'];
        
        //$mensaje = validar_login($dni, $password);
        
        //36373239G adamemas
        $existe_dni = "SELECT * FROM PERSONA WHERE dni='$dni'";
        $login_correcto = "SELECT * FROM PERSONA WHERE dni='$dni' AND contraseña='$password'";
        
        $campos_persona=array('dni','nombre','apellidos','telefono','email','edad','localidad','id_voluntario');
                
        $tmp = consultar($existe_dni);
        
        if($tmp->num_rows > 0){
            $mensaje .= "Hallados: $tmp->num_rows Dni $dni valido";
        }else{
            $mensaje .= "Hallados: $tmp->num_rows Dni no valido.";
        }
        
        $tmp2 = consultar($login_correcto);
        
        if($tmp2->num_rows > 0){
            $mensaje .= "DNI: $dni password: $password.Hallados: $tmp->num_rows. Sesión iniciada correctamente.";
        }else{
            $mensaje .= "DNI: $dni password: $password.Hallados: $tmp->num_rows. Error al iniciar sesión.";
        }
        
        
        
        
        
        
    }else{
        $mensaje .= "Error";
    }
?>


<?php include('header.php'); ?>

<body>
    <h5><?php echo $mensaje ?></h5>
    <?php crear_tabla("Datos de usuario:",$campos_persona, $tmp); ?>
</body>

<?php include('footer.php'); ?>




















