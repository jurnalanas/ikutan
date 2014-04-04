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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

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

$user = $_SESSION['MM_Username'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO events (tanggal, tempat, nama, img, deskripsi, kategori) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['tempat'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['deskripsi'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"));

  mysql_select_db($database_localserver, $localserver);
  $Result1 = mysql_query($insertSQL, $localserver) or die(mysql_error());

  $insertGoTo = "explore.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>
<?php
mysql_select_db($database_localserver, $localserver);
$query_tempat = "SELECT * FROM tempat ORDER BY tempat ASC";
$tempat = mysql_query($query_tempat, $localserver) or die(mysql_error());
$row_tempat = mysql_fetch_assoc($tempat);
$totalRows_tempat = mysql_num_rows($tempat);

mysql_select_db($database_localserver, $localserver);
$query_kategori = "SELECT * FROM kategori";
$kategori = mysql_query($query_kategori, $localserver) or die(mysql_error());
$row_kategori = mysql_fetch_assoc($kategori);
$totalRows_kategori = mysql_num_rows($kategori);
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
  
  <a href="index.php/views/index.php?doLogout=true"><strong class="btn btn-success">Logout</strong></a>
 
  
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
					<h1>Buat Event Baru</h1>
					<p>&nbsp;</p>
                    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
                      <table align="center">
                        <tr valign="baseline">
                          <td nowrap align="right">Pembuat:</td>
                          <td><input type="text" name="pembuat" value="<?php echo $_SESSION['MM_Username']; ?>" size="32" disabled></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Tanggal:</td>
                          <td><input type="text" name="tanggal" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Tempat:</td>
                          <td>
                            <select name="tempat" id="tempat">
                              <?php
do {  
?>
                              <option value="<?php echo $row_tempat['tempat']?>"<?php if (!(strcmp($row_tempat['tempat'], $row_tempat['tempat']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tempat['nama_tempat']?></option>
                              <?php
} while ($row_tempat = mysql_fetch_assoc($tempat));
  $rows = mysql_num_rows($tempat);
  if($rows > 0) {
      mysql_data_seek($tempat, 0);
	  $row_tempat = mysql_fetch_assoc($tempat);
  }
?>
                          </select></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Nama Event:</td>
                          <td><input type="text" name="nama" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Kategori </td>
                          <td><select name="kategori" id="kategori">
                            <?php
do {  
?>
                            <option value="<?php echo $row_kategori['Kategori']?>"<?php if (!(strcmp($row_kategori['Kategori'], $row_kategori['Kategori']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kategori['Kategori']?></option>
                            <?php
} while ($row_kategori = mysql_fetch_assoc($kategori));
  $rows = mysql_num_rows($kategori);
  if($rows > 0) {
      mysql_data_seek($kategori, 0);
	  $row_kategori = mysql_fetch_assoc($kategori);
  }
?>
                          </select></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Url Gambar:</td>
                          <td><input type="text" name="img" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right" valign="top">Deskripsi:</td>
                          <td><textarea name="deskripsi" cols="50" rows="5"></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">&nbsp;</td>
                          <td><input type="submit" class="btn btn-atc" value="Buat Event"></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_insert" value="form1">
                  </form>
                    <p>&nbsp;</p>
<div class="empty-cart">
					  <p class="lead">Gak ada event yang kamu ikuti.</p>
						<p>Please <a href="index.php">kembali ke awal</a>.</p>
					</div>
					
					
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
mysql_free_result($tempat);

mysql_free_result($kategori);
?>
