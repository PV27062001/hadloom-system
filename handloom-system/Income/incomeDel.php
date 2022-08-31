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
    $sql="select * from income order by tdate";

    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "delete": {
                //to delete record from income 
               $sql1="delete from income where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."' ";
                mysqli_query($conn,$sql1);

                //to update in product stock
                $query="update productStock set quantity=quantity+'".$_POST['quan']."', dquantity=dquantity+'".$_POST['dquan']."' where border='".$_POST['border']."' ";
                mysqli_query($conn,$query);
            }break;
            case "edit": {
                $query="select quantity,dquantity from income where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."' ";
                $result=mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $quan=$row[0]-$_POST['quan'];
                $dquan=$row[1]-$_POST['dquan'];
                if($quan <0 || $dquan < 0){
                    $query="select quantity,dquantity from productStock where border='".$_POST['border']."' ";
                    $result=mysqli_query($conn,$query);
                    $row=mysqli_fetch_row($result);
                    $quantity=$row[0];
                    $dquantity=$row[1];
                    if($quantity == 0 && $quan < 0)
                        echo '<script>alert("No stock in product")</script>';
                    else if($dquantity == 0 && $dquan <0)
                        echo '<script>alert("No stock in damaged product")</script>';
                    else if($quan<0 && $dquan<0 && $quantity-$quan < 0 && $dquantity-$dquan < 0)
                            echo '<script>alert("Stock is less in product and damaged product")</script>';
                    else{
                        if($quan <0){
                            if($quantity-abs($quan) < 0)
                                echo '<script>alert("Stock is less in product")</script>';
                            else{
                                $amnt=abs($quan) *$_POST['border']*20;
                                //to update income
                                $sql2="update income set quantity='".$_POST['quan']."',amount=amount+'".$amnt."' where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."'";
                                //to update product stock
                                $query =" update productStock set quantity=quantity+'".$quan."' where border='".$_POST['border']."' ";                                        
                                mysqli_query($conn,$sql2);
                                mysqli_query($conn,$query);
                            }
                        }
                        if($dquan < 0){
                            if ($dquantity - abs($dquan) < 0)
                                echo '<script>alert("Stock is less in damaged product")</script>';
                            else{
                                $amnt=abs($dquan)*100;
                                //to update income
                                $sql2="update income set dquantity='".$_POST['dquan']."' ,amount=amount-'".$amnt."' where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."'";
                                //to update product stock
                                $query =" update productStock set  dquantity=dquantity+'".$dquan."' where border='".$_POST['border']."' ";                                
                                mysqli_query($conn,$sql2);
                                mysqli_query($conn,$query);
                            }
                        }                        
                    }
                }
                if($quan >0){
                    $amnt=($quan*$_POST['border']*20);
                //to update income 
                    $sql2 ="update income set quantity = '".$_POST['quan']."', amount=amount-'".$amnt."' where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."' ";
                    //to update product stock
                    $query = " update productStock set quantity=quantity+'".$quan."' where border='".$_POST['border']."' ";
                    mysqli_query($conn,$sql2);
                    mysqli_query($conn,$query);
                }
                if($dquan >0){
                    $amnt=($quan*$_POST['border']*20);
                    //to update income 
                    $sql2 ="update income set dquantity='".$_POST['dquan']."',amount=amount-'".$amnt."' where ownerid='".$_POST['id']."' AND tdate='".date("Y-m-d", strtotime($_POST['date']))."' and border='".$_POST['border']."' ";

                    //to update product stock
                    $query = " update productStock set dquantity=dquantity+'".$dquan."' where border='".$_POST['border']."' ";
                    mysqli_query($conn,$sql2);
                    mysqli_query($conn,$query);
                }
            } break;
        }
    }

    $result=mysqli_query($conn,$sql);
}
else{
    echo'<script>alert("User not logged in")</script>';
    header("location: ../index.html");
    exit();
}
?>
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
    table{
        margin-top: 20px;
    }
    table.table-bordered > thead > tr > th {
        border-color: black;
        font-family: "Courier New";
        font-size: 20px;
    }
    table.table-bordered > tbody > tr > td{
        border-color: black;
    }
