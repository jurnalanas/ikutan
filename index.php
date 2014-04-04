<?php require_once('Connections/localserver.php'); ?>
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

$maxRows_terbaru = 2;
$pageNum_terbaru = 0;
if (isset($_GET['pageNum_terbaru'])) {
  $pageNum_terbaru = $_GET['pageNum_terbaru'];
}
$startRow_terbaru = $pageNum_terbaru * $maxRows_terbaru;

mysql_select_db($database_localserver, $localserver);
$query_terbaru = "SELECT * FROM events ORDER BY idevent DESC";
$query_limit_terbaru = sprintf("%s LIMIT %d, %d", $query_terbaru, $startRow_terbaru, $maxRows_terbaru);
$terbaru = mysql_query($query_limit_terbaru, $localserver) or die(mysql_error());
$row_terbaru = mysql_fetch_assoc($terbaru);

if (isset($_GET['totalRows_terbaru'])) {
  $totalRows_terbaru = $_GET['totalRows_terbaru'];
} else {
  $all_terbaru = mysql_query($query_terbaru);
  $totalRows_terbaru = mysql_num_rows($all_terbaru);
}
$totalPages_terbaru = ceil($totalRows_terbaru/$maxRows_terbaru)-1;

//initialize the session

?>
<?php
$maxRows_terlama = 7;
$pageNum_terlama = 0;
if (isset($_GET['pageNum_terlama'])) {
  $pageNum_terlama = $_GET['pageNum_terlama'];
}
$startRow_terlama = $pageNum_terlama * $maxRows_terlama;

mysql_select_db($database_localserver, $localserver);
$query_terlama = "SELECT * FROM events ORDER BY idevent ASC";
$query_limit_terlama = sprintf("%s LIMIT %d, %d", $query_terlama, $startRow_terlama, $maxRows_terlama);
$terlama = mysql_query($query_limit_terlama, $localserver) or die(mysql_error());
$row_terlama = mysql_fetch_assoc($terlama);

if (isset($_GET['totalRows_terlama'])) {
  $totalRows_terlama = $_GET['totalRows_terlama'];
} else {
  $all_terlama = mysql_query($query_terlama);
  $totalRows_terlama = mysql_num_rows($all_terlama);
}
$totalPages_terlama = ceil($totalRows_terlama/$maxRows_terlama)-1;

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
?>
<!DOCTYPE html>
<html class=" js no-touch" style="" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Ikutan</title>

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="asset/bootstrap.css" rel="stylesheet">
<link href="asset/shopfrog.css" rel="stylesheet" media="screen">   

<link href="asset/shopfrog-brown.css" rel="stylesheet" media="screen">

<link href="asset/rateit.css" rel="stylesheet" media="screen">		       
<link href="asset/magnific-popup.css" rel="stylesheet"> 		
<script src="asset/respond.js"></script>
 <link rel="shortcut icon" href="views/img/kaoskece.png">
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
<body class="product-board">
	
	<header class="navbar navbar-fixed-top clearfix">
		
	<a class="current brand" href="index.php">Ikutan</a>

	<div id="nav-basket" class="basket">
		
			<div id="nav-basket" class="basket">
		<div class="btn-group" style="margin-top: 14px;">
        <a href="signin.php" class="basket-link"  style="height: 0px;">
   <a href="signin.php" class="btn btn-default">Login</a>
  <a href="register.php" class="btn btn-default">Register</a>
 
  
</div>
		
	</div>
		</a>
		
	</div>
	
	<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<nav class="navbar-collapse collapse" id="main-nav">
		<ul class="nav">
			<li class="current active">
				<a href="index.php" class="current top-level flat">Home</a>
			</li>
			<li>
				<a href="views/explore.php" class="top-level">Explore</a>
				
			</li>
             <li>
				<a href="views/tambah_event.php" class="top-level">Tambah Event</a>
				
			</li>
			 <li>
				<a href="views/eventsaya.php" class="top-level">Event Saya</a>
				
			</li>
			<li>
				<!-- <a href="http://leapfrogui.com/shopfrog/brown/collection.html" class="top-level">Lingerie</a> -->
				
			</li>	
			<!-- <li><a href="http://leapfrogui.com/shopfrog/brown/collection.html" class="top-level flat">Accessories</a></li>								 -->
		</ul>
	</nav><!--/.nav-collapse -->
	
