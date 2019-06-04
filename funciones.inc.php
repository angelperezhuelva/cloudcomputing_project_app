<?php

function conectar_BD(){

    $server = "mysql-service";
    $user = "root";
    $password = "root";
    
    $conexion=mysqli_connect($server, $user, $password);
    
    if(!$conexion){
        echo 'Error en la conexion';
        return -1;
    }else{
        $db_name="ONG_BD";
        mysqli_set_charset($conexion,'utf8');
        $db = mysqli_select_db($conexion, $db_name);
        if(!$db){
            echo 'Error en la conexion';
            return -1;
        }else{
            return $conexion; //FALSE en caso de error
        }
    }

}

function consultar($consulta){
    $conexion = conectar_BD();
    return mysqli_query($conexion, $consulta); //FALSE para consulta fallida
}

function crear_tabla($nombre_tabla, $campos, $res4){
    echo '<table border="0">';
    echo "<tr><h3>$nombre_tabla</h3></tr>";

    //Campos de la tabla
    foreach($campos as $valor){
        echo "<th>$valor</th>";
    }

    $size = sizeof($campos);
    while($columna = mysqli_fetch_array($res4)){
        echo '<tr>';
            for($i=0;$i < $size;$i++){
                echo '<td>'.$columna[$campos[$i]].'</td>';
            };                
        echo '</tr>';
    }
    echo '<hr>';
}

function crear_tabla1($campos, $res4){
    
    echo '<table border="0">';
    echo '<tr>';

    //Campos de la tabla
    foreach($campos as $valor){
        echo "<th>$valor</th>";
    }

    $size = sizeof($campos);
    while($columna = mysqli_fetch_array($res4)){
        echo '<tr>';
            for($i=0;$i < $size;$i++){
                echo '<td>'.$columna[$campos[$i]].'</td>';
            };                
        echo '</tr>';
    }
    echo '<hr>';
}

function validar_consulta($resultado){
    
    $tmp = mysqli_fetch_array($resultado);
    
    if($tmp == NULL) return false;
    else return true;
    
}

function validar_texto($texto,$max){
    if(($texto != '')AND(strlen($texto) <= $max)){
        return true;
    }else return false;
}


function validar_dni($texto,$max){
    if(($texto != '')AND(strlen($texto) <= $max)){
        if(preg_match('/^[0-9XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i',$texto))
            return true;
    }else return false;
}

function validar_password($texto, $min=5){
    return (strlen($texto)>$min);
}

function mostrar_matriz($matriz,$título="",$nivel=0) {

  // Parámetros
  //    - $matriz = matriz cuyo contenido se debe mostrar
  //    - $título = título que se debe mostrar sobre el contenido
  //    - $nivel = nivel de visualización

  // si hay un título, mostrarlo
  if ($título != "") {
    echo "<P><B>$título</B><BR>\n";
  }

  // comprobar si hay datos
  if (isset($matriz)) { // hay datos

    // examinar la matriz parametrada
    reset ($matriz);
    while (list ($clave, $valor) = each ($matriz)) {

      // mostrar la clave (con sangría función 
      // del nivel)
      echo
        str_pad("",12*$nivel, "&nbsp;").
            htmlentities($clave,ENT_QUOTES|ENT_XHTML,'UTF-8')." = ";

      // mostrar el valor
      if (is_array($valor)) { // es una matriz ...

        // incluir una etiqueta <BR>
        echo "<BR>";
        // y llamar de manera recursiva a mostrar_matriz para 
        // mostrar la matriz en cuestión (sin título y a
        // nivel superior para la sangría)
        mostrar_matriz($valor,"",$nivel+1);

      } else { // es un valor escalar

        // mostrar el valor
        echo htmlentities($valor,ENT_QUOTES|ENT_XHTML,'UTF-8')."<BR>";

      }
      
    }

  } else { // sin datos

    // incluir una simple etiqueta <BR>
    echo "<BR>\n";

  }

}

function hacia_formulario($valor) {

  // presentación en un formulario
  // codificar todos los caracteres HTML especiales
  //  - ENT_QUOTES: incluyendo " y '
  return htmlentities($valor,ENT_QUOTES|ENT_XHTML,'UTF-8');

}


function hacia_pagina($valor) {

  // presentación directa en una página

  // 1. codificar todos los caracteres HTML especiales
  //  - ENT_QUOTES: incluyendo " y '
  // 2. transformar los saltos de línea en <BR>
  return nl2br(htmlentities($valor,ENT_QUOTES|ENT_XHTML,'UTF-8'));

}


