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
        $sql="select * from outgoing";
        if(isset($_POST['action'])){
            switch($_POST['action']){
                case "delete": {
                    //to update stock table
                    $query = "update materialStock set count = count+1 where mid = '".$_POST['mid']."' ";
                    mysqli_query($conn,$query);

                    //to delete record from outgoing table
                    $sql1="delete from outgoing where oid='".$_POST['id']."'";
                    mysqli_query($conn,$sql1);
                }break;
                case "edit": {
                    //to update record from outgoing table
                    $sql2="update outgoing set empid='".$_POST['empid']."',mid='".$_POST['mid']."',odate='".date("Y-m-d", strtotime($_POST['date']))."' where oid='".$_POST['id']."'";
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
        var mid = sel.childNodes[3].innerHTML;
        let k = 1;
        while(k<4){
                sel.childNodes[k].innerHTML = "<input type='text' size='10' value='"+sel.childNodes[k].innerHTML+"'/>";
            k++;
        }
        for( key in data ){
            if(key == row)
                continue;
            document.getElementsByName("row"+key)[0].innerHTML = data[key];
            delete data[key];
        }
        icon = sel.lastChild.innerHTML = "<img src='../Images/tick.png' height=20px width=20px onclick='editOK("+row+mid+")'>";
    }
    function editOK(row,mid){
        let sel= document.getElementsByName("row"+row)[0];
        var id = sel.childNodes[0].innerHTML;
        var date = sel.childNodes[1].firstChild.value;
        var empid = sel.childNodes[2].firstChild.value;
        var newmid = sel.childNodes[3].firstChild.value;

        document.write("<form name='update' method='POST'>"+
        "<input type='hidden' name='action' value='edit'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='date' value='"+date+"'>"+
        "<input type='hidden' name='empid' value='"+empid+"'>"+
        "<input type='hidden' name='mid' value='"+mid+"'>"+
        "<input type='hidden' name='mid' value='"+newmid+"'>"+
        "</form>");

        document.update.submit();
    }
    function deleteRow(row){
        let sel= document.getElementsByName("row"+row)[0];

        var id = sel.childNodes[0].innerHTML;
        var mid = sel.childNodes[3].innerHTML;


        document.write("<form name='delete' method='POST'>"+
        "<input type='hidden' name='action' value='delete'>"+
        "<input type='hidden' name='id' value='"+id+"'>"+
        "<input type='hidden' name='mid' value='"+mid+"'>"+
        "</form>");

        document.delete.submit();
    }
</script>
</head>
<body>
    <h1 align="center"><b>OUTGOING MATERIALS INFORMATION</b></h1>
    <div class="container">
    <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Outgoing ID</th>
            <th scope="col">Date</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Material ID</th>
            <th scope="col" style="width:10px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($result->num_rows > 0):
            $i=0;
            while($row = mysqli_fetch_array($result)){
                echo "<tr name='row".$i."'><td>" 
                    . $row[0] . "</td><td>"
                    .date("d-m-Y", strtotime($row[1])). "</td><td>" 
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