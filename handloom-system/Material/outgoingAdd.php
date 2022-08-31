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
        if(isset($_POST['submit'])){
            $name = $_POST['mname'];
            $color = $_POST['mcolor'];
            $empid= $_POST['employeeid'];
            $date = $_POST['date'];
            //to get material id from name and color
            $sql="select mid from material where mname='".$name."'AND mcolor='".$color."'";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_row($result);
            $mid=$row[0];
            $sql="select empid from employee where empid='".$empid."'";
            $result1=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0)
                echo '<script>alert("Invalid Material Detail")</script>';
            else if(mysqli_num_rows($result1)==0)
                echo '<script>alert("Invalid Employee Detail")</script>';
            else{
                //for first time insertion
                $query="select count(*) from product group by empid having empid='".$empid."' ";
                $result=mysqli_query($conn,$query);
                $product_count=mysqli_fetch_row($result);
            
                $query="select count(*) from outgoing group by empid having empid='".$empid."' ";
                $result=mysqli_query($conn,$query);
                $outgoing_count=mysqli_fetch_row($result);

                if($product_count[0] !=0){
                    //check whether the product has been returned completely for the last material given,if then add,else dont add
                    $query="select odate from outgoing where empid='".$empid."' order by odate desc limit 1";
                    $result=mysqli_query($conn,$query);
                    $row=mysqli_fetch_row($result);
                    $query="select produced_date,empid,quantity from product where empid='".$empid."' and produced_date >='".$row[0]."' ";
                    $result=mysqli_query($conn,$query);
                    $product_count=mysqli_fetch_row($result);
                }
                if(($product_count[0] == 0 && $outgoing_count[0] ==0) || (mysqli_num_rows($result) >0 && $product_count[2]==10)){
                    //to check whether the mid,empid,date already existing,if exist just notify,else add new record
                    $sql="select * from outgoing where empid='".$empid."' AND mid='".$mid."'AND odate='".$date."'";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)==0){
                        $sql="select count from materialStock where mid='".$mid."' ";
                        $result=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_row($result);
                        $count=$row[0];
                        if($count>0){
                            $sql="select * from outgoing";
                            $result =mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)==0)
                                $id='OM001';
                            else{
                                $sql="select oid from outgoing order by oid desc limit 1";
                                $result =mysqli_query($conn,$sql);
                                $row=mysqli_fetch_row($result);
                                $id=$row[0];
                                $id++;
                            }
                            $sql="insert into outgoing values('$id','$date','$empid','$mid')";
                            $result =mysqli_query($conn,$sql);
                            if(!$result)
                                echo '<script>alert("Error occured while inserting")</script>';
                            else{
                                echo '<script>alert("Inserted successfully")</script>';
                                $sql = "update materialStock set count = count-1 where mid='".$mid."'";
                                mysqli_query($conn,$sql);
                            }
                        }
                        else
                            echo '<script>alert("No stock")</script>';
                    }
                    else
                        echo'<script>alert("Entry exists already,for changes do updation")</script>';

                    }
                else
                    echo'<script>alert("Products are not completely returned")</script>';
            }
        }   
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
 <title>ADDING FORM</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
*{
margin: 8px;
padding: 8px;
background-color: #101010;
color: #fff;
}
.forms{
    opacity: 0.9;
}
body {
background: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCLkw2ltTSVcCg3jQBx2mPgQ2zmIByVxQYdg&usqp=CAU) no-repeat   center center #000000;   
background-size: cover;
font-family: Georgia, serif;
margin: 0 auto;
width: 600px;
border: 3px solid #606060;
padding: 10px 20px;
border-radius: 15px;
align-content: center;
font-size: 19px;
background-color: #000;
}
fieldset {
margin-top: 1em;
margin-bottom: 1em;
padding: .5em;
}
legend {
color: #909090;
font-weight: bold;
font-size: 85%;
margin-bottom: .5em;
}
label {
float: left;
width: 39%;
font-weight: 500;
display: flex;
}
input[type=submit]{
    margin: 4px 2px;
    padding: 10px 20px;
    background: #404040; 
    border: 1; 
    cursor: pointer; 
    color: black;
    font-weight: 40%;
    float: right;
    background: white;
}
input[type="submit"]:hover{
            color: white;
            background:  #000; 
            transition: .5s;}
        
        ::placeholder{color: #000;}
.forms{
    background-color: #000;
} 
legend{
    font-size: 30px;
    color: white;
}
</style>
</head>

<body>
    <div class="forms">
<form method="post" id="formwrap">

<fieldset>
<legend>OUTGOING MATERIALS</legend>
<label for="materialid">Material Name</label>
<input type="text" name="mname" id="materialname" value="Bundle" style="background-color: white; color:black;" required>
<br><br>
<label for="materialid">Material color</label>
<input type="text" name="mcolor" id="materialcolor" required>
<span>*</span><br><br>
<label for="employeeid">Employee ID</label>
<input type="text" name="employeeid" id="employeeid" required>
<span>*</span><br><br>
<label for="date">Outgoing Date</label>
<input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>"  min="2015-01-01" max="<?php echo date("Y-m-d");?>" required>
<span>*</span><br><br>
</fieldset>

<input type="submit" id="submit" value="ADD" name="submit">
<br>
</div>

</form>
</body>
</html>