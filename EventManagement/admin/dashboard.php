<?php
$TodayDate= date("d-m-Y");
$TodayYMD= date("Y-m-d");
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit;
}
if($_SESSION['adminId']==0){
	header("Location: /eventmanagement/admin/studentsdashboard.php");
}
include 'connection.php';
include 'head.php';

?>

<body>
<div class="container-xl">
	<div class="table-responsive">
    <div id="success_message"></div>
		<div class="table-wrapper">
        <div class="table-title">
				<div class="row">
					<div class="col-sm-25">
                       
					<a href="/eventmanagement/admin/LoginPage.php" class="btn btn-success" ><span>LOGOUT</span></a>
					<a href="/eventmanagement/admin/about.php" class="btn btn-success" ><span>ABOUT</span></a>
                    <a href="/eventmanagement/admin/studentslist.php" class="btn btn-success" > <span>STUDENTS</span></a>
                    <a href="/eventmanagement/admin/dashboard.php" class="btn btn-success" > <span>HOME</span></a>
					
					
                </div>
					
				</div>
			</div>
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Events <b>List</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Event</span></a>
											
					</div>
				</div>
			</div>

			<table class="table table-striped table-hover">
                <!-- <center>
            <form action="" method="post">
  <label for="fromDate">From:</label>
  <input type="date" id="fromDate" name="fromDate">
  <label for="toDate">To:</label>
  <input type="date" id="toDate" name="toDate">
  <input type="submit" name="submit" value="Filter">
