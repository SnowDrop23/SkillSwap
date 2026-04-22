<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); 
    exit();
}

include '../db_config.php'; 
include 'admin_header.php'; 


$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_skills = $conn->query("SELECT COUNT(*) as count FROM posts")->fetch_assoc()['count'];
$total_requests = $conn->query("SELECT COUNT(*) as count FROM swap_requests")->fetch_assoc()['count'];


$users_query = $conn->query("SELECT id, username, email, role FROM users ORDER BY id DESC LIMIT 5");


$posts_query = $conn->query("SELECT posts.post_id, posts.title, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.post_id DESC LIMIT 5");
?>

<div class="header">
    <h1>📊 Dashboard Overview</h1>
    <p style="color: #95a5a6; margin-bottom: 25px;">Welcome to the SkillMate management console.</p>
</div>

<div class="stat-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 5px solid #3498db;">
        <h3 style="font-size: 0.8rem; color: #95a5a6; text-transform: uppercase;">Total Users</h3>
        <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50; margin: 10px 0;"><?php echo $total_users; ?></div>
        <div style="font-size: 0.9rem; color: #3498db;">Active Members</div>
    </div>
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 5px solid #2ecc71;">
        <h3 style="font-size: 0.8rem; color: #95a5a6; text-transform: uppercase;">Total Posts</h3>
        <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50; margin: 10px 0;"><?php echo $total_skills; ?></div>
        <div style="font-size: 0.9rem; color: #2ecc71;">Skills Offered</div>
    </div>
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 5px solid #f1c40f;">
        <h3 style="font-size: 0.8rem; color: #95a5a6; text-transform: uppercase;">Total Requests</h3>
        <div style="font-size: 2.5rem; font-weight: bold; color: #2c3e50; margin: 10px 0;"><?php echo $total_requests; ?></div>
        <div style="font-size: 0.9rem; color: #f1c40f;">Interactions</div>
    </div>
</div>

<div class="white-box" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
        <h3>Recent Users</h3>
        <a href="manage_users.php" style="font-size: 0.8rem; color: #3498db; text-decoration: none;">View All</a>
    </div>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; color: #7f8c8d; border-bottom: 2px solid #f4f7f6;">
                <th style="padding: 12px;">Username</th>
                <th style="padding: 12px;">Email</th>
                <th style="padding: 12px;">Role</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $users_query->fetch_assoc()): ?>
            <tr style="border-bottom: 1px solid #f4f7f6;">
                <td style="padding: 12px;"><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                <td style="padding: 12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                <td style="padding: 12px;"><span style="background: #e1f5fe; color: #03a9f4; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;"><?php echo $user['role']; ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="white-box" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <h3>Recent Skill Posts</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
            <tr style="text-align: left; color: #7f8c8d; border-bottom: 2px solid #f4f7f6;">
                <th style="padding: 12px;">Title</th>
                <th style="padding: 12px;">Posted By</th>
            </tr>
        </thead>
        <tbody>
            <?php while($post = $posts_query->fetch_assoc()): ?>
            <tr style="border-bottom: 1px solid #f4f7f6;">
                <td style="padding: 12px; color: #2ecc71; font-weight: 500;"><?php echo htmlspecialchars($post['title']); ?></td>
                <td style="padding: 12px;"><?php echo htmlspecialchars($post['username']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
