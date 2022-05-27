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

mysql_select_db($database_Conexion, $Conexion);
$query_Partidos = "SELECT E1.NOM_EQUIPO AS EQUIPO1, E2.NOM_EQUIPO AS EQUIPO2, date_format(P.FECHA, '%d-%m-%Y') AS FECHA, P.CAMPO AS CAMPO, date_format(P.HORA , '%H:%i')AS HORA, E1.ID_TORNEO, T.NOM_TORNEO, T. ID_TORNEO FROM equipos as E1, equipos as E2, PARTIDOS as P , TORNEOS AS T WHERE P.ID_EQUIPO_1=E1.ID_EQUIPO AND P.ID_EQUIPO_2=E2.ID_EQUIPO AND P.FECHA>=curdate() AND E1.ID_TORNEO=T.ID_TORNEO ORDER BY P.FECHA ASC, P. HORA ASC";
$Partidos = mysql_query($query_Partidos, $Conexion) or die(mysql_error());
$row_Partidos = mysql_fetch_assoc($Partidos);
$totalRows_Partidos = mysql_num_rows($Partidos);
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
<title>Partidos</title>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php">POSICIONES</a>
  <a href="Partidos.php" class="active">PARTIDOS</a>
  <a href="Anuncios.php">ANUNCIOS</a>
  <a href="entrar.php" title="Panel de Administracion"><i style='font-size:20px' class='fa fa-gears'></i></a> 
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<?php if($totalRows_Partidos>0) { ?>
<div>
  <h2 align="center"><strong>Proximas Jornadas</strong></h2>
  <p><!-- Parrafo --></p>
  <table border="1">
    <tr>
      <td width="20%"><strong>EQUIPO 1</strong></td>
      <td width="4%">&nbsp;</td>
      <td width="20%"><div align="right"><strong>EQUIPO 2</strong></div></td>
      <td width="13%"><div align="center"><strong>TORNEO</strong></div></td>
      <td width="13%"><div align="center"><strong>FECHA</strong></div></td>
      <td width="12%"><div align="center"><strong>HORA</strong></div></td>
      <td width="18%"><div align="center"><strong>CAMPO</strong></div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_Partidos['EQUIPO1']; ?></td>
        <td><div align="center">VS</div></td>
        <td><div align="right"><?php echo $row_Partidos['EQUIPO2']; ?></div></td>
        <td><div align="center"><?php echo $row_Partidos['NOM_TORNEO']; ?></div></td>
        <td><div align="center"><?php echo $row_Partidos['FECHA']; ?></div></td>
        <td><div align="center"><?php echo $row_Partidos['HORA']; ?></div></td>
        <td><div align="center"><?php echo $row_Partidos['CAMPO']; ?></div></td>
      </tr>
      <?php } while ($row_Partidos = mysql_fetch_assoc($Partidos)); ?>
  </table>
</div>
<?php } else{ ?> 
<h2 align="center"><strong>No hay Partidos Registrados Por el momento</strong></h2>
<h3 align="center"><strong>Consulta Nuevamente mas Tarde</strong></h3>
<?php } ?>
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
mysql_free_result($Partidos);
?>
