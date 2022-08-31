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
  <h1 align="center"><b>INCOME INFORMATION</b></h1>
<div class="container mt-2">
<div class="container">
            <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Border<br>Size</th>
                  <th scope="col">Quantity<br>sold</th>
                  <th scope="col">Damaged<br>Quantity</th>
                  <th scope="col">Income</th>
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
                  $query="select * from income order by tdate";
                  $result=mysqli_query($conn,$query);
                  if ($result->num_rows > 0):
                  while($row=mysqli_fetch_row($result)): ?>   
                <tr>
                    <td><?php echo date("d-m-Y", strtotime($row[1]));?></td>
                    <td><?php echo $row[2];?></td>
                    <td><?php echo $row[3];?></td>
                    <td><?php echo $row[4];?></td>
                    <td><?php echo $row[5];?></td>
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
