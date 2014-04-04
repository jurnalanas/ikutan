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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `admin` SET nama=%s, email=%s, password=%s, nohp=%s WHERE adminId=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['nohp'], "text"),
                       GetSQLValueString($_POST['adminId'], "int"));

  mysql_select_db($database_localserver, $localserver);
  $Result1 = mysql_query($updateSQL, $localserver) or die(mysql_error());

  $updateGoTo = "user.php?user=" . $_SESSION['MM_Username'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_profile = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_profile = $_SESSION['MM_Username'];
}
mysql_select_db($database_localserver, $localserver);
$query_profile = sprintf("SELECT * FROM `admin` WHERE userName = %s", GetSQLValueString($colname_profile, "text"));
$profile = mysql_query($query_profile, $localserver) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);
$totalRows_profile = mysql_num_rows($profile);
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
                <h1>Update Profile</h1>
                  
                  
                 
                  <p>&nbsp;</p>
                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                    <table align="center">
                      <tr valign="baseline">
                        <td nowrap align="right">Nama :</td>
                        <td><input type="text" name="nama" value="<?php echo htmlentities($row_profile['nama'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Email:</td>
                        <td><input type="text" name="email" value="<?php echo htmlentities($row_profile['email'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Password:</td>
                        <td><input type="text" name="password" value="<?php echo htmlentities($row_profile['password'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">No HP:</td>
                        <td><input type="text" name="nohp" value="<?php echo htmlentities($row_profile['nohp'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input type="submit" class="btn btn-default" value="Update Profile"></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="adminId" value="<?php echo $row_profile['adminId']; ?>">
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
<?php
mysql_free_result($profile);
?>
