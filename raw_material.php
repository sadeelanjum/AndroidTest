<?php
require_once 'config.php';
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
}
$username = $_SESSION['username'];

$name = $unit = $no_of_units = $description="";

$sql ="SELECT * FROM materials";

$material = mysqli_query($link, $sql) or die("Some Thing went wrong with connection or DB");

  
if($_SERVER["REQUEST_METHOD"] == "POST")
{
   if($_POST["action"]=="add_category")
    {
        $name = trim($_POST["category_name"]);    
        $unit = trim($_POST["category_unit"]);
        $no_of_units = trim($_POST['category_no_of_unit']);
        $description = trim($_POST["category_description"])." added/updated by".$username;
        $sql ="SELECT * FROM materials";
        $cat_r = mysqli_query($link, $sql) or die("something went wrong with db or connection");
        $count=0;
        while($row = mysqli_fetch_assoc($cat_r))
        {
            if($name==$row['name']){
               $count++;
            }
        }
        if($count >0){
            $_SESSION['Error'] = "You Can't Add Same Category More Than Once.";
        }
        else
        {
            $insert= "INSERT INTO materials (name, unit, no_of_units, description) VALUES('$name', '$unit', '$no_of_units','$description')";
            $insert_r=  mysqli_query($link, $insert) or die("Something Went Wrong With query or connection During Adding new Category");
            if($insert_r){
                header("location: raw_material.php"); 
            }
        }
    }
    
    if($_POST["action"]=="update_category")
    {
        $name = trim($_POST["category_name"]);    
        $unit = trim($_POST["category_unit"]);
        $no_of_units = trim($_POST['category_no_of_unit']);
        $description = trim($_POST["category_description"])." added/updated by".$username;
        $sql = "UPDATE materials SET unit='$unit', no_of_units= '$no_of_units', description = '$description' WHERE name='$name'";
        $update_r = mysqli_query($link, $sql) or die("ERROR EORROR in YOUR QUERY");
        if($insert_r){
            header("location: raw_material.php");
        }
    }
    
    if($_POST["action"]=="delete_category")
    {
        $name= trim($_POST["category_dname"]);
        $sql = "DELETE FROM materials WHERE materials.name='$name'";
        $delete_r = mysqli_query($link, $sql) or die("COulde not delete something went wrong with db or query");
        if($delete_r){
            header("location: raw_material.php");
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
            $("body").delegate('.category_click', 'click', function (e)
            {
                $("#add_new_category").find('.action').val("add_category");
                $("#add_new_category").find('.modal-title').html("Add New Category");
                $("#add_new_category").find('.btn-primary').html("Add");
                
                $("#category_name_modal").val("");
                $("#category_unit_modal").val("");
                $("#category_no_of_unit_modal").val("");
                $("#add_new_category").modal('show');
            });
            
            $("body").delegate('#category_form', 'submit', function (e)
            { 
                var cat_name= $("#category_name_modal").val();
                var cat_unit = $("#category_unit_modal").val();
                var no_of_unit = $("#category_no_of_unit_modal").val();
                var cat_desc = $("#category_description_modal").val();
                console.log(cat_desc);
                if(cat_name=='' || cat_unit == '' || no_of_unit == '' || cat_desc == ''){
                  alert("No field can be empty, Please fill all the fields");
                    return false;
                }
                else{
                    $("#category_name").val(cat_name);
                    $("#category_unit").val(cat_unit);
                    $("#category_no_of_unit").val(no_of_unit);
                    $("#category_description").val(cat_desc);
                    return true;
                }
            });
            
            $("body").delegate('.update_category', 'click', function (e)
            { 
                e.preventDefault();
                $("#add_new_category").find('.action').val("update_category");
                $("#add_new_category").find('.modal-title').html("Update Category");
                $("#add_new_category").find('.btn-primary').html("Update");
              
                var name = $(this).closest('tr').find("#name").html();
                var unit = $(this).closest('tr').find("#unit").html();
                var no_of_units = $(this).closest('tr').find("#no_of_units").html();
                             
                $("#category_name_modal").val(name).change();
                $("#category_unit_modal").val(unit).change();
                $("#category_no_of_unit_modal").val(no_of_units).change();
                $("#add_new_category").modal('show');
            });
            var d_name
             $("body").delegate('.delete_category', 'click', function (e) 
            {  console.log("deleld,eldel");
                d_name = $(this).closest('tr').find("#name").html();
                $("#delete_modal").find('.delete_message').html("Are you sure you want to delete the Category "+d_name);
                $("#delete_modal").modal("show");
            });
            
            $("body").delegate('#delete_form', 'submit', function (e)
            {
                $("#category_dname").val(d_name);
                $("#delete_modal").find('.action').val("delete_category");
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
            if($material->num_rows == 0){
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
                            <a  class='category_click'><button class='btn btn-info pull-right'>Add New Category</button></a>
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
                echo "<tr> <th> Category Name </th> <th> Category Unit </th><th> No of Units </th> <th> Action </th> <th> Action </th> </tr>";
                echo "<tr>";
                $count=0;
                while($row = mysqli_fetch_assoc($material))
                {
                    echo "<tr>";
                    echo "<td id='name'>" . $row["name"] . "</td>";
                    echo "<td id='unit'>" . $row["unit"]  . "</td>";
                    echo "<td id='no_of_units'>" . $row["no_of_units"]  . "</td>";
                    echo "<td class='update_category' style='color:deepskyblue; cursor:pointer;'> Update 
                        </td>";
                    echo "<td class='delete_category' style='color:deepskyblue; cursor:pointer;'> Delete 
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
                                        <a  class='category_click'><button class='btn btn-info pull-right'>Add New Category</button></a>
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
        <div id="add_new_category" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                Modal Contents
                <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title">Add New Category</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="task-detail">
                            <div class="col-md-12">
                                <b class="col-md-3">Category Name:</b>
                                <div class="col-md-9">
                                    <input type="text" name="category_name_modal" data-toggle="tooltip" required="category_name" Title= "Enter Category Name." class="form-control" id="category_name_modal" value=""   placeholder="" />
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3">Category unit:</b>
                                <div class="col-md-9">
                                    <input type="text" name="category_unit_modal" data-toggle="tooltip" required="required" Title= "Enter Category Type." class="form-control" id="category_unit_modal" value=""   placeholder="" />
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3">No of units:</b>
                                <div class="col-md-9">
                                    <input type="text" name="category_no_of_unit_modal" data-toggle="tooltip" required="required" Title= "Enter Category Quantity." class="form-control" id="category_no_of_unit_modal" value=""   placeholder="" />
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-top: 20px;">
                                <b class="col-md-3"> Description:</b>
                                <div class="col-md-9">
                                    <textarea class="regular-textarea" required="required" id="category_description_modal" name="category_description_modal" placeholder="">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="category_form" method="post" id="category_form">
                            <input type="hidden" value=""  name="action" class = "action" />
                            <input type="hidden" value="" id="category_name" name="category_name"/>
                            <input type="hidden" value="" id="category_unit" name="category_unit"/>
                            <input type="hidden" value="" id="category_no_of_unit" name="category_no_of_unit"/>
                            <input type="hidden" value="" id="category_description" name="category_description"/>
                            <button type="submit" name="cat_submit" class="btn btn-primary">Add</button>
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
                        <h4 class="modal-title">Delete Category</h4>
                    </div>
                    <div class="modal-body">
                        <p class = "delete_message">Are you sure you want to delete  !!!</p>
                    </div>
                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="delete_form" id="delete_form">
                            <input type="hidden" value=""  name="action" class = "action" />
                            <input type="hidden" value="" id="category_dname" name="category_dname"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>