function construir_consulta($sql) {

  // Recuperar el número de parámetro.
  $número_param = func_num_args();

  // Hacer bucle en todos los parámetros a partir del segundo
  // (el premero contiene la consulta de base).
  for($i=1;$i<$número_param;$i++) {

    // Recuperar el valor del parámetro.
    $valor = func_get_arg($i);

    // Si es una cadena, escaparla.
    if (is_string($valor)) {
      $valor = str_replace("'","''",$valor);
    }

    // Colocar el valor en su ubicación %n (n = $i).
    $sql = str_replace("%$i",$valor,$sql);
  }

  // Devolver la consulta.
  return $sql;

}


function identificador_único() {

  // generación del identificador
  return md5(uniqid(rand()));

}


function url($url) {

  // si la directiva de configuración session.use_trans_sid 
  // está en 0 (ninguna transmisión automática a través de la URL) y 
  // si SID no está vacío (el equipo ha rechazado la cookie), entonces
  // es necesario gestionar él mismo la transmisión

  if ((get_cfg_var("session.use_trans_sid") == 0) and (SID != "")) {
  
    // agregar la constante SID detrás de la URL con un ? 
    // si todavía no hay ningún parámetro o con un & en
    // caso contrario.

    $url .= ((strpos($url,"?") === FALSE)?"?":"&").SID;

  }

  return $url;

}


function mysql_db_leer_línea($consulta) {

  // La variable $ok se utiliza para saber
  // si todo va bien.

  // Conectarse (por defecto) y seleccionar la base de datos
  $ok = ($conexión = mysqli_connect());
  if ($ok) {
    $ok = mysqli_select_db($conexión,'diane');
  }

  // Ejecutar la consulta y comprobar el resultado para
  // asignar la variable $ok.
  if ($ok) {
    $ok = ( ($resultado = mysqli_query($conexión,$consulta)) != FALSE );
  }

  // Leer la línea.
  if ($ok) {
    $línea = mysqli_fetch_assoc($resultado);
  }

  // Devolver $línea o FALSE en caso de error
  return ($ok)?$línea:FALSE;

}

function mysql_db_leer_línea_con_error($consulta, &$error) {

  // En esta nueva versión, db_leer_línea toma un
  // segundo parámetro por referencia en el cual se almacenará un número 
  // y un mensaje en caso de error (en la 
  // forma de una matriz).

  // Inicializar $error.
  $error = array(0,''); // número = 0 - mensaje vacío

  // Conectarse (por defecto)
  $ok = ($conexión = mysqli_connect());
  if ($ok) { // conexión OK
    // Seleccionar la base de datos.
    $ok = mysqli_select_db($conexión,'diane');
  }
  if ($ok) { // selección de la base de datos OK
  // Ejecutar la consulta y comprobar el resultado para
  // asignar la variable $ok.
    $ok = ( ($resultado = mysqli_query($conexión,$consulta)) != FALSE );
  }
  if ($ok) { // ejecución OK
  // Leer el resultado.
     $línea = mysqli_fetch_assoc($resultado);
  } 
  if (! $ok) { // error en alguna parte
    // Recuperar la información sobre el error.
    if (! $conexión) { // error de conexión
	$error = [mysqli_connect_errno(),mysqli_error()];
  } else { // otro error
    $error = [mysqli_errno($conexión),mysqli_error($conexión)];
  }
 }

  // Devolver $línea o FALSE en caso de error.
  return ($ok)?$línea:FALSE;

}


function mysql_db_leer_líneas_en_matriz($consulta) {

  // La variable $ok se utiliza para saber
  // si todo va bien.

  // Conectarse (por defecto) y seleccionar la base de datos
  $ok = ($conexión = mysqli_connect());
  if ($ok) {
    $ok = mysqli_select_db($conexión,'diane');
  }

  // Ejecutar la consulta y comprobar el resultado para
  // asignar la variable $ok.
  if ($ok) {
    $ok = ( ($resultado = mysqli_query($conexión,$consulta)) != FALSE );
  }

  // Inicializar la matriz.
  $matriz = array();

  // Leer las líneas en la matriz.
  if ($ok) {
    $matriz = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
  }

  // Devolver $matriz o FALSE en caso de error.
  return ($ok)?$matriz:FALSE;

}


function oracle_db_leer_línea($consulta) {

  // Conectarse.
  $ok =($conexión = 
          oci_connect('demeter','demeter','diane','UTF8'));

  if ($ok) { // conexión OK
    // Analizar la consulta.
    $ok = ($cursor = oci_parse($conexión,$consulta));
  }

  if ($ok) { // análisis OK
    // Ejecutar la consulta.
    $ok = oci_execute($cursor);
  }

  if ($ok) { // ejecución OK
    // Leer el resultado.
    $línea =
        oci_fetch_array($cursor,OCI_ASSOC+OCI_RETURN_NULLS);
  }

  // Devolver $línea o FALSE en caso de error
  return ($ok)?$línea:FALSE;

}


