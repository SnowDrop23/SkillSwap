<?php
session_start();
include '../db_config.php';

//1. Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

//2. Handle Remove Post Request
if (isset($_GET['remove_id'])) {
    $post_id = intval($_GET['remove_id']);
    
    $conn->query("DELETE FROM posts WHERE post_id = $post_id");
    header("Location: manage_posts.php?msg=Post removed successfully");
    exit();
}

//3. Fetch Posts with Usernames
$sql = "SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.post_id DESC";
$posts = $conn->query($sql);

include 'admin_header.php';
?>

<div class="header">
    <h1>📝 Manage Skill Posts</h1>
    <p style="color: #95a5a6; margin-bottom: 20px;">Review and moderate skills offered on the platform.</p>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>

<div class="white-box">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Skill Title</th>
                <th>Category</th>
                <th>Posted By</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($posts->num_rows > 0): ?>
                <?php while($row = $posts->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['post_id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                    <td>
                        <span class="badge" style="background: #f1f3f5; color: #495057; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">
                            <?php echo htmlspecialchars($row['category']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td style="text-align: center;">
                        <a href="manage_posts.php?remove_id=<?php echo $row['post_id']; ?>" 
                           style="color: #e74c3c; font-size: 1.1rem; text-decoration: none;"
                           onclick="return confirm('Remove this skill post?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #95a5a6; padding: 20px;">No posts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
