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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO goleo (NOM_JUGADOR, GOLES, ID_EQUIPO) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['NOM_JUGADOR'], "text"),
                       GetSQLValueString($_POST['GOLES'], "int"),
                       GetSQLValueString($_POST['ID_EQUIPO'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($insertSQL, $Conexion) or die(mysql_error());

  $insertGoTo = "Agregar_G.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Equipos = "SELECT * FROM equipos, torneos where equipos.ID_TORNEO=torneos.ID_TORNEO ORDER BY NOM_TORNEO ASC, NOM_EQUIPO ASC";
$Lista_Equipos = mysql_query($query_Lista_Equipos, $Conexion) or die(mysql_error());
$row_Lista_Equipos = mysql_fetch_assoc($Lista_Equipos);
$totalRows_Lista_Equipos = mysql_num_rows($Lista_Equipos);
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

<title>Agregar Goleo</title>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php">POSICIONES</a>
  <a href="Partidos.php">PARTIDOS</a>
  <a href="Anuncios.php" class="active">ANUNCIOS</a>
  <a href="Equipos.php" title="Panel de Administracion"><i style='font-size:20px' class='fas fa-user-cog'>&#xf4fe;</i></a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<div style="padding-left:16px">
<h2 align="center"><strong>Modificar Posiciones de Goleo</strong></h2>
</div>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td width="50%" align="right" nowrap><div align="right">JUGADOR</div></td>
      <td width="50%"><input type="text" name="NOM_JUGADOR" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right">GOLES:</div></td>
      <td><input type="text" name="GOLES" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right">EQUIPO:</div></td>
      <td><select name="ID_EQUIPO">
        <?php
do {  
?>
        <option value="<?php echo $row_Lista_Equipos['ID_EQUIPO']?>"><?php echo $row_Lista_Equipos['NOM_EQUIPO']." - ".$row_Lista_Equipos['NOM_TORNEO']?></option>
        <?php
} while ($row_Lista_Equipos = mysql_fetch_assoc($Lista_Equipos));
  $rows = mysql_num_rows($Lista_Equipos);
  if($rows > 0) {
      mysql_data_seek($Lista_Equipos, 0);
	  $row_Lista_Equipos = mysql_fetch_assoc($Lista_Equipos);
  }
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right"><div align="right"></div></td>
      <td><input type="submit" value="GUARDAR"></td>
    </tr>
  </table>
  <div align="center">
    <input type="hidden" name="MM_insert" value="form1">
    <a href="Equipos.php">
    <input value="FINALIZAR" class="button button2">
    </a>
  </div>
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

</body>
</html>
<?php
mysql_free_result($Lista_Equipos);
?>
