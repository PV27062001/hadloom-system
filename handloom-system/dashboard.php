<?php
  session_start();
  if($_SESSION['login'])
  {
      $hostname ="localhost";
      $name ="root";
      $password="";
      $db="wad_project"; 
      $conn=mysqli_connect($hostname,$name,$password);
      mysqli_select_db($conn,$db);
      $sql="select sum(amount) from income where MONTH(tdate)=MONTH(now()) and YEAR(tdate)=YEAR(now())";
      $result=mysqli_query($conn,$sql);
      $income=mysqli_fetch_row($result);
      $sql="select sum(cost) from rawmaterial where MONTH(bdate)=MONTH(now()) and YEAR(bdate)=YEAR(now())";
      $result=mysqli_query($conn,$sql);
      $mat_cost=mysqli_fetch_row($result);
      $sql="select sum(salary) from product where MONTH(produced_date)=MONTH(now()) and YEAR(produced_date)=YEAR(now());";
      $result=mysqli_query($conn,$sql);
      $sal_cost=mysqli_fetch_row($result);
      $profit=$income[0]-($mat_cost[0]+$sal_cost[0]);
      mysqli_close($conn);
  }
  else{
    echo'<script>alert("User not logged in")</script>';
    header("location: ../index.html");
    exit();
  }
?>
<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta>
<style type="text/css">
    * {
        box-sizing: border-box;
    }
    body{
      background-color: #f1f3f4;
    }
    #opt {
        border-radius: 10px;
        background: #bf9aca;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    #opttext {
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-weight: bolder;
        text-align: center;
        color: black;
        font-size: 20px;
    }
    #optimg {
        padding: 2px;
        display: flex;
        justify-content: center;
    }
    #box {
        border:solid 1px black;
        height: 200px;
    }
    #header{
        border-radius: 5px;
        background-color: black;
        color: white;
        padding: 10px;
    }
    table {
        width: 100%;
        border-spacing: 15px;
    }
    td{
        width: 25%;
    }
    #button {
      width:fit-content;
      padding:5px;
      color: white;
      float:right;
      text-decoration:none;
    }
    #head{
        font-family: "Lato", sans-serif;
        color:white;
        font-weight: bold;
        font-size:25px
    }
  </style>
 <script type="text/javascript">
  function change(){
    document.getElementById("profit").innerHTML="Loss";
  }
</script>
</head>
<body>
  <div id="header">
    <table>
    <td id="head">DASHBOARD</td>
    <td><a id="button" href="logout.php"><img src='./Images/logout.png' height=23px width=23px></a></td>
    </table>
  </div>
  <br><br>
  <div id="container" align="center">
    <table>
      <tr>
        <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=emp">
              <div id="optimg"><img height="80px" src="./Images/emp.png" id="emp"></div>
              <div id="opttext">EMPLOYEE</div>
              </a>
          </div>
        </td>
        <td>
          <div id="opt">
              <a style="text-decoration:none" href="materialDashboard.php">
              <div id="optimg"><img height="80px" src="./Images/mat.png" id="mat"></div>
              <div id="opttext">MATERIALS</div>
              </a>
          </div>
        </td>
        <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=product">
              <div id="optimg"><img height="80px" src="./Images/prod.png" id="prod"></div>
              <div id="opttext">PRODUCT</div>
              </a>
          </div>
        </td>
        <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=income">
              <div id="optimg"><img height="80px" src="./Images/inc.png" id="inc"></div>
              <div id="opttext">INCOME</div>
          </a>
          </div>
        </td>
    </tr>
    <tr>
      <td colspan="2">
          <div id="box">
              <h1 style="margin-left:20px;">Income</h1>
              <?php
                echo "<p style='font-size:30px;margin-left: 100px;'>$income[0]</p>";
              ?>
          </div>
      </td>
      <td colspan="2">
          <div id="box">
              <h1 id="profit" style="margin-left: 20px;">Profit</h1>
              <?php
                if($profit<0){
                    $profit=abs($profit);
                    echo '<script type="text/javascript">change()</script>';
                  }
                echo "<p style='font-size:30px;margin-left: 100px;'>$profit</p>";
              ?>
          </div>
      </td>
    </tr>
    </table>
  </div>
</body>
</html>