</header>


	
	<div style="position: relative; height: 1700px;" id="product-board" class="clearfix">

		<!--
			Products
			--------
			Each item on the product board is identified by the 'product' class.
			There are two size variations, identified by the classes 'medium' or 'large'.
			
			Details expansion:
			The details expansion is operated by an id. 
			The 'details-extra' div has an id, eg: 'details-0001'
			This is paired with the anchor tag with class 'details-expand' which has a matching data-target of that id.
		-->
	
		<div style="position: absolute; left: 0px; top: 0px;" class="product large cta">
			<div class="content">
				<h3>Mau Gabung di Event2 Keren?!</h3>
				<p>Kamu bisa gabung ke event2 keren yang udah ada atau buat sendiri event-mu..</p>
			</div>
			<a href="views/explore.php" class="btn btn-bottom">Browse all events →</a>	
		</div>
	
		<?php do { ?>
	    <div style="position: absolute; left: 400px; top: 0px;" class="product large">
		    <div class="media">
		      <a href="views/eventitem.php?eventid=<?php echo $row_terbaru['idevent']; ?>" title="product title">
		        <img src="views/<?php echo $row_terbaru['img']; ?>" alt="product title" data-img="product-1" class="img-responsive">
	          </a>
              <?php if ($pageNum_terbaru == 0) { // Show if first page ?>
  <span class="plabel">event baru</span>
  <?php } // Show if first page ?>
            </div>
		    <div class="details">
		      <p class="name"><a href="views/eventitem.php?eventid=<?php echo $row_terbaru['idevent']; ?>"><?php echo $row_terbaru['nama']; ?></a></p>
		      <a href="" class="details-expand" data-target="details-0001">+</a>
		      </div>
		    <div class="details-extra" id="details-0001">
		      
		      <a href="views/eventitem.php?eventid=<?php echo $row_terbaru['idevent']; ?>" class="btn btn-bottom btn-atc qadd">Lihat Event</a>			
		      </div>
	      </div>
		  <?php } while ($row_terbaru = mysql_fetch_assoc($terbaru)); ?>
        <?php do { ?>
	    <div style="position: absolute; left: 1000px; top: 350px;" class="product medium">
		      <div class="media">
		        <a href="views/eventitem.php?eventid=<?php echo $row_terlama['idevent']; ?>" title="<?php echo $row_terlama['deskripsi']; ?>">
		          <img src="views/<?php echo $row_terlama['img']; ?>" alt="product title" data-img="product-1" class="img-responsive">
	            </a>
		        </div>
		      <div class="details">
		        <p class="name"><a href="views/eventitem.php?eventid=<?php echo $row_terlama['idevent']; ?>"><?php echo $row_terlama['nama']; ?></a></p>
		        <a href="" class="details-expand" data-target="details-0005">+</a>
		        </div>
		      <div class="details-extra" id="details-0005">
		        
		        <a href="views/eventitem.php?eventid=<?php echo $row_terlama['idevent']; ?>" class="btn btn-bottom btn-atc qadd">Lihat Event</a>			
		        </div>			
	        </div>
		    <?php } while ($row_terlama = mysql_fetch_assoc($terlama)); ?>

	
		
	    
    <!-- <div style="position: absolute; left: 0px; top: 832px;" class="product medium cta alt">
			<a href="http://leapfrogui.com/shopfrog/brown/collection.html">
				<div class="content">
					<p class="poff">20% <br> off!</p>
					<p>All accessories →</p>
				</div>
			</a>
		</div> --><!-- <div style="position: absolute; left: 200px; top: 1182px;" class="product medium cta">
			<a href="">
				<div class="content">
					<p class="poff">Like <br> us!</p>
					<p>on facebook →</p>
				</div>
			</a>
		</div>	 --></div> <!-- //end product-board -->
	
	<footer>
	<div class="container">
		
	</div>
</footer>
	

</body></html>