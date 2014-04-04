<?php require_once('../Connections/localserver.php'); ?>
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

if ((isset($_GET['noikut'])) && ($_GET['noikut'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ikutevent WHERE noikut=%s",
                       GetSQLValueString($_GET['noikut'], "int"));

  mysql_select_db($database_localserver, $localserver);
  $Result1 = mysql_query($deleteSQL, $localserver) or die(mysql_error());

  $deleteGoTo = "eventsaya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_localserver, $localserver);
$query_ikutevent = "SELECT * FROM ikutevent";
$ikutevent = mysql_query($query_ikutevent, $localserver) or die(mysql_error());
$row_ikutevent = mysql_fetch_assoc($ikutevent);
$totalRows_ikutevent = mysql_num_rows($ikutevent);

mysql_free_result($ikutevent);
?>
