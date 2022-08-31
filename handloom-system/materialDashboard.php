<?php
    session_start();
    if(!$_SESSION['login']){
        echo'<script>alert("User not logged in")</script>';
        header("location: ../index.html");
        exit();
    }
?>
<html>
<head>
<title>Material Dashboard</title>
  <meta>
  <style type="text/css">
      * {
          box-sizing: border-box;
      }
      body{
        background-color: #f1f3f4;
      }
      #opt {
          border-radius: 5px;
          background: #bf9aca;
          text-align: center;
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
</head>
<body>
<div id="header">
    <table>
        <td id="head"> MATERIAL DASHBOARD</td>
        <td><a id="button" href="logout.php"><img src='./Images/logout.png' height=23px width=23px></a></td>
    </table>
    </div>
    <br><br>
<div id="container" align="center">
  <table>
    <tr>
      <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=mat">
              <div id="optimg"><img height="80px" src="./Images/mi.png"></div>
              <div id="opttext">MATERIALS</div>
          </div>
      </td>
      <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=stock">
              <div id="optimg"><img height="80px" src="./Images/stock.png"></div>
              <div id="opttext">STOCK</div>
          </div>
      </td>
      <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=raw">
              <div id="optimg"><img height="80px" src="./Images/mb.png"></div>
              <div id="opttext">PURCHASED MATERIALS</div>
          </div>
      </td>
      <td>
          <div id="opt">
              <a style="text-decoration:none" href="navigation.php?val=outgoing">
              <div id="optimg"><img height="80px" src="./Images/mg.png"></div>
              <div id="opttext">OUTGOING MATERIALS</div>
          </div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>