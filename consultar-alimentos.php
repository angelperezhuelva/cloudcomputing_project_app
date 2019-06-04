<?php
    require("funciones.inc.php");
    
    $voluntarios = "SELECT * FROM VOLUNTARIO";
    $alimentos = "SELECT * FROM ALIMENTO";
    $establecimientos = "SELECT * FROM ESTABLECIMIENTO";
    $institucion = "SELECT * FROM INSTITUCION";
    $persona = "SELECT * FROM PERSONA";

    $res1 = consultar($voluntarios);
    validar_consulta($res1);
    
    $res2 = consultar($alimentos);
    validar_consulta($res2);

    $res3 = consultar($establecimientos);
    validar_consulta($res3);

    $res4 = consultar($institucion);
    validar_consulta($res4);

    $res5 = consultar($persona);
    validar_consulta($res5);

?>


<?php include('header.php'); ?>

<body>
    <h2>Tablas de la Base de datos:</h2><hr>
    <h3>Voluntario:</h3>
    <table border="0">
        <tr>
            <th>id_voluntario</th>
            
            <?php while($columna = mysqli_fetch_array($res1)){?>
                <tr>
                    <td><?php echo $columna['id_voluntario']; ?></td>
                </tr>
            <?php } ?>
            
        </tr>
    </table><hr>
    
    <h3>Alimento: </h3>
    <table border="0">
        <tr>
            <th>id alimento</th>
            <th>id voluntario</th>
            <th>id establecimiento</th>
            <th>descripción</th>
            <th>fecha cad.</th>
            <th>fecha recogida</th>
            <th>entregado?</th>
            
            
            <?php var_dump($res2);
            while($columna = mysqli_fetch_array($res2)){?>
                <tr>
                    <td><?php echo $columna['id_alimento']; ?></td>
                    <td><?php echo $columna['id_voluntario']; ?></td>
                    <td><?php echo $columna['id_establecimiento']; ?></td>
                    <td><?php echo $columna['descripcion']; ?></td>
                    <td><?php echo $columna['fecha_caducidad']; ?></td>
                    <td><?php echo $columna['fecha_recogida']; ?></td>
                    <td><?php echo $columna['entregado']; ?></td>
                    
                </tr>
            <?php } ?>
        </tr>
    </table><hr>
    
    <h3>Establecimiento: </h3>
    <?php 
        $campos = array("'id_alimento'","id_voluntario", "id_establecimiento", "descripción", "fecha_cadudidad", "fecha_recogida", "entregado");

        crear_tabla($campos, $res2);   
    
    //$campos = array de nombres de las columnas
    function crear_tabla($campos, $res2){
        echo '<table border="0">';
        echo '<tr>';
        
        //Campos de la tabla
        foreach($campos as $valor){
            echo "<th>$valor</th>";
        }
        
        while($columna = mysqli_fetch_array($res2)){
         //var_dump($columna);
         
//          echo '<tr>';
//                for($i = 0; $i $campos; $i++){
                    //echo '<td>'.$columna[$campos[$i]].'</td>';
                    echo '<h3>'."Columna: ".$columna[$campos[0]].'</h3>';
//                };
            echo '</tr>';
        }
    }

    ?>
    
    
    
    
</body>

<?php include('footer.php'); ?>