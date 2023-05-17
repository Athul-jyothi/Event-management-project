<?php include 'connection.php';
include 'head.php'
?>

<body>
<div class="container-xl">
	<div class="table-responsive">
    <div id="success_message"></div>
		<div class="table-wrapper">
        <div class="table-title">
				<div class="row">
					<div class="col-sm-25">
                       
                  
                    <a href="/eventmanagement/admin/about.php" class="btn btn-success" ><span>ABOUT</span></a>
                    <a href="/eventmanagement/admin/studentslist.php" class="btn btn-success" > <span>STUDENTS</span></a>
                    <a href="/eventmanagement/admin/dashboard.php" class="btn btn-success" > <span>HOME</span></a>
					
                </div>
					
				</div>
			</div>
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Events <b>Participants</b></h2>
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
						<th>Student Name</th>
						<th>Reg No</th>
						<th>Phone</th>
						<th>Date Joined</th>
						<th></th>
						<!-- <th></th>
						<th></th> -->
					</tr>
				</thead>
				<tbody>
                <?php
        try {
                $id=$_GET['id'];
          $stmt = $conn->prepare("SELECT * FROM `user_to_event` INNER JOIN user ON user_to_event._userId = user._userId WHERE user_to_event._eventId=$id;");
          $stmt->execute();
          
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['_uteId'] . "</td>";
			echo "<td>" . $row['_name'] . "</td>";
            echo "<td>" . $row['_userName'] . "</td>";
            echo "<td>" . $row['_userPhone'] . "</td>";
            echo "<td>" . $row['_date'] . "</td>";
            // echo "<td>" . $row['_eventdate'] . "</td>";
            // echo "<td>" . $row['_eventdate'] . "</td>";
           ?><td>
          <a href="/eventmanagement/admin/studentsEventJoined.php/?id=<?php echo $row['_userId'];?>" class="btn btn-blue"><span>VIEW</span></a>
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
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
        
		<div class="modal-content">
        <ul id="saveform_errList"></ul>
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Add Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="name form-control" required>
					</div>
					<div class="form-group">
						<label>Desc</label>
                        <textarea class="sku form-control">
						<!-- <input type="" class="sku form-control" required> -->
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="number" class="price form-control" required>
					</div>
					<div class="form-group">
						<label>Category</label>
						<select class="category form-control" id="select_cat"require>
                            <option value="">ALL</option>
                            <option value="">Computer</option>
                            <option value="">ART</option>
                           
                        </select>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success addproduct" value="Add">
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