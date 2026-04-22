<?php
session_start();
include '../db_config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

//Handle Delete Request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    if ($id !== $_SESSION['user_id']) {
        
        $conn->query("DELETE FROM users WHERE id = $id");
        header("Location: manage_users.php?msg=User Deleted");
        exit();
    }
}


$users = $conn->query("SELECT * FROM users ORDER BY id DESC");


include 'admin_header.php';
?>

<div class="header">
    <h1>👥 Users List</h1>
    <p style="color: #95a5a6; margin-bottom: 20px;">Manage and monitor platform members.</p>
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
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <span class="badge" style="background: #e1f5fe; color: #03a9f4; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">
                        <?php echo htmlspecialchars($row['role']); ?>
                    </span>
                </td>
                <td style="text-align: center;">
                    <?php if ($row['id'] != $_SESSION['user_id']): ?>
                        <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" 
                           style="color: #e74c3c; font-size: 1.1rem; text-decoration: none;"
                           onclick="return confirm('Are you sure you want to delete this user? This cannot be undone.')">
                            <i class="fas fa-trash"></i>
                        </a>
                    <?php else: ?>
                        <span style="color: #bdc3c7; font-size: 0.8rem;">(You)</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
