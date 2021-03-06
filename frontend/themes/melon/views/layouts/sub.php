<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

/**
 * @var $this \front\components\FrontController
 * @var $content string
 */
?>
<?php
$this->beginContent('//layouts/base');
?>
	<?php echo $content; ?>
<?php
$this->endContent();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>home</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/flexslider.css" rel="stylesheet">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="page">
	<div class="header">
		<div class="container">
			<div class="logo"><a href="#"><img src="images/logo.png" alt="" /></a></div>
			<div class="center-name"><img src="images/c-name.png" alt="" /></div>
			<div class="language">
				<ul>
					<li><a href="#" class="active">en</a></li>
					<li><a href="#">ru</a></li>
					<li><a href="#">uk</a></li>
				</ul>
			</div>
		</div>
	</div><!-- .header -->
	<div class="menu">
	<div class="container">
		<nav><ul class="nav-top">
			<li><a href="index.html" class="active" >Home</a></li>
			<li><a href="about.html">ABOUT COMPANY</a></li>
			<li><a href="gallery.html">GALLERY</a></li>
			<li><a href="princ.html">PRINCIPLES</a></li>
			<li><a href="partners.html">PARTNERS</a></li>
			<li><a href="contact.html">CONTACTS</a></li>
		</ul>
		</nav>
	</div>
	</div>
	<div class="full-slider">
		<div class="flexslider">
  <ul class="slides">
    <li>
      <img src="images/slide-1.jpg" />
	  <div class="caption"><h1>BELIEVE <span class="cap-sm">professionals</span><br /> <span class="cap-red" >and immediately </span></h1>
		<a href="#" class="btn btn-cap"data-toggle="modal" data-target="#myModal">MAKE AN ORDER</a>
	  </div>
    </li>
    <li>
       <img src="images/slide-2.jpg" />
	   <div class="caption"><h1>BELIEVE <span class="cap-sm">professionals</span><br /> <span class="cap-red" >and immediately </span></h1>
	   <a href="#" class="btn btn-cap" data-toggle="modal" data-target="#myModal">MAKE AN ORDER</a>
	   </div>
    </li>

  </ul>
</div>
	</div>
<div class="footer">
	<div class="container">
		<div class="column-first">
		<h3>Do you have a question for us?</h3>
			<div class="f-f-group">
				<form class="form-inline" role="form">
					  <div class="form-group">
						<input type="text" class="form-control" id="name" placeholder="Name">
					  </div>
					  <div class="form-group">
						<div class="input-group">

						  <input class="form-control" type="text" placeholder="Your email">
						</div>
					  </div>
					  <div class="form-group">

						<textarea placeholder="Your message"></textarea>
					  </div>
					  <button type="submit" class="btn btn-send">Sign in</button>
				</form>
			</div>
		</div>
		<div class="column">
			<h3>Follow us:</h3>
			<div class="social">
			<ul>
				<li class="fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
				<li class="tw"><a href="#"><i class="fa fa-twitter"></i></i></a></li>
				<li class="vk"><a href="#"><i class="fa fa-vk"></i></a></li>
			</ul>
			</div>
		</div>
		<div class="column">
			<h3>Contact us:</h3>
			<p>T: +971 50 100 6810</p>
			<p>E: sales@macondevillas.com</p>
		</div>
		<div class="column">
			<div class="copy">© ADIMENSION <br />
			DESIGN GROUP 2014</div>
		</div>
	</div>
</div>
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

      </div>
      <div class="modal-body">
       <div class="form-wrap">
		<input type="text" class="form-control" placeholder="Your name">
		<input type="text" class="form-control" placeholder="Your mail">
		<textarea class="form-control" rows="3" placeholder="Your message"></textarea>
	   </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-modal">MAKE AN ORDER</button>
      </div>
    </div>
  </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/scripts.js"></script>
  </body>
</html>