<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $skill = mysqli_real_escape_string($conn, $_POST['skill_teach']);

    
    $sql = "INSERT INTO users (fullname, username, email, password, skill_teach, role) 
            VALUES ('$fullname', '$user', '$email', '$pass', '$skill', 'user')";

    if ($conn->query($sql) === TRUE) {
        
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><i class="fas fa-sync-alt"></i> SkillSwap</div>
        <ul class="nav-links">
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>

    <div class="login-container" style="margin-top: 100px;">
        <h2><i class="fas fa-user-plus"></i> Register</h2>
        <form action="register.php" method="POST">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>
            
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email Address:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <hr style="margin: 20px 0; border: 0.1px solid #eee;">
            
            <label>Skill to Teach:</label>
            <input type="text" name="skill_teach" required>
            
            <button type="submit">Create Account</button>
        </form>
        <p style="text-align:center; margin-top:15px;">Already have an account? <a href="login.php">Login Now</a></p>
    </div>
</body>
</html>
