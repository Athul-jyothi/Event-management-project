<?php
session_start();
include 'connection.php';
$eventId = $_POST['id'];
$name = $_POST['name'];
$desc = $_POST['desc'];
$date = $_POST['date'];
$batch = $_POST['batch'];
$_isActive = $_POST['_isActive'];
$adminId = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("UPDATE `events` SET `_eventName`=:name, `_eventDesc`=:desc, `_eventBatch`=:batch, `_eventdate`=:date, `_isCreated`=:_id,`_isActive`=:_isActive  WHERE `_eventId`=:eventId");
    $stmt->bindParam(':eventId', $eventId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':batch', $batch);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':_isActive', $_isActive);
    $stmt->bindParam(':_id', $adminId);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "<script>alert('Error updating event');</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
