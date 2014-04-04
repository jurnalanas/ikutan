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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_explore_event = 5;
$pageNum_explore_event = 0;
if (isset($_GET['pageNum_explore_event'])) {
  $pageNum_explore_event = $_GET['pageNum_explore_event'];
}
$startRow_explore_event = $pageNum_explore_event * $maxRows_explore_event;

mysql_select_db($database_localserver, $localserver);
$query_explore_event = "SELECT * FROM events ORDER BY point DESC";
$query_limit_explore_event = sprintf("%s LIMIT %d, %d", $query_explore_event, $startRow_explore_event, $maxRows_explore_event);
$explore_event = mysql_query($query_limit_explore_event, $localserver) or die(mysql_error());
$row_explore_event = mysql_fetch_assoc($explore_event);

if (isset($_GET['totalRows_explore_event'])) {
  $totalRows_explore_event = $_GET['totalRows_explore_event'];
} else {
  $all_explore_event = mysql_query($query_explore_event);
  $totalRows_explore_event = mysql_num_rows($all_explore_event);
}
$totalPages_explore_event = ceil($totalRows_explore_event/$maxRows_explore_event)-1;

$queryString_explore_event = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_explore_event") == false && 
        stristr($param, "totalRows_explore_event") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_explore_event = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_explore_event = sprintf("&totalRows_explore_event=%d%s", $totalRows_explore_event, $queryString_explore_event);
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
				<a href="tambah_event.php" class="top-level">Tambah Event</a>
				
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
					<h1>Event2 Yang Terdaftar</h1>
					<p><a href="explore.php">Terbaru</a> | Trending | <a href="lokasi.php">Lokasi</a></p>
					
					<div class="empty-cart">
					  <p class="lead">Gak ada event yang kamu ikuti.</p>
						<p>Please <a href="index.php">kembali ke awal</a>.</p>
					</div>
					
					<form action="shopping-cart.php" method="post" class="shopping-cart">
						<table class="table table-striped">
							<tbody>
                             <tr>
						            <td class="img">No Event</td>
						            <td class="img">&nbsp;</td>
						            <td class="name">Nama</td>
						            <td class="size">Tanggal</td>
						            <td class="stock lowstock">Poin</td>
				              </tr>
							  <?php do { ?>
					         
					          <tr>
						        <td class="img"><?php echo $row_explore_event['idevent']; ?></td>
							      <td class="img"><img src="<?php echo $row_explore_event['img']; ?>" class="img  img-thumbnail" style="width: 47px;" alt=""></td>
							      <td class="name"><a href="eventitem.php?eventid=<?php echo $row_explore_event['idevent']; ?>"><?php echo $row_explore_event['nama']; ?></a></td>
							      <td class="size"><span class="size-small"></span><span class="size-large"><?php echo $row_explore_event['tanggal']; ?></span></td>
							      <td class="stock lowstock"><!--pake gambar aja, cuman udah ada captionnya-->
                                 <?php echo $row_explore_event['point']; ?> </td>
							      
					          </tr>
							    <?php } while ($row_explore_event = mysql_fetch_assoc($explore_event)); ?>
<!-- <tr class="cart-summary">
								<td colspan="5"></td>
								<td colspan="2" class="cart-total"><span class="currency">$</span><span class="total-total">60</span></td>
							</tr>	 -->
					    </tbody></table>
					</form>
                    <?php if ($pageNum_explore_event > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_explore_event=%d%s", $currentPage, max(0, $pageNum_explore_event - 1), $queryString_explore_event); ?>" class="btn btn-default">Sebelumnya</a>
                      <?php } // Show if not first page ?>
                    <?php if ($pageNum_explore_event < $totalPages_explore_event) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_explore_event=%d%s", $currentPage, min($totalPages_explore_event, $pageNum_explore_event + 1), $queryString_explore_event); ?>" class="btn btn-default">Selanjutnya</a>
  <?php } // Show if not last page ?>
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
mysql_free_result($explore_event);
?>
