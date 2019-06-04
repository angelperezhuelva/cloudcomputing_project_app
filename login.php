<?php include('header.php');?>


<body>
    <form action="login_proc.php" method="post">
        DNI: <input type="text" name="dni" value="" /><br>
        Contraseña: <input type="password" name="password" value=""/><br>
        <input type="submit" name="enviar" value="Iniciar sesión" />
    </form>
</body>


<?php include('footer.php');?>