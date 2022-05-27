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
$query_Lista_Avisos = "SELECT * FROM avisos where FECHA_VIGENCIA>=curdate() ORDER BY FECHA_VIGENCIA ASC";
$Lista_Avisos = mysql_query($query_Lista_Avisos, $Conexion) or die(mysql_error());
$row_Lista_Avisos = mysql_fetch_assoc($Lista_Avisos);
$totalRows_Lista_Avisos = mysql_num_rows($Lista_Avisos);
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

<title>Anuncios</title>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="Index.php">POSICIONES</a>
  <a href="Partidos.php">PARTIDOS</a>
  <a href="Anuncios.php" class="active">ANUNCIOS</a>
  <a href="entrar.php" title="Panel de Administracion"><i style='font-size:20px' class='fa fa-gears'></i></a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<?php if($totalRows_Lista_Avisos>0) { ?>
<div>
<h2 align="center"><strong>Anuncios del Torneo</strong></h2>

 
<table width="15%" border="0">
  <?php do { ?>
  <tr>
      <td width="30%"><div align="right">
        <h4><strong><?php echo $row_Lista_Avisos['TITULO']; ?></strong></h4>
      </div></td>
      <td width="70%"><?php echo $row_Lista_Avisos['DESCRIPCION']; ?></td>      
  </tr>
  <?php } while ($row_Lista_Avisos = mysql_fetch_assoc($Lista_Avisos)); ?>
</table>

</div>
<?php } else{ ?> 
<h2 align="center"><strong>No hay Anuncios Registrados Por el momento</strong></h2>
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
mysql_free_result($Lista_Avisos);
?>
