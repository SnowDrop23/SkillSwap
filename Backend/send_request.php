<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $post_id = $_POST['post_id'];

    
    $check = $conn->query("SELECT * FROM swap_requests WHERE sender_id = '$sender_id' AND post_id = '$post_id'");

    if ($check->num_rows == 0) {
        $sql = "INSERT INTO swap_requests (sender_id, receiver_id, post_id, status) 
                VALUES ('$sender_id', '$receiver_id', '$post_id', 'pending')";
        
        if ($conn->query($sql)) {
            echo "<script>alert('Request sent to the user!'); window.location.href='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('You have already requested this skill.'); window.location.href='dashboard.php';</script>";
    }
}
?>
