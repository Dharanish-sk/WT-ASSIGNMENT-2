<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'freelancer') {
    die("You must be logged in as a freelancer to bid on a job.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = $_POST['job_id'];
    $bid_amount = $_POST['bid_amount'];
    $message = $_POST['message'];
    $freelancer_id = $_SESSION['user_id'];

    $conn = new mysqli("localhost", "root", "", "freelancer_marketplace");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO bids (freelancer_id, job_id, bid_amount, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $freelancer_id, $job_id, $bid_amount, $message);
    $stmt->execute();

    echo "Your bid has been placed!";
    $conn->close();
}
?>
