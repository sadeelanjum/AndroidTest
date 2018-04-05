<?php
require_once 'config.php';

session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
}
$username = $_SESSION['username'];

$name = $count = $unit_price = $description="";

$sql ="SELECT * FROM tools";

$tool = mysqli_query($link, $sql) or die("Some Thing went wrong with connection or DB");
  
if($_SERVER["REQUEST_METHOD"] == "POST")
{
   if($_POST["action"]=="add_tool")
    {
        $name = trim($_POST["tool_name"]);    
        $count = trim($_POST["tool_count"]);
        $unit_price = trim($_POST['tool_unit_price']);
        $description = trim($_POST["tool_description"])." added/updated by".$username;
        $sql ="SELECT * FROM tools";
        $tool_r = mysqli_query($link, $sql) or die("something went wrong with db or connection");
        $count=0;
        while($row = mysqli_fetch_assoc($tool_r))
        {
            if($name==$row['name']){
               $count++;
            }
        }
        if($count >0){
            $_SESSION['Error'] = "You Can't Add Same Tool More Than Once.";
        }
        else
        {
            $insert= "INSERT INTO tools (name, count, unit_price, description) VALUES('$name', '$count', '$unit_price','$description')";
            $insert_r=  mysqli_query($link, $insert) or die("Something Went Wrong With query or connection During Adding new Category");
            if($insert_r){
                header("location: manage_tools.php"); 
            }
        }
    }
    
    if($_POST["action"]=="update_tool")
    {
        $name = trim($_POST["tool_name"]);    
        $count = trim($_POST["tool_count"]);
        $unit_price = trim($_POST['tool_unit_price']);
        $description = trim($_POST["tool_description"])." added/updated by".$username;
        $sql = "UPDATE tools SET count='$count', unit_price= '$unit_price', description = '$description' WHERE name='$name'";
        $update_r = mysqli_query($link, $sql) or die("ERROR EORROR in YOUR QUERY");
        if($insert_r){
            header("location: manage_tools.php");
        }
    }
    
    if($_POST["action"]=="delete_tool")
    {
        $name= trim($_POST["tool_dname"]);
        $sql = "DELETE FROM tools WHERE tools.name='$name'";
        $delete_r = mysqli_query($link, $sql) or die("Coulde not delete something went wrong with db or query");
        if($delete_r){
            header("location: manage_tools.php");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Raw Material</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        
        <style type="text/css">
            th
            {
                background-color: #4CAF50;
                color: white;        
            }
        </style>
    </head>
    <script>
        $(document).ready(function () {
            $("body").delegate('.tool_click', 'click', function (e)
            {
                $("#add_new_tool").find('.action').val("add_tool");
                $("#add_new_tool").find('.modal-title').html("Add New Tool");
                $("#add_new_tool").find('.btn-primary').html("Add");
                
                $("#tool_name_modal").val("");
                $("#tool_count_modal").val("");
                $("#tool_unit_price_modal").val("");
                $("#add_new_tool").modal('show');
            });
            
            $("body").delegate('#tool_form', 'submit', function (e)
            { 
                var tool_name= $("#tool_name_modal").val();
                var tool_count = $("#tool_count_modal").val();
                var unit_price = $("#tool_unit_price_modal").val();
                var tool_desc = $("#tool_description_modal").val();
                console.log(tool_desc);
                if(tool_name=='' || tool_count == '' || unit_price == '' || tool_desc == ''){
                  alert("No field can be empty, Please fill all the fields");
                    return false;
                }
                else{
                    $("#tool_name").val(tool_name);
                    $("#tool_count").val(tool_count);
                    $("#tool_unit_price").val(unit_price);
                    $("#tool_description").val(tool_desc);
                    return true;
                }
            });
            
            $("body").delegate('.update_tool', 'click', function (e)
            { 
                e.preventDefault();
                $("#add_new_tool").find('.action').val("update_tool");
                $("#add_new_tool").find('.modal-title').html("Update Tool");
                $("#add_new_tool").find('.btn-primary').html("Update");
              
                var name = $(this).closest('tr').find("#name").html();
                var count = $(this).closest('tr').find("#count").html();
                var unit_price = $(this).closest('tr').find("#unit_price").html();
                             
                $("#tool_name_modal").val(name).change();
                $("#tool_count_modal").val(count).change();
                $("#tool_unit_price_modal").val(unit_price).change();
                $("#add_new_tool").modal('show');
            });
            var d_name
             $("body").delegate('.delete_tool', 'click', function (e) 
            {  console.log("deleld,eldel");
                d_name = $(this).closest('tr').find("#name").html();
                $("#delete_modal").find('.delete_message').html("Are you sure you want to delete the Tool "+d_name);
                $("#delete_modal").modal("show");
            });
            
            $("body").delegate('#delete_form', 'submit', function (e)
            {
                $("#tool_dname").val(d_name);
                $("#delete_modal").find('.action').val("delete_tool");
                return true;
            });
            $( "#loader" ).fadeOut(5000);
        });
    </script>
    <body>
        
        <div class="jumbotron" style="padding: 2rem; margin-bottom: 0rem">
            <h1>Put Your logo here</h1>      
        </div>
        <div class="container" style="">
            <?php 
            if(isset($_SESSION['Error']))
            {
                echo '<div id="loader" style="margin-top:30px; margin-bottom:30px; background:red; color:white; height:40px;"><p style="padding:10px;">'; echo $_SESSION['Error'];echo '</p></div>';
                unset($_SESSION['Error']);
            }
            
            if($tool->num_rows == 0){
             echo "<div class='row'>
                <div  class='warning-message col-md-8 col-md-offset-2' >
                    <div class='box box-solid alert'>
                        <div class='box-header with-border'>
                        </div>
                        <!-- /.box-header -->
                        <div class='box-body'>
                            <dl>
                                <dt>No Record in DataBase ,Please Add  </dt>
                            </dl>
                            <a  class='tool_click'><button class='btn btn-info pull-right'>Add New Tool</button></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>";
             echo "<div class='row'>
                <div  class='col-md-8 col-md-offset-2' >
                    <div class='box box-solid alert'>
                        <div class='box-header with-border'>
                        </div>
                        <!-- /.box-header -->
                        <div class='box-body'>
                            <a  href='/dashboard.php'><button class='btn btn-info pull-left'>Go Back</button></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>";
            }
            else
            {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-hover' style='margin-top:30px;'>";
                echo "<tr> <th> Tool Name </th> <th> Tool Count </th><th> Tool Unit Price </th> <th> Action </th> <th> Action </th> </tr>";
                echo "<tr>";
                $count=0;
                while($row = mysqli_fetch_assoc($tool))
                {
                    echo "<tr>";
                    echo "<td id='name'>" . $row["name"] . "</td>";
                    echo "<td id='count'>" . $row["count"]  . "</td>";
                    echo "<td id='unit_price'>" . $row["unit_price"]  . "</td>";
                    echo "<td class='update_tool' style='color:deepskyblue; cursor:pointer;'> Update 
                        </td>";
                    echo "<td class='delete_tool' style='color:deepskyblue; cursor:pointer;'> Delete 
                        </td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "<div class='row'>
                            <div  class='warning-message col-md-8 col-md-offset-2' >
                                <div class='box box-solid alert'>
                                    <div class='box-header with-border'>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class='box-body'>
                                        <a  class='tool_click'><button class='btn btn-info pull-right'>Add New Tool</button></a>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div  class='col-md-8 col-md-offset-2' >
                                <div class='box box-solid alert'
                                    <div class='box-header with-border'>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class='box-body'>
                                        <a  href='/dashboard.php'><button class='btn btn-info pull-left'>Go Back</button></a>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>";
            }?>
        </div> 
        
        <!--ADD/UPDATE MODAL-->
        <div id="add_new_tool" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                Modal Contents
                <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title">Add New Tool</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="task-detail">
                            <div class="col-md-12">
                                <b class="col-md-3">Tool Name:</b>
                                <div class="col-md-9">
                                    <input type="text" name="tool_name_modal" data-toggle="tooltip" required="category_name" Title= "Enter Tool Name." class="form-control" id="tool_name_modal" value="" />
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3">Tool Count:</b>
                                <div class="col-md-9">
                                    <input type="text" name="tool_count_modal" data-toggle="tooltip" required="required" Title= "Enter Tool Count." class="form-control" id="tool_count_modal" value=""  />
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3">Unit Price:</b>
                                <div class="col-md-9">
                                    <input type="text" name="tool_unit_price_modal" data-toggle="tooltip" required="required" Title= "Enter Tool's Unit Price." class="form-control" id="tool_unit_price_modal" value=""   />
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3"> Description:</b>
                                <div class="col-md-9">
                                    <textarea class="regular-textarea" required="required" id="tool_description_modal" name="tool_description_modal" placeholder="">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="tool_form" method="post" id="tool_form">
                            <input type="hidden" value=""  name="action" class = "action" />
                            <input type="hidden" value="" id="tool_name" name="tool_name"/>
                            <input type="hidden" value="" id="tool_count" name="tool_count"/>
                            <input type="hidden" value="" id="tool_unit_price" name="tool_unit_price"/>
                            <input type="hidden" value="" id="tool_description" name="tool_description"/>
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                        </form>
                    </div>            
                </div>
            </div>
        </div>
        
        
          <!-- Delete Modal-->
        <div id="delete_modal" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Delete Tool</h4>
                    </div>
                    <div class="modal-body">
                        <p class = "delete_message">Are you sure you want to delete  !!!</p>
                    </div>
                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="delete_form" id="delete_form">
                            <input type="hidden" value=""  name="action" class = "action" />
                            <input type="hidden" value="" id="tool_dname" name="tool_dname"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>