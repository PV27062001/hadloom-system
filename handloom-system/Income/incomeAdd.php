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
            $id =$_SESSION['login'];
            $quan = $_POST['quantity'];
            $dquan = $_POST['damaged'];
            $date = $_POST['date'];
            $border = $_POST['border'];
            $sql="select * from income where tdate='".$date."' and ownerid='".$id."' and border='".$border."'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0){
                $sql="select quantity,dquantity from productStock where border='".$border."' ";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_row($result);
                $quantity=$row[0];
                $dquantity=$row[1];
                if($quantity ==0 && $quan>0)
                    echo '<script>alert("No stock")</script>';
                else if($dquantity==0 && $dquan>0)
                    echo '<script>alert("No stock in damaged product")</script>';
                else{
                    if($quantity-$quan < 0)
                        echo '<script>alert("Stock is less in product")</script>';
                    else if ($dquantity - $dquan < 0)
                        echo '<script>alert("Stock is less in damaged product")</script>';
                    else{
                        $amount=($border*$quan*20)-($dquan*100);
                        $sql="insert into income values('$id','$date','$border','$quan','$dquan','$amount')";
                        $result =mysqli_query($conn,$sql);
                        if(!$result)
                            echo '<script>alert("Error occured while inserting")</script>';
                        else{
                            echo '<script>alert("Inserted successfully")</script>';
                            $sql="update productStock set quantity=quantity-'".$quan."', dquantity=dquantity-'".$dquan."' where border='".$border."'";
                            mysqli_query($conn,$sql);
                        }
                    }
                }
            }
            else
                echo'<script>alert("Entry exists already,for changes do updation")</script>';       
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
<legend>INCOME</legend>
<label for="date">Date</label>
<input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>"  min="2015-01-01" max="<?php echo date("Y-m-d");?>" required>
<span>*</span><br><br>
<label for="quantity">Quantity sold</label>
<input type="number" name="quantity" id="quantity" min="1" required>
<span>*</span><br><br>
<label for="damaged">Damaged Quantity</label>
<input type="number" name="damaged" id="damaged" min="0" value="0" required>
<br><br>
<legend>Border</legend>
<input type="radio" name="border" value="100" id="200" class="left">100&nbsp;&nbsp;&nbsp;
<input type="radio" name="border" value="120" id="120" class="left">120&nbsp;&nbsp;&nbsp;
<input type="radio" name="border" value="200"id="200" class="left last">200<span>*</span><br><br>
</fieldset>

<input type="submit" id="submit" value="ADD" name="submit">
<br>
</div>

</form>
</body>
</html>

