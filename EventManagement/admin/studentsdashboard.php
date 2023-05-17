<?php
session_start();
$TodayDate= date("d-m-Y");
if (empty($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit;
}
if($_SESSION['adminId']==1){
	header("Location: /eventmanagement/admin/dashborad.php");
}
$batchIds = $_SESSION['_userbatch'];
include 'connection.php';
include 'head.php';
$userId=$_SESSION['user_id']

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
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"> <span>PROFILE</span></a>
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
						<!-- <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Event</span></a>
											 -->
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
					
					
					</tr>
				</thead>
				<tbody>
                <?php
        try {
			$stmt = $conn->prepare("SELECT events._eventId, events._eventName, events._eventDesc, events._eventdate, events._eventBatch, events._isActive, 
			(SELECT user_to_event._userId FROM user_to_event WHERE user_to_event._userId = :userId AND user_to_event._eventId = events._eventId) AS joined
			FROM events 
			WHERE events._eventBatch IN (1,0) 
			ORDER BY events._eventdate DESC;");
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
					$i = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$originalDate = $row['_eventdate'];
$newDate = date("d-m-Y", strtotime($originalDate));
            echo "<tr";
if ($row['_isActive'] == 2) {
    echo " style='background-color: lightyellow;'";
}
elseif($newDate<=$TodayDate) {
    echo " style='background-color: lightgreen;'";
}
// elseif($newDate<=$TodayDate)
// {
// 	echo " style=;'";
// }
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
           
           ?>
		  <td>
			<?php
			if($row['_isActive'] == 2)
			{
				?>
				 <a href="" class="btn btn-blue"><span>EVENT CANCELLED</span></a>
				<?php
			}
			elseif($newDate>$TodayDate){
			if ($row['joined'] == $userId) {
				?>
           <a href="" class="btn btn-blue"><span>JOINED</span></a>
		   <?php
			}
			else{
		   ?>
           <a href="JoinEvent.php/?eventid=<?php echo $row['_eventId']; ?>&userid=<?php echo $userId; ?>" class="btn btn-blue"><span>JOIN</span></a>
		   <?php
			}
			
		}
		
		elseif($newDate==$TodayDate){
			?>
			 <a href="" class="btn btn-blue"><span>EVENT ONGOING</span></a>
			<?php
		}
		else{


			?>
			 <a href="" class="btn btn-blue"><span>EVENT FINISHED</span></a>
			<?php
		}
		
		   ?>
          </td>
		  
		
          </tr>
		

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
<?php
        try {
          $stmt = $conn->prepare("SELECT *FROM user where _userId =$userId;");
          $stmt->execute();
          
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
          
          
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
        
		<div class="modal-content">
        <ul id="saveform_errList"></ul>
			<form action="userUpdate.php" method="post">
				<div class="modal-header">						
					<h4 class="modal-title">EDIT PROFILE</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
				<div class="form-group">
						<label>Name</label>
						<input type="text" name="realname" class="name form-control" value="<?php echo $row['_name']; ?>" required>
						
					</div>					
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="name form-control" value="<?php echo $row['_userName']; ?>" required>
						<input type="hidden" name="userId" class="name form-control" value="<?php echo $row['_userId']; ?>" required>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" name="phone" class="name form-control" value="<?php echo $row['_userPhone']; ?>" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" class="name form-control" value="<?php echo $row['_userEmail']; ?> " required>
					</div>
					<div class="form-group">
					<label>Password</label>
						<input type="password" name="password" class="name form-control" value="<?php echo $row['_userPassword']; ?> " required>
					</div>
					<div class="form-group">
						<label>Event Status</label>
						<select name="batch" class="category form-control" id="select_cat" value="<?php echo $row['_userbatch'];?>" require>
						<option value="0" <?php if ($row['_userbatch'] == 1) echo 'selected'; ?>>CSE</option>
    <option value="1" <?php if ($row['_userbatch'] == 2) echo 'selected'; ?>>ARTS & SCIENCE</option>
    <option value="2" <?php if ($row['_userbatch'] == 3) echo 'selected'; ?>>Bio Tech</option>
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