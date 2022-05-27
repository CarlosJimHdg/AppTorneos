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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$T_PUNTOS=(($_POST['PG']*3)+$_POST['PE']);
$DG=($_POST['GF']-$_POST['GC']);
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE equipos SET PJ=%s, PG=%s, PE=%s, PP=%s, GF=%s, GC=%s, DIF=%s, PUNTOS=%s WHERE ID_EQUIPO=%s",
                       GetSQLValueString($_POST['PJ'], "int"),
                       GetSQLValueString($_POST['PG'], "int"),
                       GetSQLValueString($_POST['PE'], "int"),
                       GetSQLValueString($_POST['PP'], "int"),
                       GetSQLValueString($_POST['GF'], "int"),
                       GetSQLValueString($_POST['GC'], "int"),
					   GetSQLValueString($DG, "int"),
                       GetSQLValueString($T_PUNTOS, "int"),
                       GetSQLValueString($_POST['ID_EQUIPO'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($updateSQL, $Conexion) or die(mysql_error());

  $updateGoTo = "Equipos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Estadisticas = "-1";
if (isset($_GET['estadistica'])) {
  $colname_Estadisticas = $_GET['estadistica'];
}
mysql_select_db($database_Conexion, $Conexion);
$query_Estadisticas = sprintf("SELECT * FROM equipos WHERE ID_EQUIPO = %s", GetSQLValueString($colname_Estadisticas, "int"));
$Estadisticas = mysql_query($query_Estadisticas, $Conexion) or die(mysql_error());
$row_Estadisticas = mysql_fetch_assoc($Estadisticas);
$totalRows_Estadisticas = mysql_num_rows($Estadisticas);
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

<title>Inicio</title>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php">POSICIONES</a>
  <a href="Partidos.php">PARTIDOS</a>
  <a href="Anuncios.php">ANUNCIOS</a>
  <a href="Equipos.php" title="Panel de Administracion"><i style='font-size:20px' class='fas fa-user-cog'></i></a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<div>
  <h2 align="center"><strong>Estadisticas del Equipo</strong></h2>
  <p><!-- Parrafo --></p>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td width="50%" align="right" nowrap><div align="right">EQUIPO:</div></td>
        <td width="50%"><?php echo htmlentities($row_Estadisticas['NOM_EQUIPO'], ENT_COMPAT, ''); ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">PARTIDOS JUGADOS:</div></td>
        <td><input type="text" name="PJ" value="<?php echo htmlentities($row_Estadisticas['PJ'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">PARTIDOS GANADOS:</div></td>
        <td><input type="text" name="PG" value="<?php echo htmlentities($row_Estadisticas['PG'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">PARTIDOS EMPATADOS</div></td>
        <td><input type="text" name="PE" value="<?php echo htmlentities($row_Estadisticas['PE'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">PARTIDOS PERDIDOS:</div></td>
        <td><input type="text" name="PP" value="<?php echo htmlentities($row_Estadisticas['PP'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">GOLES A FAVOR:</div></td>
        <td><input type="text" name="GF" value="<?php echo htmlentities($row_Estadisticas['GF'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">GOLES EN CONTRA:</div></td>
        <td><input type="text" name="GC" value="<?php echo htmlentities($row_Estadisticas['GC'], ENT_COMPAT, ''); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right"></div></td>
        <td><button type="submit" class="w3-button w3-white w3-border w3-round-large">GUARDAR</button></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="ID_EQUIPO" value="<?php echo $row_Estadisticas['ID_EQUIPO']; ?>">
  </form>
  <p>&nbsp;</p>
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
mysql_free_result($Estadisticas);
?>
