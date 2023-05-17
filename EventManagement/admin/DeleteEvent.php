<?php
session_start();
include 'connection.php';
$eventId = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM `events` WHERE `_eventId`=:eventId");
    $stmt->bindParam(':eventId', $eventId);

    if ($stmt->execute()) {
        header('Location: /eventmanagement/admin/dashboard.php');
        exit;
    } else {
        echo "<script>alert('Error deleting event');</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
