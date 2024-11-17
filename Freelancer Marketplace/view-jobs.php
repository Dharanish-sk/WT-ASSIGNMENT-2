<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'freelancer') {
    die("You must be logged in as a freelancer to view and bid on jobs.");
}

$conn = new mysqli("localhost", "root", "", "freelancer_marketplace");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM jobs");

echo "<h1>Available Jobs</h1>";

while ($job = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h2>" . $job['title'] . "</h2>";
    echo "<p>" . $job['description'] . "</p>";
    echo "<form action='bid_on_job.php' method='post'>
            <input type='hidden' name='job_id' value='" . $job['id'] . "'>
            <input type='text' name='bid_amount' placeholder='Your bid amount'>
            <textarea name='message' placeholder='Your message'></textarea>
            <input type='submit' value='Place Bid'>
          </form>";
    echo "</div>";
}

$conn->close();
?>
