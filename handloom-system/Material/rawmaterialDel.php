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
        $sql="select * from rawmaterial order by bdate";
        if(isset($_POST['action'])){
            $query="select quantity from rawmaterial where mid='".$_POST['id']."' AND bdate='".date("Y-m-d", strtotime($_POST['date']))."' ";
            $result= mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $quantity=$row[0];
            switch($_POST['action']){
                case "delete": {
                    //to update stock table
                    $query = "update materialStock set count = count-'".$quantity."' where mid='".$_POST['id']."'";
                    mysqli_query($conn,$query);

                    //to delete record from rawmaterial table
                    $sql1="delete from rawmaterial where mid='".$_POST['id']."' AND bdate='".date("Y-m-d", strtotime($_POST['date']))."'";
                    mysqli_query($conn,$sql1);
                }break;
                case "edit": {
                    //to update stock table
                    $quantity = $_POST['quan'] - $quantity;
                    $query = "update materialStock set count = count+'".$quantity."' where mid='".$_POST['id']."'";
                    mysqli_query($conn,$query);

                    //to update rawmaterial table
                    $query="select mcost from material where mid='".$_POST['id']."' ";
                    $result=mysqli_query($conn,$query);
                    $row=mysqli_fetch_row($result);
                    $cost=$row[0]*$_POST['quan'];
                    $sql2="update rawmaterial set quantity='".$_POST['quan']."',cost='".$cost."' where mid='".$_POST['id']."' AND bdate='".date("Y-m-d", strtotime($_POST['date']))."'";
                    mysqli_query($conn,$sql2);
                }break;
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
        var quan = sel.childNodes[2].firstChild.value;
        
        document.write("<form name='update' method='POST'>"+
        "<input type='hidden' name='action' value='edit'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "<input type='hidden' name='quan' value='"+quan+"'>"+
        "</form>");

        document.update.submit();
    }
    function deleteRow(row){
        let sel= document.getElementsByName("row"+row)[0];

        var date = sel.childNodes[0].innerHTML;
        var id = sel.childNodes[1].innerHTML;
        document.write("<form name='delete' method='POST'>"+
        "<input type='hidden' name='action' value='delete'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "</form>");

        document.delete.submit();
    }
</script>
</head>
<body>
      <h1 align="center"><b>PURCHASED MATERIALS INFORMATION</b></h1>
    <div class="container">
   <div class="table-responsive">
            <table class="table table-bordered">
        <thead>
                <tr>
                  <th scope="col">Purchased Date</th>
                  <th scope="col">Material ID</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Cost</th>
                  <th scope="col" style="width:10px">Actions</th>
                </tr>
              </thead>
              <tbody>
        <?php
            if ($result->num_rows > 0):
            $i=0;
            while($row = mysqli_fetch_array($result)){
                echo "<tr name='row".$i."'><td>" 
                    . date("d-m-Y", strtotime($row[0])) . "</td><td>" 
                    . $row[1] . "</td><td>"
                    . $row[2] . "</td><td>" 
                    . $row[3] . "</td>
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