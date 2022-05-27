<?php require_once('Connections/Conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_POST['borrar'])) && ($_POST['borrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM partidos WHERE ID_EQUIPO_1=%s",
                       GetSQLValueString($_POST['borrar'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());

  $deleteGoTo = "Equipos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST['borrar'])) && ($_POST['borrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM partidos WHERE ID_EQUIPO_2=%s",
                       GetSQLValueString($_POST['borrar'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());

  $deleteGoTo = "Equipos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST['borrar'])) && ($_POST['borrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM goleo WHERE ID_EQUIPO=%s",
                       GetSQLValueString($_POST['borrar'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());

  $deleteGoTo = "Equipos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST['borrar'])) && ($_POST['borrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM equipos WHERE ID_EQUIPO=%s",
                       GetSQLValueString($_POST['borrar'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());

  $deleteGoTo = "Equipos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
/*
mysql_select_db($database_Conexion, $Conexion);
$query_Equipos = "SELECT * FROM equipos, torneos WHERE torneos.ID_TORNEO=equipos.ID_TORNEO ORDER BY NOM_TORNEO ASC, NOM_EQUIPO ASC";
$Equipos = mysql_query($query_Equipos, $Conexion) or die(mysql_error());
$row_Equipos = mysql_fetch_assoc($Equipos);
$totalRows_Equipos = mysql_num_rows($Equipos);
*/
mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Torneos = "SELECT * FROM torneos ORDER BY NOM_TORNEO ASC";
$Lista_Torneos = mysql_query($query_Lista_Torneos, $Conexion) or die(mysql_error());
$row_Lista_Torneos = mysql_fetch_assoc($Lista_Torneos);
$totalRows_Lista_Torneos = mysql_num_rows($Lista_Torneos);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<meta http-equiv="content-type" content="text/html; utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<LINK REL=StyleSheet HREF="Styles.css" TYPE="text/css" MEDIA=screen>

<script language="JavaScript">
function confirmar ( mensaje ) {
return confirm( mensaje );
}
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php">POSICIONES</a>
  <a href="Partidos.php">PARTIDOS</a>
  <a href="Anuncios.php">ANUNCIOS</a>
  <div ><a href="Equipos.php"><i style='font-size:20px' class='fas fa-user-cog'></i></a></div>  
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<divs>

<table width="15%" border="0">
    <tr>
    <th width="20%"><div align="center" title="Agregar Partidos"><a href="Agregar_P.php"><i style="font-size:40px" class="fa">&#xf073;</i></a></div></th>
    <th width="20%"><div align="center" title="Agregar Equipos"><a href="Agregar_E.php"><i style="font-size:40px" class="fa">&#xf0c0;</i></a></div></th>
    <th width="20%"><div align="center" title="Agregar Goleo"><a href="Agregar_G.php"><i style="font-size:40px" class="fa">&#xf1e3;</i></a></div></th>
    <th width="20%"><div align="center" title="Agregar Anuncios"><a href="Agregar_A.php"><i style="font-size:40px" class="fa">&#xf071;</i></a></div></th>
    <th width="20%"><div align="center" title="Agregar Torneos"><a href="Agregar_T.php"><i style="font-size:40px" class="fa">&#xf091;</i></a></div></th>
  </table>
  
<?php do { 	
	$torneo=$row_Lista_Torneos['ID_TORNEO'];/*Selecccionar Torneo*/
	mysql_select_db($database_Conexion, $Conexion);
	$query_Equipos = "SELECT * FROM equipos, torneos WHERE torneos.ID_TORNEO=equipos.ID_TORNEO and torneos.ID_TORNEO='$torneo' ORDER BY NOM_EQUIPO ASC";
	$Equipos = mysql_query($query_Equipos, $Conexion) or die(mysql_error());
	$row_Equipos = mysql_fetch_assoc($Equipos);
	$totalRows_Equipos = mysql_num_rows($Equipos);
	
	/*Validar que el Torneo tenga equipos*/
	if($row_Equipos>0){  ?>
	<h2 align="center"> <strong>Torneo <?php echo $row_Lista_Torneos['NOM_TORNEO']."<br>"; ?></strong></h2>
 
<table border="1" align="center">
  <tr>
    <td width="2%"><strong>N°</strong></td>
    <td width="22%"><strong>NOMBRE DEL EQUIPO</strong></td>
    <td width="19%"><strong>TORNEO</strong></td>
    <td width="9%"><div align="center"><strong>GOLEO</strong></div></td>
    <td width="9%"><div align="center"><strong>REGISTRO</strong></div></td>
    <td width="10%"><div align="center"><strong>MODIFICAR</strong></div></td>
    <td width="9%"><div align="center"><strong>BORRAR</strong></div></td>
  </tr>
  <?php do {   ?>
    <tr>
      <td><?php echo $row_Equipos['NUMERO']; ?></td>
      <td><?php echo $row_Equipos['NOM_EQUIPO']; ?></td>
      <td><?php echo $row_Equipos['NOM_TORNEO']; ?></td>
      <td><form name="form4" method="get" action="Estadisticas.php"><div align="center">
      	<button type="submit"><i style="font-size:24px" class="fa" title="Goles del Equipo">&#xf1e3;</i></button>
        <input name="goleo" type="hidden" id="estadistica" value="<?php echo $row_Equipos['ID_EQUIPO']; ?>">
      </div>
      </form>
      <td><form name="form3" method="get" action="Estadisticas.php"><div align="center">
      	<button type="submit"><i style="font-size:24px" class="fa" title="Modificar Estadisticas">&#xf080;</i></button>
        <input name="estadistica" type="hidden" id="estadistica" value="<?php echo $row_Equipos['ID_EQUIPO']; ?>">
      </div>
      </form></td>
      <td><form name="form2" method="get" action="Modificar.php"><div align="center">
        <button type="submit"><i class="w3-xlarge w3-spin fa fa-refresh" title="Modificar Datos"></i></button>
        <input name="modificar" type="hidden" id="modificar" value="<?php echo $row_Equipos['ID_EQUIPO']; ?>">
      </div></form></td>
      <td><form name="form1" method="post" action=""><div align="center">
      	<button type="submit"><i style="font-size:24px" class="fa" title="Eliminar">&#xf014;</i></button>
        <input name="borrar" type="hidden" id="borrar" value="<?php echo $row_Equipos['ID_EQUIPO']; ?>">
      	</div></form></td>
    </tr>
    <?php } while ($row_Equipos = mysql_fetch_assoc($Equipos)); ?>
</table>
<!--Repetir Tabla   -->
   <?php } 
   /*Cierre del IF esta vacia la consulta*/
   } 
   while ($row_Lista_Torneos = mysql_fetch_assoc($Lista_Torneos)); ?>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
</body>
</html>
<?php
mysql_free_result($Equipos);

mysql_free_result($Lista_Torneos);
?>
