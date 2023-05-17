<?php
include_once "connection.php";
$realName = $_POST['realName'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$batch = $_POST['batch'];
$password = $_POST['password'];

// Check if username, phone, or email already exists
$check_query = "SELECT * FROM user WHERE _userName=:name OR _userPhone=:phone OR _userEmail=:email";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bindParam(':name', $name);
$check_stmt->bindParam(':phone', $phone);
$check_stmt->bindParam(':email', $email);
$check_stmt->execute();

if ($check_stmt->rowCount() > 0) {
  echo "<script type='text/javascript'>alert('Username, phone number, or email already exists. Please try again with different values.');
  history.back();</script>";
  return;
}

// Insert data into user table
$insert_query = "INSERT INTO user (_name,_userName, _userPhone, _userEmail, _userBatch, _userPassword) VALUES (:realname,:name, :phone, :email, :batch, :password)";
$insert_stmt = $conn->prepare($insert_query);

$insert_stmt->bindParam(':realname', $realName);
$insert_stmt->bindParam(':name', $name);
$insert_stmt->bindParam(':phone', $phone);
$insert_stmt->bindParam(':email', $email);
$insert_stmt->bindParam(':batch', $batch);
$insert_stmt->bindParam(':password', $password);
$insert_stmt->execute();

echo "<script type='text/javascript'>alert('Data inserted successfully.');
window.location.href = '/eventmanagement/admin/loginPage.php';</script>";
?>