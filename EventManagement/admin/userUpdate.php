<?php
include 'connection.php';

$userId = $_POST['userId'];

$realname = $_POST['realname'];
$newUsername = $_POST['name'];
$newPhone = $_POST['phone'];
$newEmail = $_POST['email'];
$batch = $_POST['batch'];
$newPassword = $_POST['password'];

$getUserData = $conn->prepare("SELECT * FROM user WHERE _userId = :userId");
$getUserData->bindParam(':userId', $userId);
$getUserData->execute();
$userData = $getUserData->fetch(PDO::FETCH_ASSOC);

$oldUsername = $userData['_userName'];
$oldPhone = $userData['_userPhone'];
$oldEmail = $userData['_userEmail'];

if ($oldUsername != $newUsername) {
    $checkUsernameExists = $conn->prepare("SELECT * FROM user WHERE _userName = :newUsername AND _userId != :userId");
    $checkUsernameExists->bindParam(':newUsername', $newUsername);
    $checkUsernameExists->bindParam(':userId', $userId);
    $checkUsernameExists->execute();
    if ($checkUsernameExists->rowCount() > 0) {
        echo "
        <script>alert('Username already exists');
        window.history.back();</script>";
        exit;
    }
}

if ($oldPhone != $newPhone) {
    $checkPhoneExists = $conn->prepare("SELECT * FROM user WHERE _userPhone = :newPhone AND _userId != :userId");
    $checkPhoneExists->bindParam(':newPhone', $newPhone);
    $checkPhoneExists->bindParam(':userId', $userId);
    $checkPhoneExists->execute();
    if ($checkPhoneExists->rowCount() > 0) {
        echo "<script>alert('Already Exist Phone');
        window.history.back();</script>";
        exit;
    }
}

if ($oldEmail != $newEmail) {
    $checkEmailExists = $conn->prepare("SELECT * FROM user WHERE _userEmail = :newEmail AND _userId != :userId");
    $checkEmailExists->bindParam(':newEmail', $newEmail);
    $checkEmailExists->bindParam(':userId', $userId);
    $checkEmailExists->execute();
    if ($checkEmailExists->rowCount() > 0) {
        echo "<script>alert('Email already exists');
        window.history.back();</script>";
        exit;
    }
}

$updateUser = $conn->prepare("UPDATE user SET _userName = :newUsername, _userPhone = :newPhone, _userEmail = :newEmail, _userPassword = :newPassword, _name = :realname WHERE _userId = :userId");
$updateUser->bindParam(':newUsername', $newUsername);
$updateUser->bindParam(':newPhone', $newPhone);
$updateUser->bindParam(':newEmail', $newEmail);
$updateUser->bindParam(':newPassword', $newPassword);
$updateUser->bindParam(':userId', $userId);
$updateUser->bindParam(':realname', $realname);


if ($updateUser->execute()) {
    echo "<script>alert('User updated successfully');
    window.location.replace('/eventmanagement/admin/studentsdashboard.php');</script>";

}
?>