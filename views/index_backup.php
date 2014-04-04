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

<!DOCTYPE html>
<html class=" js no-touch" style="" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Ikutan</title>

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
<body class="product-board">
	
	<header class="navbar navbar-fixed-top clearfix">
		
	<a class="current brand" href="index.php">Ikutan</a>

	<div id="nav-basket" class="basket">
		
			<div id="nav-basket" class="basket">
		<div class="btn-group" style="margin-top: 14px;">
        <a href="signin.php" class="basket-link"  style="height: 0px;">
  <a href="update_profile.php"><strong class="btn btn-success">@ <?php echo $_SESSION['MM_Username']; ?></strong></a>
  
<a href="<?php echo $logoutAction ?>"><strong class="btn btn-success">Logout</strong></a>
 
  
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
				<a href="explore.php" class="top-level">Explore</a>
				
			</li>
             <li>
				<a href="tambah_event.php" class="top-level">Tambah Event</a>
				
			</li>
			 <li>
				<a href="eventitem2.php" class="top-level">Event Saya</a>
				
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
			<a href="http://leapfrogui.com/shopfrog/brown/collection.html" class="btn btn-bottom">Browse all events →</a>	
		</div>
	
		<div style="position: absolute; left: 400px; top: 0px;" class="product large">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
				<span class="plabel">event baru</span>				
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Lari Pagi Sekampung Yok</a></p>
				<a href="" class="details-expand" data-target="details-0001">+</a>
			</div>
			<div class="details-extra" id="details-0001">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>
		</div>
		
		<div style="position: absolute; left: 800px; top: 0px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
				<span class="plabel">baru</span>				
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-0002">+</a>
			</div>
			<div class="details-extra" id="details-0002">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>
		</div>
		
		<div style="position: absolute; left: 0px; top: 182px;" class="product large">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem.php">Wacana 8</a></p>
				<a href="" class="details-expand" data-target="details-0003">+</a>
			</div>
			<div class="details-extra" id="details-0003">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>
		
		<div style="position: absolute; left: 1000px; top: 0px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
				<!-- <span class="plabel">Only 3 left</span> -->
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-0004">+</a>
			</div>
			<div class="details-extra" id="details-0004">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>
		
			
		
		<div style="position: absolute; left: 1000px; top: 350px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 6</a></p>
				<a href="" class="details-expand" data-target="details-0005">+</a>
			</div>
			<div class="details-extra" id="details-0005">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>
		
		<div style="position: absolute; left: 800px; top: 506px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 6</a></p>
				<a href="" class="details-expand" data-target="details-0006">+</a>
			</div>
			<div class="details-extra" id="details-0006">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>
		
		<div style="position: absolute; left: 400px; top: 650px;" class="product large">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 5</a></p>
				<a href="" class="details-expand" data-target="details-0007">+</a>
			</div>
			<div class="details-extra" id="details-0007">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>
		
		<div style="position: absolute; left: 1000px; top: 700px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 6</a></p>
				<a href="" class="details-expand" data-target="details-0008">+</a>
			</div>
			<div class="details-extra" id="details-0008">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>
		
		<!-- <div style="position: absolute; left: 0px; top: 832px;" class="product medium cta alt">
			<a href="http://leapfrogui.com/shopfrog/brown/collection.html">
				<div class="content">
					<p class="poff">20% <br> off!</p>
					<p>All accessories →</p>
				</div>
			</a>
		</div> -->
		
		<div style="position: absolute; left: 200px; top: 832px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-0009">+</a>
			</div>
			<div class="details-extra" id="details-0009">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>

		<div style="position: absolute; left: 800px; top: 1050px;" class="product large">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-00011">+</a>
			</div>
			<div class="details-extra" id="details-00011">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>		
		
		<div style="position: absolute; left: 0px; top: 988px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-00010">+</a>
			</div>
			<div class="details-extra" id="details-00010">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>		
		
		<!-- <div style="position: absolute; left: 200px; top: 1182px;" class="product medium cta">
			<a href="">
				<div class="content">
					<p class="poff">Like <br> us!</p>
					<p>on facebook →</p>
				</div>
			</a>
		</div>	 -->	
		
		<div style="position: absolute; left: 400px; top: 1300px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-1.jpg" alt="product title" data-img="product-1" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Event Wacana</a></p>
				<a href="" class="details-expand" data-target="details-00012">+</a>
			</div>
			<div class="details-extra" id="details-00012">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>				
			</div>			
		</div>			
		
		<div style="position: absolute; left: 600px; top: 1300px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 3</a></p>
				<a href="" class="details-expand" data-target="details-0013">+</a>
			</div>
			<div class="details-extra" id="details-0013">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>
							
		<div style="position: absolute; left: 0px; top: 1338px;" class="product medium">
			<div class="media">
				<a href="eventitem2.php?idevent=1" title="product title">
					<img src="asset/product-2.jpg" alt="product title" data-img="product-2" class="img-responsive">
				</a>
			</div>
			<div class="details">
				<p class="name"><a href="eventitem2.php?idevent=1">Wacana 4</a></p>
				<a href="" class="details-expand" data-target="details-0014">+</a>
			</div>
			<div class="details-extra" id="details-0014">
				
				<button class="btn btn-bottom btn-atc qadd">Ikut Event</button>			
			</div>			
		</div>		
		

	</div> <!-- //end product-board -->
	
	<footer>
	<div class="container">
		
	</div>
</footer>
	

</body></html>