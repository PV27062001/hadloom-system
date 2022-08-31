	<?php
	session_start();
	if(isset($_POST['submit'])){
		if($_SESSION['login'])
     		header("location: dashboard.php");
   	else
   		header("location: login.php");
   }
   ?>
<html>
<head>
	<title>WEBSITE</title>
<style>
*{
	margin: 0;
	padding: 0;
	font-family: Century Gothic;
}
header{
	background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(./Images/bg3.jpg);
	height: 100vh;
	background-size: cover;
	background-position: center;
}
ul{
	float: right;
	list-style-type: none;
	margin-top: 25px;
}
ul li{
	display: inline-block;	
}
ul li a{
	text-decoration: none;
	color:#fff;
	padding: 5px 20px;
	border: 1px solid transparent;
	transition: 0.7s ease;
}
ul li a:hover{
	background-color: #fff;
	color: #000;
}
ul li.active a{
	background-color: #fff;
	color: #000;
}
.logo img{
	float: left;
	width: 120px;
	height: auto;
}
.main{
	max-width: 1200px;
	margin: auto;
}
.title{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
}
.title h1{
	color: #fff;
	font-size: 75px;
}
.button{
	position: absolute;
	top: 62%;
	left: 50%;
	transform: translate(-50%,-50%);
}
.btn{
	border: 1px solid #fff;
	padding: 10px 30px;
	color: #fff;
	text-decoration: none;
}
.btn:hover{
	background-color: #fff;
	color: #000;
}
.about
{
   text-decoration: none;
	padding: 50px 60px;
	border: 1px solid black;
	background-color: white;	
	text-align: center;
}
.center2{
	font-weight: 25px;
}
</style>
</head>
<body>
	<header>
		<div class="main">         
			<div class="logo">
				<img src="./Images/logo1.png">
			</div>
			<ul>
				<li class="active"><a href="index.html">HOME</a></li>
				<li><form><button value="submit" name="submit">LOGIN</button></form></li>
			</ul>
		</div>
		<div class="title">
			<h1>HANDLOOM</h1>
		</div>
		<div class="button">
			<a class="btn" href="#about">LEARN MORE</a>
		</div>
	</header>
	<div id="about" class="about">
	<h3 class="center">ABOUT US</h3>
	  <p class="center2"><em>HANDLOOM WEAVERS</em></p>
	  <p align="left" style="font-size: 18px;">We really love handwoven fabrics. What makes these fabrics different? Well, they are just that: woven by hand, by people, using a handloom (which is to say, a hand-operated, non-mechanized loom). That is why we refer to the fabrics interchangeably as "handwoven" or "handloom" fabrics.Weaving is a fascinating and intricate process, and most of us don't think too much about it, just taking for granted that fabric exists. Most handloom fabrics (and most woven fabrics in general) are plain weave, which is the simplest weave structure, so that's what we'll look at here. In a plain weave, the weft threads alternately pass over and under one warp thread at a time on the loom.</p>
		</div>
</body>
</html>