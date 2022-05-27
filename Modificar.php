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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE equipos SET NOM_EQUIPO=%s, DT_EQUIPO=%s, ORIGEN_EQUIPO=%s, ID_TORNEO=%s WHERE ID_EQUIPO=%s",
                       GetSQLValueString($_POST['NOM_EQUIPO'], "text"),
                       GetSQLValueString($_POST['DT_EQUIPO'], "text"),
                       GetSQLValueString($_POST['ORIGEN_EQUIPO'], "text"),
                       GetSQLValueString($_POST['ID_TORNEO'], "int"),
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

mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Torneos = "SELECT torneos.ID_TORNEO, torneos.NOM_TORNEO FROM torneos";
$Lista_Torneos = mysql_query($query_Lista_Torneos, $Conexion) or die(mysql_error());
$row_Lista_Torneos = mysql_fetch_assoc($Lista_Torneos);
$totalRows_Lista_Torneos = mysql_num_rows($Lista_Torneos);

$colname_Lista_Equipos = "-1";
if (isset($_GET['modificar'])) {
  $colname_Lista_Equipos = $_GET['modificar'];
}
mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Equipos = sprintf("SELECT * FROM equipos WHERE ID_EQUIPO = %s", GetSQLValueString($colname_Lista_Equipos, "int"));
$Lista_Equipos = mysql_query($query_Lista_Equipos, $Conexion) or die(mysql_error());
$row_Lista_Equipos = mysql_fetch_assoc($Lista_Equipos);
$totalRows_Lista_Equipos = mysql_num_rows($Lista_Equipos);
?>
<!DOCTYPE html>
<html>
<head>
<<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<meta http-equiv="content-type" content="text/html; utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<LINK REL=StyleSheet HREF="Styles.css" TYPE="text/css" MEDIA=screen>
<title>Modificar Equipos</title>
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

<h2 align="center"><strong>Modificar Equipo</strong></h2>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td width="50%" align="right" nowrap><div align="right">NOMBRE DEL EQUIPO:</div></td>
      <td width="50%"><input type="text" name="NOM_EQUIPO" value="<?php echo htmlentities($row_Lista_Equipos['NOM_EQUIPO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right">DT DEL EQUIPO</div></td>
      <td><input type="text" name="DT_EQUIPO" value="<?php echo htmlentities($row_Lista_Equipos['DT_EQUIPO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right">ORIGEN DEL EQUIPO:</div></td>
      <td><input type="text" name="ORIGEN_EQUIPO" value="<?php echo htmlentities($row_Lista_Equipos['ORIGEN_EQUIPO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right">TORNEO AL QUE PERTENECE:</div></td>
      <td><select name="ID_TORNEO">
        <?php 
do {  
?>
        <option value="<?php echo $row_Lista_Torneos['ID_TORNEO']?>" <?php if (!(strcmp($row_Lista_Torneos['ID_TORNEO'], htmlentities($row_Lista_Equipos['ID_TORNEO'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_Lista_Torneos['NOM_TORNEO']?></option>
        <?php
} while ($row_Lista_Torneos = mysql_fetch_assoc($Lista_Torneos));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right"></div></td>
      <td><input type="submit" value="GUARDAR"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="ID_EQUIPO" value="<?php echo $row_Lista_Equipos['ID_EQUIPO']; ?>">
</form>
<p>&nbsp;</p>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Lista_Torneos);

mysql_free_result($Lista_Equipos);
?>
