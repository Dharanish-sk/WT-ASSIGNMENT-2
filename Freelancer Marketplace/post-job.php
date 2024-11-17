<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    die("You must be logged in as an employer to post a job.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $employer_id = $_SESSION['user_id'];

    $conn = new mysqli("localhost", "root", "", "freelancer_marketplace");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO jobs (title, description, employer_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $employer_id);
    $stmt->execute();

    echo "Job posted successfully!";
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Job</title>
</head>
<body>
    <form action="post_job.php" method="post">
        <label for="title">Job Title:</label><br>
        <input type="text" name="title" required><br>
        <label for="description">Job Description:</label><br>
        <textarea name="description" required></textarea><br>
        <input type="submit" value="Post Job">
    </form>
</body>
</html>