function oracle_db_leer_línea_con_error($consulta, &$error) {

  // En esta nueva versión, db_leer_línea toma un
  // segundo parámetro por referencia en el cual se almacenará un número 
  // y un mensaje en caso de error (en la 
  // forma de una matriz).

  // Inicializar $error: código = 0 - mensaje vide.
  // La matriz es conforme a la estructura de la matriz
  // devuelta por oci_error.
  $error = array('código' => 0, 'mensaje' => '');

  // Conectarse.
  $ok =($conexión = 
          oci_connect('demeter','demeter','diane','UTF8'));

  if ($ok) { // conexión OK
    // Analizar la consulta.
    $ok = ($cursor = oci_parse($conexión,$consulta));
  }

  if ($ok) { // análisis OK
    // Ejecutar la consulta.
    $ok = oci_execute($cursor);
  }

  if ($ok) { // ejecución OK
    // Leer el resultado.
    $línea =
        oci_fetch_array($cursor,OCI_ASSOC+OCI_RETURN_NULLS);
  }

  if (! $ok) { // error en alguna parte
    // Si conexión OK, recuperar el error del cursor
    // en caso contrario, recuperar el error de la conexión.
    $error = $conexión?oci_error($cursor):oci_error();
  }

  // Devolver $línea o FALSE en caso de error
  return ($ok)?$línea:FALSE;

}


function oracle_db_leer_líneas_en_matriz($consulta) {

  // Conectarse.
  $ok =($conexión = 
          oci_connect('demeter','demeter','diane','UTF8'));

  if ($ok) { // conexión OK
    // Analizar la consulta.
    $ok = ($cursor = oci_parse($conexión,$consulta));
  }

  if ($ok) { // análisis OK
    // Ejecutar la consulta.
    $ok = oci_execute($cursor);
  }

  if ($ok) { // ejecución OK
    // Leer el resultado.
    $número = oci_fetch_all($cursor,$matriz);
  }

  // devolver $matriz o FALSE en caso de error.
  return ($ok)?$matriz:FALSE;

}


function sqlite_db_leer_línea($consulta) {

  // La variable $ok se utiliza para saber
  // si todo va bien.

  // Abrir la base de datos.
  $ok = (bool) ($base = new SQLite3('/app/sqlite/diane.dbf'));

  // Ejecutar la consulta y comprobar el resultado para
  // asignar la variable $ok.
  if ($ok) {
    $ok = ( ($resultado = $base->query($consulta)) != FALSE );
  }

  // Leer la línea.
  if ($ok) {
    $línea = $resultado->fetchArray();
  }

  // Devolver $línea o FALSE en caso de error
  return ($ok)?$línea:FALSE;

}


function sqlite_db_leer_línea_con_error($consulta, &$error) {

  // En esta nueva versión, db_leer_línea toma un
  // segundo parámetro por referencia en el cual se almacenará un número 
  // y un mensaje en caso de error (en la 
  // forma de una matriz).

  // Inicializar $error.
  $error = array(0,''); // número = 0 - mensaje vacío

  // Abrir la base de datos y comprobar el resultado para asignar
  // la variable $ok.
  try
  {
    $base = new SQLite3('/app/sqlite/diane.dbf');
    $ok = TRUE;
  } catch (Exception $e) {
  // En caso de error, asignar $error.
  // Se utiliza un código de error ficticio.
    $error = array(-1,$e->getMessage());
    $ok = FALSE;
  }

  // Ejecutar la consulta y comprobar el resultado para asignar
  // la variable $ok.
  if ($ok) {
    $ok = ( ($resultado = $base->query($consulta)) != FALSE );
    // En caso de error, recuperar la información 
    // sobre el error.
    if (! $ok) {
      $error = array($base->lastErrorCode(),$base->lastErrorMsg());
    }
  }

  if ($ok) { // ejecución OK
    // Leer la línea.
    $línea = $resultado->fetchArray();
  }

  // Devolver $línea o FALSE en caso de error.
  return ($ok)?$línea:FALSE;

}


function sqlite_db_leer_líneas_en_matriz($consulta) {
  
  // La variable $ok se utiliza para saber
  // si todo va bien.
  
  // Abrir la base de datos.
  $ok = (bool) ($base = new SQLite3('/app/sqlite/diane.dbf'));
  
  // Ejecutar la consulta y probar el resultado para
  // asignar la variable $ok.
  if ($ok) {
    $ok = ( ($resultado = $base->query($consulta)) != FALSE );
  }
  
    // Leer el resultado y almacenarlo en una matriz.
    if ($ok) {
	  while ($línea = $resultado->fetchArray()) {
	    $matriz[] = $línea;
    }
  }
  // Devolver $matriz o FALSE en caso de error.
  return ($ok)?$matriz:FALSE;
}

?>



