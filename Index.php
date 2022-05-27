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
/*
mysql_select_db($database_Conexion, $Conexion);
$query_Posiciones = "SELECT equipos.NOM_EQUIPO, equipos.PJ, equipos.PG, equipos.PE, equipos.PP, equipos.GF, equipos.GC, equipos.DIF, equipos.PUNTOS  FROM equipos  ORDER BY equipos.PUNTOS desc, equipos.DIF desc";
$Posiciones = mysql_query($query_Posiciones, $Conexion) or die(mysql_error());
$row_Posiciones = mysql_fetch_assoc($Posiciones);
$totalRows_Posiciones = mysql_num_rows($Posiciones);
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
<title>Posiciones</title>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php" class="active">POSICIONES</a>
  <a href="Partidos.php">PARTIDOS</a>
  <a href="Anuncios.php">ANUNCIOS</a>
  <a href="entrar.php" title="Panel de Administracion"><i style='font-size:20px' class='fa fa-gears'></i></a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<div>
  <p><!-- Parrafo --></p>
  
    <?php do { 	
	$torneo=$row_Lista_Torneos['ID_TORNEO'];/*Selecccionar Torneo*/
	mysql_select_db($database_Conexion, $Conexion);
	$query_Posiciones = "SELECT * FROM equipos, torneos where equipos.ID_TORNEO='$torneo' and equipos.ID_TORNEO= torneos.ID_TORNEO ORDER BY equipos.PUNTOS desc, equipos.DIF desc";
	$Posiciones = mysql_query($query_Posiciones, $Conexion) or die(mysql_error());
	$row_Posiciones = mysql_fetch_assoc($Posiciones);
	$totalRows_Posiciones = mysql_num_rows($Posiciones);
	
	/*Validar que el Torneo tenga equipos*/
	if($totalRows_Posiciones>0){  ?>
	<h2 align="center"> <strong>Torneo <?php echo $row_Lista_Torneos['NOM_TORNEO']."<br>"; ?></strong></h2>
  
  <table border="1" width="95%">
    <tr>
      <td width="2%"><strong>N°</strong></td>
      <td width="17%"><strong>EQUIPO</strong></td>
      <td width="10%"><strong>PJ</strong></td>
      <td width="10%"><strong>PG</strong></td>
      <td width="10%"><strong>PE</strong></td>
      <td width="10%"><strong>PP</strong></td>
      <td width="10%"><strong>GF</strong></td>
      <td width="10%"><strong>GC</strong></td>
      <td width="10%"><strong>DIF</strong></td>
      <td width="11%"><strong>PUNTOS</strong></td>
    </tr>
    <?php
	$lugar=1; 
	 do { ?>
      <tr>
        <td>
          <?php 
		  echo $lugar;
		  $lugar++;
		  ?>
        </td>
        <td><?php echo $row_Posiciones['NOM_EQUIPO']; ?></td>
        <td><?php echo $row_Posiciones['PJ']; ?></td>
        <td><?php echo $row_Posiciones['PG']; ?></td>
        <td><?php echo $row_Posiciones['PE']; ?></td>
        <td><?php echo $row_Posiciones['PP']; ?></td>
        <td><?php echo $row_Posiciones['GF']; ?></td>
        <td><?php echo $row_Posiciones['GC']; ?></td>
        <td><?php echo $row_Posiciones['DIF']; ?></td>
        <td><?php echo $row_Posiciones['PUNTOS']; ?></td>
      </tr>
      <?php } while ($row_Posiciones = mysql_fetch_assoc($Posiciones)); ?>
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
mysql_free_result($Posiciones);

mysql_free_result($Lista_Torneos);
?>
