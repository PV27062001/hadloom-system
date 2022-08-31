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
            $sql="select * from employee";
            $result =mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0)
                $id='E001';
            else{
                $sql="select empid from employee order by empid desc limit 1";
                $result =mysqli_query($conn,$sql);
                $row=mysqli_fetch_row($result);
                $id=$row[0];
                $id++;
            }   
            $name = $_POST['name'];
            $phone =$_POST['phone'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $sql="select * from employee where empname='".$name."'AND phone='".$phone."'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0){
                $sql="insert into employee values('$id','$name','$phone','$address','$gender')";
                $insert =mysqli_query($conn,$sql);
                if(!$insert)
                    echo '<script>alert("Error occured while inserting")</script>';
                else
                    echo '<script>alert("Inserted successfully")</script>';
            }
            else
                echo '<script>alert("Employee already existing")</script>';
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
width: 90px;
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
    font-size: 23px;
    color: white;
}
</style>

<script>
function validate() {
var phone = document.getElementById('phone');        
 if (!phone.value.match(/^[6-9][0-9]{9}$/)) {
    alert("Phone number must be 10 characters long number and first digit should be from 6 to 9!");
    phone.focus();
    event.preventDefault();
    return false;
  }   
  alert("successfully submitted!");
  document.getElementById("formwrap").submit();
  return true;
}
</script>

</head>

<body>
	<div class="forms">
<form method="post" id="formwrap">

<fieldset>
<legend>EMPLOYEE</legend>
<label for="name">Name </label>
<input type="text" name="name" id="name" required>
<span>*</span><br><br>
<label for="phone">Phone </label>
<input type="text" name="phone" id="phone" placeholder="999-999-9999" required>
<span>*</span><br><br>
<label for="address">Address </label>
<textarea rows="3" cols="37" name="address" placeholder="Enter Address here..." required></textarea>
<span>*</span><br><br>
<legend>Gender</legend>
<input type="radio" name="gender" value="M" id="Male" class="left">Male&nbsp;&nbsp;&nbsp;
<input type="radio" name="gender" value="F" id="Female" class="left">Female&nbsp;&nbsp;&nbsp;
<input type="radio" name="gender" value="O"id="others" class="left last">Others<span>*</span><br><br>
</fieldset>

<center>
    <input type="submit" id="submit" value="ADD" name="submit" onclick="validate()">
</center>
<br>
</div>

</form>
</body>
</html>