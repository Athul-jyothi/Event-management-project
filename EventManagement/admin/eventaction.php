<?php
session_start();
include 'connection.php';
  $name = $_POST['name'];
  $desc = $_POST['desc'];
  $date = $_POST['date'];
  $batch = $_POST['batch'];
  $adminId=$_SESSION['user_id'];


  try {
    $stmt = $conn->prepare("INSERT INTO `events`(`_eventName`, `_eventDesc`, `_eventBatch`, `_eventdate`,`_isCreated`) VALUES (:name,:desc,:batch,:date,:_id)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':desc', $desc);
	$stmt->bindParam(':batch', $batch);
	$stmt->bindParam(':date', $date);
  $stmt->bindParam(':_id', $adminId);

	

    if($stmt->execute()) {
		header('Location: dashboard.php');
	  
      exit;
    } else {
      echo "<script>alert('err');</script>";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
?>