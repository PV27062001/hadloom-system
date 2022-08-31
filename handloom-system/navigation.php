<?php
    session_start();
    if(!$_SESSION['login']){
        header("location: index.html");
        echo'<script>alert("User not logged in")</script>';
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: "Lato", sans-serif;
  overflow-x: hidden;
  overflow-y: hidden;
}
.sidenav {
  height: 100%;
  width: 290px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 10px;
}

.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 250px; 
  font-size: 20px; 
  padding: 0px 15%;
  width: -moz-fit-content;
  width: fit-content;
  height: fit-content;
  overflow-x: none;
  overflow-y: none;
}

.active {
  background-color: #884ea0;
  color: white;
}

.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 8px;
}

.fa-caret-down {
  float: right;
  padding-right: 8px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


</style>
</head>
<body>
  
<div class="sidenav">
  <div class="back">
  <button class="bt" id="bt" style="float: right; border: 10px solid #000; background-color: #808080"><a href="javascript:window.history.back();" style="color: black; font-size: 20px; padding: 6px;">Back</a></button>  
</div>
  <br><br>

  <button class="dropdown-btn">Employee 
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="emp_view()">View</a>
    <a href="#" onclick="emp_add()">Add</a>
    <a href="#" onclick="emp_del()">Delete/Edit</a>
  </div>
    <br><br>
  
  <button class="dropdown-btn">Materials
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="mat_view()">View</a>
    <a href="#" onclick="mat_add()">Add</a>
    <a href="#" onclick="mat_del()">Delete/Edit</a>
  </div>
      <br><br>
  
  <button class="dropdown-btn">Raw Materials
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="raw_view()">View</a>
    <a href="#" onclick="raw_add()">Add</a>
    <a href="#" onclick="raw_del()">Delete/Edit</a>
  </div>
    <br><br>

  <button class="dropdown-btn">Stock 
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="mstock_view()">View</a>
  </div>
    <br><br>

  <button class="dropdown-btn">Outgoing Rawmaterials
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="outgoing_view()">View</a>
    <a href="#" onclick="outgoing_add()">Add</a>
    <a href="#" onclick="outgoing_del()">Delete/Edit</a>
  </div>
    <br><br>
  
  <button class="dropdown-btn">Products
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="product_view()">View</a>
    <a href="#" onclick="product_add()">Add</a>
    <a href="#" onclick="product_del()">Delete/Edit</a>
    <a href="#" onclick="pstock_view()">Stock</a>
  </div>
    <br><br>
  
  <button class="dropdown-btn">Income
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#" onclick="income_view()">View</a>
    <a href="#" onclick="income_add()">Add</a>
    <a href="#" onclick="income_del()">Delete/Edit</a>
  </div>
  <br><br>

</div>

<div class="main" id="main"></div>

<br><br><br>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
  
}

 function emp_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Employee/employeeView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function emp_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Employee/employeeAdd.php" width="800" height="670" position="absolute" top="50%" left="50%" display="flex" margin="auto"></embed>';
 }
 function emp_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Employee/employeeDel.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex" overflow="hidden"></embed>';
 }

function mat_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/materialView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function mat_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/materialAdd.php" width="800" height="520" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function mat_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/materialDel.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }

 function raw_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/rawmaterialView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function raw_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/rawmaterialAdd.php" width="800" height="670" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function raw_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/rawmaterialDel.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }

 function mstock_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Stock/materialStockView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }

function outgoing_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/outgoingView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function outgoing_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/outgoingAdd.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function outgoing_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Material/outgoingDel.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }

function product_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Product/productView.php" width="900" height="620" position="absolute" top="50%" left="20%" display="flex"></embed>';
 }
 function product_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Product/productAdd.php" width="800" height="690" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function product_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Product/productDel.php" width="1000" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function pstock_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Stock/productStockView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
function income_view(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Income/incomeView.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function income_add(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Income/incomeAdd.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 }
 function income_del(){
     document.getElementById("main").innerHTML='<embed type="text/html/php" src="./Income/incomeDel.php" width="800" height="620" position="absolute" top="50%" left="50%" display="flex"></embed>';
 } 
 
 
</script>
  <?php
    $val = $_GET['val'];
    if ($val =='emp')
      echo '<script type="text/javascript">emp_view();</script>';
    elseif ($val =='mat')
      echo '<script type="text/javascript">mat_view();</script>';
    elseif ($val =='stock')
      echo '<script type="text/javascript">mstock_view();</script>';
    elseif ($val =='raw')
      echo '<script type="text/javascript">raw_view();</script>';
    elseif ($val =='outgoing')
      echo '<script type="text/javascript">outgoing_view();</script>';
    elseif ($val =='product')
      echo '<script type="text/javascript">product_view();</script>';
    else
      echo '<script type="text/javascript">income_view();</script>';
      
   ?>
</body>
</html> 