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
<link rel="shortcut icon" href="img/kaoskece.png">
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
					<h1>Event2 Yang Kamu Ikuti</h1>
					<p>&nbsp;</p>
					
					<div class="empty-cart">
					  <p class="lead">Gak ada event yang kamu ikuti.</p>
						<p>Please <a href="index.php">return to the shop</a>.</p>
					</div>
					
					<form action="shopping-cart.php" method="post" class="shopping-cart">
						<table class="table table-striped">
							<tbody>
							<tr>
								<td class="img"><a href="index.php/views/eventitem.php">Kamu belum menambahkan event.</a></td>
							  </tr>					
							<!-- <tr class="cart-summary">
								<td colspan="5"></td>
								<td colspan="2" class="cart-total"><span class="currency">$</span><span class="total-total">60</span></td>
							</tr>	 -->
					    </tbody></table>
					</form>
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