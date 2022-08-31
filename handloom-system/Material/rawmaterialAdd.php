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
            //check whether the material is available
            $name = $_POST['mname'];
            $color = $_POST['mcolor'];
            $sql="select mid from material where mname='".$name."'AND mcolor='".$color."'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0){
                echo '<script>alert("Invalid Material Detail")</script>';
            }
            else{
                $quan = $_POST['quantity'];
                $date = $_POST['date'];
                //to get material id from result
                $row=mysqli_fetch_row($result);
                $id=$row[0];
                //to check whether the material and date already existing,if exist just update the quantity,else add new record
                $sql="select * from rawmaterial where mid='".$id."'AND bdate='".$date."'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)==0){
                    $sql = "select mcost from material where mid='".$id."'";
                    $result=mysqli_query($conn,$sql);
                    $row = mysqli_fetch_row($result);
                    $cost=$row[0]*$quan;
                    $sql="insert into rawmaterial values('$date','$id','$quan','$cost')";
                    $result =mysqli_query($conn,$sql);
                if(!$result)
                    echo '<script>alert("Error occured while inserting")</script>';
                else{
                    echo '<script>alert("Inserted Successfully")</script>';
                    $sql="select mid from materialStock where mid='".$id."' ";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)==0){
                        $sql="insert into materialStock values('$id','$quan')";
                        mysqli_query($conn,$sql);
                    }
                    else{
                        $sql = "update materialStock set count=count+'".$quan."' where mid='".$id."'";
                        mysqli_query($conn,$sql);
                    }
                }
                }
                else
                    echo'<script>alert("Entry exists already,for changes do updation")</script>';
                
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
width: 35%;
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
<legend>PURCHASED MATERIALS</legend>
<label for="materialid">Material Name</label>
<input type="text" name="mname" id="materialname" value="Bundle" style="background-color: white; color:black;" required>
<br><br>
<label for="materialid">Material color</label>
<input type="text" name="mcolor" id="materialcolor" required>
<span>*</span><br><br>
<label for="quantity">Quantity</label>
<input type="number" name="quantity" id="quantity" min="1" required>
<span>*</span><br><br>
<label for="date">Date</label>
<input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>"  min="2015-01-01" max="<?php echo date("Y-m-d");?>" required>
<span>*</span><br><br>
</fieldset>

<input type="submit" id="submit" value="ADD" name="submit">
<br>
</div>

</form>
</body>
</html>

