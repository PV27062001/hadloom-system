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
        $sql="select * from product order by produced_date";
        if(isset($_POST['action'])){
            $query="select quantity,dquantity from product where empid='".$_POST['id']."' AND produced_date='".date("Y-m-d", strtotime($_POST['date']))."'";
            $result= mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $quantity=$row[0];
            $dquantity=$row[1];
            switch($_POST['action']){
                case "delete": {
                    //to update stock table
                    $query = "update productStock set quantity = quantity-'".$_POST['quan']."', dquantity = dquantity-'".$_POST['dquan']."' where border='".$_POST['border']."'";
                    mysqli_query($conn,$query);

                    //to delete record from product table
                    $sql1="delete from product where empid='".$_POST['id']."' AND produced_date='".date("Y-m-d", strtotime($_POST['date']))."'";
                    mysqli_query($conn,$sql1);

                }break;
                case "edit": {
                    //to update product stock table
                    $quantity = $_POST['quan'] - $quantity;
                    $dquantity = $_POST['dquan'] - $dquantity;
                    $query = "update productStock set quantity = quantity+'".$quantity."', dquantity = dquantity+'".$dquantity."' where border='".$_POST['border']."' ";
                    mysqli_query($conn,$query);

                    //to update product table 
                    $salary=($_POST['quan']*$_POST['border']*10)-($_POST['dquan']*100);
                    $sql2="update product set quantity='".$_POST['quan']."',salary='".$salary."',dquantity='".$_POST['dquan']."', border='".$_POST['border']."' where empid='".$_POST['id']."' AND produced_date='".date("Y-m-d", strtotime($_POST['date']))."'";
                    mysqli_query($conn,$sql2);
                }break;
            }
        }

        $result=mysqli_query($conn,$sql);
        if(!$result)
            echo '<script>alert("Error occured while updating")</script>';
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
        let k = 2;
        while(k<5){
                sel.childNodes[k].innerHTML = "<input type='text' size='8' value='"+sel.childNodes[k].innerHTML+"'/>";
            k++;
        }
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
        var date = sel.childNodes[0].innerHTML;
        var id = sel.childNodes[1].innerHTML;
        var border = sel.childNodes[2].firstChild.value;
        var quan = sel.childNodes[3].firstChild.value;
        var dquan = sel.childNodes[4].firstChild.value;
        var salary = sel.childNodes[5].innerHTML;
        
        document.write("<form name='update' method='POST'>"+
        "<input type='hidden' name='action' value='edit'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "<input type='hidden' name='border' value='"+border+"'>"+        
        "<input type='hidden' name='quan' value='"+quan+"'>"+       
        "<input type='hidden' name='dquan' value='"+dquan+"'>"+
        "<input type='hidden' name='salary' value='"+salary+"'>"+
        "</form>");

        document.update.submit();
    }
    function deleteRow(row){
        let sel= document.getElementsByName("row"+row)[0];

        var date = sel.childNodes[0].innerHTML;
        var id = sel.childNodes[1].innerHTML;
        var border = sel.childNodes[2].innerHTML;
        var quan = sel.childNodes[3].innerHTML;
        var dquan = sel.childNodes[4].innerHTML;

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
      <h1 align="center"><b>PRODUCTS INFORMATION</b></h1>
    <div class="container" style="display: flex; flex-wrap: wrap;">
   <div class="table-responsive">
            <table class="table table-bordered">
        <thead>
                <tr>
                    <th scope="col">Produced Date</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Border Size</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Damaged</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Pending</th>
                  <th scope="col" style="width:10px">Actions</th>
                </tr>
              </thead>
              <tbody>
        <?php
            if ($result->num_rows > 0):
            $i=0;
            while($row = mysqli_fetch_array($result)){
                $pending=10-$row[3];
                echo "<tr name='row".$i."'><td>"
                    . date("d-m-Y", strtotime($row[0])). "</td><td>" 
                    . $row[1] . "</td><td>"
                    . $row[2] . "</td><td>" 
                    . $row[3]."</td><td>" 
                    . $row[4]."</td><td>" 
                    . $row[5]."</td><td>" 
                    . $pending."</td>
                    <td align='right'><img height='20px' width='20px' onclick='editRow(".$i.")' src='../Images/edit.png'><img height='20px' width='20px' onclick='deleteRow(".$i.")' src='../Images/delete.png'></td></tr>";
                $i++;
            }
            else:?>
            <tr>
                <td colspan="8" rowspan="1" headers="">No Data Found</td>
            </tr>
            <?php endif;
        ?>
    </tbody>
    </table></div></div>
</body>
</html>