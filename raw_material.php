<?php

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
}
$name=$unit=$no_of_units=$description="";
$err="";
if(isset($_POST['submit']))
{
	echo "In isset";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$name = trim($_POST["category_name_modal"]);    
		$unit = trim($_POST['category_unit_modal']);
		$no_of_units = trim($_POST['category_qty_modal']);
		$description = trim($_POST["category_description_modal"]);
		
		$cat_from_db = "SELECT username FROM logIn";
		$cat_r = mysqli_query($link, $user);
		if(cat_r)
		{
			$count=0;
			while($row = mysqli_fetch_assoc($user_r))
			{
				if($row['name']==$cat_name){
						$count= $count+1;
				}
			}
			if($count>0)
			{
				$err= "This category already exist, Please enter some other category.";
			}
			else
			{
				$insert= "INSERT INTO materials (name, unit, no_of_units, description) VALUES('$name', '$unit', '$no_of_units','$description')";
				$insert_r=  mysqli_query($link, $insert);
				//if(mysqli_num_rows($insert_r)==1){
				if($insert_r){
					die("record Successfully added");
				}
			}
		}
			

		
		
		
		
	}
}
else
{
	echo "In else of isset";
}	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        
        <style type="text/css">
        .custom-m{
            width: 249px;
            height: 150px;
            text-align: center;
            margin-top: 77px;
            background:#dae0e5; 
            border-radius: 25px;
            color: brown;
            cursor:pointer;
        }
        div.custom-m:hover {
            background-color:beige;
        }
        </style>
    </head>
    <script>
        $(document).ready(function () {
            $("body").delegate('#category_click', 'click', function (e)
            {
                $("#add_new_category").modal('show');
            });
            
            $("body").delegate('#category_form', 'submit', function (e)
            {
                $("#name").val($("#cater_name_modal").val());
                $("#hours").val($("#cater_hours_modal").val());
                $("#description").val(tinymce.get("cater_description_modal").getContent());
                return true;
            });
            
            
        });
    </script>
    <body>
        <div class="jumbotron" style="padding: 2rem; margin-bottom: 0rem">
            <h1>Put Your logo here</h1>      
        </div>
        <div class="container" style="">
            <div class="custom-m" >
                <div id="category_click" style="padding-top: 60px;">
                    Add Material
                </div>  
            </div>


            <div class="row">
                <div style="display: none;" id="warning-message" class="col-md-8 col-md-offset-2" >
                    <div class="box box-solid alert">
                        <div class="box-header with-border">
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <dl>
                                <dt>No Record Found </dt>
                            </dl>
                            <a href="javascript:void(0);" class="new_category"><button class="btn btn-info pull-right">Add New Category</button></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
              
               
<!--            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Category Type</th>
                            <th>Category Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                      </tr>
                      <tr>
                        <td>Mary</td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                      </tr>
                      <tr>
                        <td>July</td>
                        <td>Dooley</td>
                        <td>july@example.com</td>
                      </tr>
                    </tbody>
                </table>
            </div>-->
        </div>     
             
        
        
        
        
        
        
        
        
        
        
        
    <div id="add_new_category" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!--Modal Contents-->
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
                                <input type="text" name="category_unit_modal" data-toggle="tooltip" required="category_type" Title= "Enter Category Type." class="form-control" id="category_type_modal" value=""   placeholder="" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-top: 20px;">
                            <b class="col-md-3">No of units:</b>
                            <div class="col-md-9">
                                <input type="text" name="category_qty_modal" data-toggle="tooltip" required="category_qty" Title= "Enter Category Quantity." class="form-control" id="category_qty_modal" value=""   placeholder="" />
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
                    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> name="category_form" method="post" id="category_form">
                        <input type="hidden" value="" id="category_id" name="category_id"/>
                        <input type="hidden" value="add_cater"  name="action" />
                        <input type="hidden" value="" id="category_name" name="category_name"/>
                        <input type="hidden" value="" id="category_type" name="category_type"/>
                        <input type="hidden" value="" id="category_qty" name="category_qty"/>
                        <input type="hidden" value="" id="category_description" name="category_description"/>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" name="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
        
    </body>
</html>