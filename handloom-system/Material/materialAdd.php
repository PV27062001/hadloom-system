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
            $sql="select * from material";
            $result =mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0)
                $id='M001';
            else{
                $sql="select mid from material order by mid desc limit 1";
                $result =mysqli_query($conn,$sql);
                $row=mysqli_fetch_row($result);
                $id=$row[0];
                $id++;
            }   
            $name = $_POST['mname'];
            $color = $_POST['mcolor'];
            $cost = $_POST['cost'];
            $sql="select * from material where mname='".$name."'AND mcolor='".$color."'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0){
                $sql="insert into material values('$id','$name','$color','$cost')";
                $insert =mysqli_query($conn,$sql);
                if(!$insert)
                    echo '<script>alert("Error occured while inserting")</script>';
                else
                    echo '<script>alert("Inserted successfully")</script>';
            }
            else
                echo '<script>alert("Material already existing")</script>';
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
<legend>MATERIAL</legend>
<label for="materialname">Name </label>
<input type="text" name="mname" id="materialname" value="Bundle" style="background-color: white; color:black;" required>
<br><br>
<label for="materialcolor">Color</label>
<input type="text" name="mcolor" id="materialcolor" placeholder="Red.." required>
<span>*</span><br><br>
<label for="cost">Cost </label>
<input type="text" name="cost" id="cost" required>
<span>*</span><br><br>
</fieldset>

<input type="submit" id="submit" value="ADD" name="submit">
<br>
</div>

</form>
</body>
</html>

