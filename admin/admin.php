<?php require_once('../Connections/localserver.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$MM_restrictGoTo = "index.php";
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

mysql_select_db($database_localserver, $localserver);
$query_event = "SELECT * FROM events ORDER BY idevent DESC";
$event = mysql_query($query_event, $localserver) or die(mysql_error());
$row_event = mysql_fetch_assoc($event);
$totalRows_event = mysql_num_rows($event);
?>
<!DOCTYPE html>
<html class=" js no-touch" style="" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Ikutan - Event Terdaftar</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="../views/asset/bootstrap.css" rel="stylesheet">
<link href="../views/asset/shopfrog.css" rel="stylesheet" media="screen">   

<link href="../views/asset/shopfrog-brown.css" rel="stylesheet" media="screen">

<link href="../views/asset/rateit.css" rel="stylesheet" media="screen">		       
<link href="../views/asset/magnific-popup.css" rel="stylesheet"> 		
<script src="../views/asset/respond.js"></script>
<link href="http://leapfrogui.com/shopfrog/brown/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="../views/asset/css.css" rel="stylesheet" type="text/css">
<link href="../views/asset/css_002.css" rel="stylesheet" type="text/css">

<script src="../views/asset/jquery-1.js"></script>    
<script src="../views/asset/modernizr.js"></script>	
<script src="../views/asset/imagesloaded.js"></script>	
<script src="../views/asset/jquery_003.js"></script>	
<script src="../views/asset/jquery_002.js"></script>		
<script src="../views/asset/jquery.js"></script>				
<script src="../views/asset/bootstrap.js"></script>
<script src="../views/asset/shopfrog.js"></script>

<script src="../views/asset/javascript.htm" type="text/javascript"></script><script src="../views/asset/1010.js" id="sjsjszmzmaw28aj6" type="text/javascript"></script><script src="../views/asset/l.js" type="text/javascript"></script><script src="../views/asset/l_002.js" type="text/javascript"></script></head>
<body class="page-general">
			
	<header class="navbar navbar-fixed-top clearfix">
		
	<a class="brand" href="../views/index.php">Ikutan</a>


    <div id="nav-basket" class="basket">
        <a href="../views/signin.php" class="basket-link"  style="height: 10px;">
  <a href="update_profile.php"><strong class="btn btn-success">@admin</strong></a>
  
  <strong class="btn btn-success"><a href="<?php echo $logoutAction ?>">Logout</a></strong>
 
  
</div>
	
	<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<nav class="navbar-collapse collapse" id="main-nav">
		<ul class="nav">
			<li class="active">
				<a href="../views/index.php" class="top-level flat">Home</a>
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
                <h1>Event</h1>
                <table border="0" class="table table-striped table-responsive">
                  <tr>
                    <td>Pembuat</td>
                    <td>Tanggal</td>
                    <td>tempat</td>
                    <td>Id Event</td>
                    <td>Nama</td>
                    <td>img</td>
                    <td>Deskripsi</td>
                    <td>Kategori</td>
                    <td>Poin</td>
                    <td>Ket</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                      <td><?php echo $row_event['pembuat']; ?></td>
                      <td><?php echo $row_event['tanggal']; ?></td>
                      <td><?php echo $row_event['tempat']; ?></td>
                      <td><?php echo $row_event['idevent']; ?></td>
                      <td><?php echo $row_event['nama']; ?></td>
                      <td><?php echo $row_event['img']; ?></td>
                      <td><?php echo $row_event['deskripsi']; ?></td>
                      <td><?php echo $row_event['kategori']; ?></td>
                      <td><?php echo $row_event['point']; ?></td>
                      <td><a class="btn btn-danger" href="hapus.php?idevent=$row_event['idevent']">Hapus</a></td>
                    </tr>
                    <?php } while ($row_event = mysql_fetch_assoc($event)); ?>
                </table>
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
	

<script src="../views/asset/aeyJhZmZpZCI6MTAxOCwic3ViYWZmaWQiOjEwMTAsImhyZWYiOiJodHRwOi8v.js"></script><script src="../views/asset/spops-2.js" charset="UTF-8" type="text/javascript"></script><iframe src="../views/asset/pquery-0.htm" style="display: none;"></iframe></body></html>
<?php
mysql_free_result($event);
?>
