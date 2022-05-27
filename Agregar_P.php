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
$T_HORA=$_POST['T_HORA'].":".$_POST['T_MINUTO'].":00";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO partidos (ID_EQUIPO_1, ID_EQUIPO_2, FECHA, CAMPO, HORA) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_EQUIPO_1'], "int"),
                       GetSQLValueString($_POST['ID_EQUIPO_2'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"),
                       GetSQLValueString($_POST['CAMPO'], "text"),
                       GetSQLValueString($T_HORA, "date"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($insertSQL, $Conexion) or die(mysql_error());

  $insertGoTo = "Agregar_P.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Equipos = "SELECT * FROM equipos, Torneos WHERE equipos.ID_TORNEO=torneos.ID_TORNEO ORDER BY NOM_TORNEO ASC, NUMERO ASC";
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

<title>Agregar Partidos</title>
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
  <h2 align="center"><strong>Registrar Partidos</strong></h2>
  <p><!-- Parrafo --></p>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td width="50%" align="right" nowrap><div align="right">EQUIPO 1:</div></td>
        <td width="50%"><select name="ID_EQUIPO_1">
          <?php
do {  
?>
          <option value="<?php echo $row_Lista_Equipos['ID_EQUIPO']?>"><?php echo $row_Lista_Equipos['NUMERO']." - ".$row_Lista_Equipos['NOM_EQUIPO']." - ".$row_Lista_Equipos['NOM_TORNEO']?></option>
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
        <td nowrap align="right"><div align="right">EQUIPO 2:</div></td>
        <td><select name="ID_EQUIPO_2">
          <?php
do {  
?>
          <option value="<?php echo $row_Lista_Equipos['ID_EQUIPO']?>"><?php echo $row_Lista_Equipos['NUMERO']." - ".$row_Lista_Equipos['NOM_EQUIPO']." - ".$row_Lista_Equipos['NOM_TORNEO']?></option>
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
        <td nowrap align="right"><div align="right">FECHA:</div></td>
        <td><!--<input type="text" name="FECHA" value="" size="32">-->
  			<input type="date" id="birthday" name="FECHA" value="">
        </td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">HORA:</div></td>
        <td><!--<input type="text" name="HORA" value="" size="32">-->
          <label for="T_HORA"></label>
          <select name="T_HORA" id="T_HORA">
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
          <label for="T_MINUTO"></label>
          <select name="T_MINUTO" id="T_MINUTO">
            <option value="00">00</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><div align="right">CAMPO:</div></td>
        <td><input type="text" name="CAMPO" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><button type="submit" class="w3-button w3-white w3-border w3-round-large">GUARDAR</button></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <p align="center">
    <a href="Equipos.php"><input type="submit" name="button" id="button" value="FINALIZAR" class="button button2"></a>
  </p>
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
mysql_free_result($Lista_Equipos);
?>