</style>
<script type='application/javascript'>
    var data = {}
    function editRow(row){
        data[row] = document.getElementsByName("row"+row)[0].innerHTML;
        let sel = document.getElementsByName("row"+row)[0];

        sel.childNodes[2].innerHTML = "<input type='text' size='10' value='"+sel.childNodes[2].innerHTML+"'/>";
        sel.childNodes[3].innerHTML = "<input type='text' size='10' value='"+sel.childNodes[3].innerHTML+"'/>";
        for( key in data ){
            if(key == row)
                continue;
            document.getElementsByName("row"+key)[0].innerHTML = data[key];
            delete data[key];
        }   
        icon = sel.lastChild.innerHTML = "<img src='../Images/tick.png' height=20px width=20px onclick='editOK("+row+")'>";
    }
    function editOK(row){
        let sel= document.getElementsByName("row"+row)[0];
        var id = '<?php echo $_SESSION['login'];?>';
        var date = sel.childNodes[0].innerHTML;
        var border = sel.childNodes[1].innerHTML;
        var quan = sel.childNodes[2].firstChild.value;  
        var dquan = sel.childNodes[3].firstChild.value;

        document.write("<form name='update' method='POST'>"+
        "<input type='hidden' name='action' value='edit'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "<input type='hidden' name='quan' value='"+quan+"'>"+
        "<input type='hidden' name='dquan' value='"+dquan+"'>"+
        "<input type='hidden' name='border' value='"+border+"'>"+
        "</form>");

        document.update.submit();
    }
    function deleteRow(row){
        let sel= document.getElementsByName("row"+row)[0];
        var id = '<?php echo $_SESSION['login'];?>';
        var date = sel.childNodes[0].innerHTML;
        var border = sel.childNodes[1].innerHTML;
        var quan = sel.childNodes[2].innerHTML;        
        var dquan = sel.childNodes[3].innerHTML;

        document.write("<form name='delete' method='POST'>"+
        "<input type='hidden' name='action' value='delete'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "<input type='hidden' name='border' value='"+border+"'>"+
        "<input type='hidden' name='quan' value='"+quan+"'>"+
        "<input type='hidden' name='dquan' value='"+dquan+"'>"+
        "</form>");

        document.delete.submit();
    }
</script>
</head>
<body>
      <h1 align="center"><b>INCOME INFORMATION</b></h1>
    <div class="container">
   <div class="table-responsive">
            <table class="table table-bordered">
        <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Border<br>Size</th>
                  <th scope="col">Quantity<br>sold</th>
                  <th scope="col">Damaged<br>Quantity</th>
                  <th scope="col">Income</th>
                  <th scope="col" style="width:10px">Actions</th>
                </tr>
              </thead>
              <tbody>
        <?php
            if ($result->num_rows > 0):
            $i=0;
            while($row = mysqli_fetch_array($result)){
                echo "<tr name='row".$i."'><td>" 
                    . date("d-m-Y", strtotime($row[1])) . "</td><td>"
                    . $row[2] . "</td><td>" 
                    . $row[3] . "</td><td>" 
                    . $row[4] . "</td><td>" 
                    . $row[5] . "</td>
                    <td align='right'><img height='20px' width='20px' onclick='editRow(".$i.")' src='../Images/edit.png'><img height='20px' width='20px' onclick='deleteRow(".$i.")' src='../Images/delete.png'></td></tr>";
                $i++;
            }
            else:?>
            <tr>
                <td colspan="6" rowspan="1" headers="">No Data Found</td>
            </tr>
            <?php endif;?>
    </tbody>
    </table></div></div>
</body>
</html>