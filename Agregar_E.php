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
  $insertSQL = sprintf("INSERT INTO equipos (NUMERO, NOM_EQUIPO, DT_EQUIPO, ORIGEN_EQUIPO, ID_TORNEO) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NUMERO'], "int"),
                       GetSQLValueString($_POST['NOM_EQUIPO'], "text"),
                       GetSQLValueString($_POST['DT_EQUIPO'], "text"),
                       GetSQLValueString($_POST['ORIGEN_EQUIPO'], "text"),
                       GetSQLValueString($_POST['ID_TORNEO'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($insertSQL, $Conexion) or die(mysql_error());

  $insertGoTo = "Agregar_E.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Torneos = "SELECT * FROM torneos order by Nom_torneo";
$Lista_Torneos = mysql_query($query_Lista_Torneos, $Conexion) or die(mysql_error());
$row_Lista_Torneos = mysql_fetch_assoc($Lista_Torneos);
$totalRows_Lista_Torneos = mysql_num_rows($Lista_Torneos);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<meta http-equiv="content-type" content="text/html; utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<LINK REL=StyleSheet HREF="Styles.css" TYPE="text/css" MEDIA=screen>
<title>Agregar Equipos</title>
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
  <h2 align="center"><strong>Registrar Equipo</strong></h2>
  <p><!-- Parrafo --></p>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td width="50%" align="right" nowrap><div align="right">NUMERO:</div></td>
        <td width="50%"><input type="text" name="NUMERO" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">NOMBRE DEL EQUIPO:</div></td>
        <td><input type="text" name="NOM_EQUIPO" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">DT DEL EQUIPO:</div></td>
        <td><input type="text" name="DT_EQUIPO" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">ORIGEN DEL EQUIPO:</div></td>
        <td><input type="text" name="ORIGEN_EQUIPO" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">TORNEO:</div></td>
        <td><select name="ID_TORNEO">
          <?php 
do {  
?>
          <option value="<?php echo $row_Lista_Torneos['ID_TORNEO']?>" ><?php echo $row_Lista_Torneos['NOM_TORNEO']?></option>
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
    <div align="center">
      <input type="hidden" name="MM_insert" value="form1">
      <a href="Equipos.php"><input value="FINALIZAR" class="button button2"></a>
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
mysql_free_result($Lista_Torneos);
?>
