<?php
session_start();
include 'connection.php';
$eventId = $_GET['eventid'];
$userId = $_GET['userid'];

try {
    $stmt = $conn->prepare("INSERT INTO `user_to_event`(`_userId`, `_eventId`) VALUES ($userId,$eventId);");


    if ($stmt->execute()) {
        header('Location: /eventmanagement/admin/studentsdashboard.php');
        exit;
    } else {
        echo "<script>alert('Error deleting event');</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
