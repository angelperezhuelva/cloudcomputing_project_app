<?php
     require("funciones.inc.php");
    
    $voluntario = "SELECT * FROM VOLUNTARIO";
    $alimento = "SELECT * FROM ALIMENTO";
    $establecimiento = "SELECT * FROM ESTABLECIMIENTO";
    $institucion = "SELECT * FROM INSTITUCION";
    $persona = "SELECT * FROM PERSONA";

    //Campos de los registros de las tablas de la BD
    $campos_voluntario=array('id_voluntario');
    $campos_institucion=array('cif','nombre','razon_social','telefono','id_voluntario');
    $campos_alimento=array('id_alimento','id_voluntario','id_establecimiento','descripcion','fecha_caducidad','fecha_recogida','entregado');
    $campos_establecimiento=array('id_establecimiento','nombre','direccion','localidad');
    $campos_persona=array('dni','nombre','apellidos','telefono','email','edad','localidad','id_voluntario');
        
    $res_alimento = consultar($alimento);
    validar_consulta($res_alimento);

    $res_voluntario = consultar($voluntario);
    validar_consulta($res_voluntario);
    
    $res_establecimiento = consultar($establecimiento);
    validar_consulta($res_establecimiento);

    $res_institucion = consultar($institucion);
    validar_consulta($res_institucion);

    $res_persona = consultar($persona);
    validar_consulta($res_persona);

?>


<?php include('header.php'); ?>

<body>
    <h2>Tablas de la Base de datos:</h2><hr>
        
        <?php crear_tabla("Alimentos", $campos_alimento, $res_alimento); ?>
        <?php crear_tabla("Establecimientos", $campos_establecimiento, $res_establecimiento); ?>
        <?php crear_tabla("Instituciones", $campos_institucion, $res_institucion); ?>
        <?php crear_tabla("Personas", $campos_persona, $res_persona); ?>
        <?php crear_tabla("Voluntarios", $campos_voluntario, $res_voluntario); ?>
        
</body>


<?php include('footer.php'); ?>
