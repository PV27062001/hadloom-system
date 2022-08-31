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
            $empid = $_POST['employeeid'];
            //to check whether employee is available
            $sql="select empid from employee where empid='".$empid."'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0){
                echo '<script>alert("Invalid Employee Detail")</script>';
            }
            else{
                $date = $_POST['date'];
                $quan = $_POST['quantity'];
                $border = $_POST['border'];
                $damaged = $_POST['damaged'];
                $amount=($border*$quan*5)-($damaged*100);
                //to check whether the material is given
                $query="select odate from outgoing where empid='".$empid."' order by odate desc limit 1";
                $result=mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $query="select produced_date,empid,quantity from product where empid='".$empid."' and produced_date >'".$row[0]."' ";
                $result1=mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result1);

                if(mysqli_num_rows($result1) ==0 && mysqli_num_rows($result) !=0 ){                    
                    $sql="select * from product where produced_date='".$date."' AND empid='".$empid."'";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)==0){                                            
                        //to insert into product table
                        $sql="insert into product values('$date','$empid','$border','$quan','$damaged','$amount')";
                        $result =mysqli_query($conn,$sql);

                        if(!$result)
                            echo '<script>alert("Error occured while inserting '.$result.'")</script>';
                        else{
                            //to insert/update in product stock table
                            $sql="select * from productStock where border='".$border."'";
                            $result =mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)==0)
                                $sql="insert into productStock values('$border','$quan','$damaged')";
                            else
                                $sql="update productStock set quantity=quantity+$quan, dquantity=dquantity+$damaged where border='$border' ";
                            mysqli_query($conn,$sql);

                            //to send sms
                            $sql="select empname,phone from employee where empid='".$empid."'";
                            $result=mysqli_query($conn,$sql);
                            $row=mysqli_fetch_row($result);
                            $name=$row[0];
                            $phone=strval($row[1]);
                            $message=strval('Dear '.$name.', you have returned '.$quan.' sarees on '.date("d-m-Y", strtotime($date)).'. Salary : '.$amount);
                            /*$curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=wlsO6caMApWNq2g0LzvoSJTEHZ941GVRYnK8h5Q7btyFuk3mfU3m9yGNtioWwk1ZsHFCeKRrdLhTA4cx&message=".urlencode($message)."&language=english&route=q&numbers=".urlencode($phone),
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
                    else
                        echo'<script>alert("Entry exists already,for changes do updation")</script>'; 
                }
                else if($row[2]!=10){
                    echo'<script>alert("Product fully not returned");</script>';
                }
                else
                    echo'<script>alert("Material not provided");</script>';
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
width: 42%;
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
<script>
    function myfunction(event)
    {
        

        const obj = (document.getElementById("quantity").value);
        if(obj< 10)
        {
            let form = document.getElementById("formwrap");
            if (confirm("Are you sure of Product Quantity") == true) {
                form.submit();
            } else {
                event.preventDefault();
                alert("Cancelled");
                return;
            }
        }
    }
</script>
</head>

<body>
	<div class="forms">
<form method="post" id="formwrap">
<fieldset>
<legend>PRODUCT</legend>
<label for="employeeid">Employee ID</label>
<input type="text" name="employeeid" id="employeeid" required>
<span>*</span><br><br>
<label for="quantity">Quantity</label>
<input type="number" name="quantity" id="quantity" min="1" max="10" value="10" required>
<span>*</span><br><br>
<label for="damaged">Damaged Quantity</label>
<input type="number" name="damaged" id="damaged" min="0" max="10" value="0" required>
<span>*</span><br><br>
<legend>Border</legend>
<input type="radio" name="border" value="100" id="200" class="left">100&nbsp;&nbsp;&nbsp;
<input type="radio" name="border" value="120" id="120" class="left">120&nbsp;&nbsp;&nbsp;
<input type="radio" name="border" value="200"id="200" class="left last">200
<span>*</span><br><br>
<label for="date">Produced Date</label>
<input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" min="2015-01-01" max="<?php echo date("Y-m-d");?>" required>
<span>*</span><br><br>
</fieldset>
<input type="submit" value="ADD" name="submit" onclick="myfunction(event)">
<br>
</div>
</form>
</body>
</html>