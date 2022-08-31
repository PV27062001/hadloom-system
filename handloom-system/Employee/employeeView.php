<?php
    session_start();
    if(!$_SESSION['login']){
        echo'<script>alert("User not logged in")</script>';
        header("location: ../index.html");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .table>thead:first-child>tr:first-child>th {
        border-top: solid 2px!important;
        }
        table.table-bordered > thead > tr > th {
           border-color: black;
          font-family: "Courier New";
          font-size: 20px;
        }
        table.table-bordered > tbody > tr > td{
            border-color: black;
        }
        .table-hover tbody tr:hover td  
        {  
            background-color: #242424;
            color: white;  
        } 
    </style>
</head>
<body>
  <h1 align="center"><b>EMPLOYEE INFORMATION</b></h1>
<div class="container mt-2">
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Address</th>
      <th scope="col">Gender</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $hostname ="localhost";
      $name ="root";
      $password="";
      $db="wad_project"; 
      $conn=mysqli_connect($hostname,$name,$password);
      mysqli_select_db($conn,$db);
      $query="select * from employee";
      $result=mysqli_query($conn,$query);
      if ($result->num_rows > 0):
      while($row=mysqli_fetch_row($result)): 
        if($row[4]=='F')
            $g='Female';
        elseif ($row[4]=='M')
            $g='Male';
        else
            $g='Others';?>
    <tr>
        <td><?php echo $row[0];?></td>
        <td><?php echo $row[1];?></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3];?></td>
        <td><?php echo $g;?></td>
    </tr>

    <?php endwhile; ?>

    <?php else: ?>
    <tr>
       <td colspan="5" rowspan="1" headers="">No Data Found</td>
    </tr>
    <?php endif; ?>

    <?php mysqli_free_result($result); ?>

      </tbody>
    </table>
</div>        
</div>
</body>
</html>
