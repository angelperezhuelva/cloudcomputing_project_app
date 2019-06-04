<?php include("header.php"); ?>

<body>
    <h2>Formulario de registro</h2>
    
    <form action="signup_proc.php" method="POST">
       <h3>Datos personales:</h3><hr><br />
       
       Nombre: <input type="text" name="nombre" value=""/><br />
           
       Apellidos: <input type="text" name="apellidos" value=""/><br />
       
       DNI: <input type="text" name="dni" value=""/><br />
       
       Contraseña: <input type="password" name="password" value="" size="20" maxlength="20" /><br />
               
       <input type="submit" name="enviar" value="Registrar"/> 
        
    </form>
    
</body>

<?php include("footer.php"); ?>

