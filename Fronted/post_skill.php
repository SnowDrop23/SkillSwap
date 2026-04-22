<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id']; 

    $sql = "INSERT INTO posts (user_id, title, category, description) VALUES ('$user_id', '$title', '$category', '$description')";

    if ($conn->query($sql) === TRUE) {
        $message = "success";
    } else {
        $message = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Post a Skill</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
            color: #34495e;
        }

        select, textarea, input {
            border: 1px solid #ddd !important;
            margin-bottom: 15px !important;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #2ecc71;
            width: 100%;
            padding: 12px;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><i class="fas fa-sync-alt"></i> SkillSwap</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="post_skill.php">Post a Skill</a></li>
            <li><a href="requests.php">My Requests</a></li> 
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="login-container" style="margin-top: 100px; max-width: 500px;">
        <h2>Post a New Skill</h2>
        
        <?php if ($message == "success"): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Skill Posted Successfully! Redirecting...
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "dashboard.php";
                }, 2000);
            </script>
        <?php elseif ($message == "error"): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> Error: Could not post skill.
            </div>
        <?php endif; ?>

        <form action="post_skill.php" method="POST">
            <label>Skill Title:</label>
            <input type="text" name="title" placeholder="e.g. Graphic Design Basics" required>

            <label>Category:</label>
            <select name="category" required>
                <option value="Tech">Tech</option>
                <option value="Design">Design</option>
                <option value="Language">Language</option>
                <option value="Cooking">Cooking</option>
                <option value="Music">Music</option>
            </select>

            <label>Description:</label>
            <textarea name="description" rows="4" placeholder="Describe what you can teach..." required></textarea>

            <button type="submit">
                <i class="fas fa-paper-plane"></i> Post Now
            </button>
        </form>
    </div>
</body>
</html>