</form>
                </center> -->
				<thead>
					<tr>
                        <th></th>
						<th>EventName</th>
						<th>EventDetails</th>
						<th>Batch</th>
						<th>Date</th>
						<th></th>
						<th></th>
					
					</tr>
				</thead>
				<tbody>
                <?php
        try {
          $stmt = $conn->prepare("SELECT _eventId, _eventName, _eventDesc, _eventdate, _eventBatch, _isActive
		  FROM events
		  ORDER BY _eventdate DESC
		  ");
          $stmt->execute();
          $i=1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr";
			$originalDate = $row['_eventdate'];
			$newDate = date("d-m-Y", strtotime($originalDate));
			if ($row['_isActive'] == 2) {
				echo " style='background-color: lightyellow;'";
			}
			elseif($newDate<=$TodayDate) {
				echo " style='background-color: lightgreen;'";
			}
			
if ($row['_isActive'] == 1) {
    echo " style='background-color: lightgreen;'";
}
elseif($row['_isActive'] == 2) {
    echo " style='background-color: lightyellow;'";
}
echo ">";
            echo "<td>" . $i++ . "</td>";
            echo "<td>" . $row['_eventName'] . "</td>";
            echo "<td>" . $row['_eventDesc'] . "</td>";
			$batchId=$row['_eventBatch'];
			if($batchId==0){
				echo "<td>ALL</td>";
			}
			elseif($batchId==1){
				echo "<td>CSE</td>";
			}
			elseif($batchId==2){
				echo "<td>ART&SCIENCE</td>";
			}
			else{
				echo "<td>Bio Tech</td>";
			}
            
            echo "<td>" . $newDate . "</td>";
           
           ?><td>
           <a href="singleeventData.php/?id=<?php echo $row['_eventId'];?>" class="btn btn-blue"><span>VIEW</span></a>
          </td>
		  <td>
           <a href="DeleteEvent.php/?id=<?php echo $row['_eventId'];?>" class="btn btn-blue"><span>DELETE</span></a>
          </td>
		  <td>
           <a href="#addEmployeeModal<?php echo $row['_eventId'];?>" class="btn btn-blue" data-toggle="modal"><span>EDIT</span></a>
          
		</td>
		
          </tr>
		  <div id="addEmployeeModal<?php echo $row['_eventId'];?>" class="modal fade">
	<div class="modal-dialog">
        
		<div class="modal-content">
        <ul id="saveform_errList"></ul>
			<form action="eventUpdate.php" method="post">
				<div class="modal-header">						
					<h4 class="modal-title">Edit Event</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="name form-control" value="<?php echo $row['_eventName'];?>" required>
						<input type="hidden" name="id" class="name form-control" value="<?php echo $row['_eventId'];?>" required>
					</div>
					<div class="form-group">
						<label>Desc</label>
						<textarea name="desc" class="name form-control" ><?php echo $row['_eventDesc'];?></textarea>
						<!-- <input type="text" name="" class="sku form-control" required> -->
					</div>
					<div class="form-group">
						<label>Date</label>
						<input type="date" name="date" class="price form-control" value="<?php echo $row['_eventdate']; ?>" min="<?php echo $TodayYMD;?>" required>
					</div>
					<div class="form-group">
						<label>Event Batch</label>
						<select name="batch" class="category form-control" id="select_cat" value="<?php echo $row['_eventBatch'];?>" require>
						<option value="0" <?php if ($row['_eventBatch'] == 0) echo 'selected'; ?>>ALL</option>
						<option value="1" <?php if ($row['_eventBatch'] == 1) echo 'selected'; ?>>CSE</option>
    <option value="2" <?php if ($row['_eventBatch'] == 2) echo 'selected'; ?>>ARTS & SCIENCE</option>
    <option value="3" <?php if ($row['_eventBatch'] == 3) echo 'selected'; ?>>Bio Tech</option>
                        </select>
					</div>
					<div class="form-group">
						<label>Event Status</label>
						<select name="_isActive" class="category form-control" id="select_cat" value="<?php echo $row['_isActive'];?>" require>
						<option value="0" <?php if ($row['_isActive'] == 0) echo 'selected'; ?>>Upcoming</option>
    <option value="1" <?php if ($row['_isActive'] == 1) echo 'selected'; ?>>Event Finished</option>
    <option value="2" <?php if ($row['_isActive'] == 2) echo 'selected'; ?>>Event Cancelled</option>
                        </select>
					</div>
					
					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" name="submit" class="btn btn-success" value="Update">
				</div>
			</form>
		</div>
	</div>
</div>

          <?php 
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        ?>      
        <!-- <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td> -->

				</tbody>
			</table>
			
		</div>
	</div>        
</div>
<!-- Edit Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
        
		<div class="modal-content">
        <ul id="saveform_errList"></ul>
			<form action="eventaction.php" method="post">
				<div class="modal-header">						
					<h4 class="modal-title">Add Event</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="name form-control" required>
					</div>
					<div class="form-group">
						<label>Desc</label>
						<textarea name="desc" class="name form-control" ></textarea>
						<!-- <input type="text" name="" class="sku form-control" required> -->
					</div>
					<div class="form-group">
						<label>Date</label>
						<input type="date" name="date" class="price form-control" min="<?php echo $TodayYMD;?>"required>
					</div>
					<div class="form-group">
						<label>Category</label>
						<select name="batch" class="category form-control" id="select_cat"require>
                            <option value="0">ALL</option>
							<option value="1">CSE</option>
							<option value="2">ARTS & SCIENCE</option>
							<option value="3">Bio Tech</option>
                           
                        </select>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" name="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
            <ul id="updateform_errList"></ul>
			<form id="edit_form">
				<div class="modal-header">
                    <input type="hidden" id="edit_product_id">
                <ul id="updateform_errList"></ul>						
					<h4 class="modal-title">Edit Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" id="edit_product_name" class="form-control" required>
					</div>
					<div class="form-group">
						<label>SKU</label>
						<input type="text" id="edit_product_sku" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="number" class="form-control" id="edit_product_price" required>
					</div>
					<div class="form-group">
						<label>Prev Category</label>
						<input type="text" class="form-control" id="edit_product_category_prev" readonly>
					</div>
					
					 <div class="form-group">
						<label>Category</label>
						<select class="category form-control" id="edit_product_category"require>
                            <!-- <option value="" id="edit_cat">SELECT CATEGORY</option> -->
                           
                        </select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info update_product" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
                    <input type="hidden" id="delete_product_id">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger confirm_delete_product" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<script>