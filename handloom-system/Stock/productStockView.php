<?php
    session_start();
    if(!$_SESSION['login']){
        echo'<script>alert("User not logged in")</script>';
        header("location: ../index.html");
        exit();
    }
    else{
        $i=0;
        $hostname ="localhost";
        $name ="root";
        $password="";
        $db="wad_project"; 
        $conn=mysqli_connect($hostname,$name,$password);
        mysqli_select_db($conn,$db);
        $query="select *from productStock";
        $result=mysqli_query($conn,$query);
        $less="Restock Needed ";
        if (mysqli_num_rows($result) > 0){
            while($row=mysqli_fetch_row($result)){
                if($row[1]<=10)
                  $less=$less."Border :".$row[0]."-".$row[1]." ";
            }
        }  
        if($less!="Restock Needed "){ 
          echo'<script>alert("'.$less.'")</script>';
          $conn=mysqli_connect("localhost","root","","wad_project");
          $sql="select phone from owner where username = '".$_SESSION['login']."'";
          $result = mysqli_query($conn,$sql);
          $row = mysqli_fetch_row($result);
          $phone =$row[0];
          /*$curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=wlsO6caMApWNq2g0LzvoSJTEHZ941GVRYnK8h5Q7btyFuk3mfU3m9yGNtioWwk1ZsHFCeKRrdLhTA4cx&message=".urlencode($less)."&language=english&route=q&numbers=".urlencode($phone),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
          ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);
          if ($err) {
          echo '<script>alert("Error while send message")</script>';
          } else {
          echo '<script>alert("Message Sent")</script>';
          }*/
        }
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
  <h1 align="center"><b>PRODUCT STOCK INFORMATION</b></h1>
<div class="container mt-2">
<div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Border size</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Damaged Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  
                  $query="select * from productStock";
                  $result=mysqli_query($conn,$query);
                  if ($result->num_rows > 0):
                  while($row=mysqli_fetch_row($result)): ?>   
                <tr>
                    <td><?php echo $row[0];?></td>
                    <td><?php echo $row[1];?></td>
                    <td><?php echo $row[2];?></td>
                </tr>

                <?php endwhile; ?>

                <?php else: ?>
                <tr>
                   <td colspan="4" rowspan="1" headers="">No Data Found</td>
                </tr>
                <?php endif; ?>

                <?php mysqli_free_result($result); ?>

              </tbody>
            </table>
        </div>
        </div>
    </div>        
</div>
</body>
</html>