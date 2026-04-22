<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_config.php';

$current_user_id = $_SESSION['user_id'];
$conditions = [];

if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $conditions[] = "(posts.title LIKE '%$search%' OR posts.description LIKE '%$search%')";
}

if (!empty($_GET['category'])) {
    $cat = $conn->real_escape_string($_GET['category']);
    $conditions[] = "posts.category = '$cat'";
}

$where_clause = "";
if (count($conditions) > 0) {
    $where_clause = "WHERE " . implode(' AND ', $conditions);
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
switch ($sort) {
    case 'oldest': $order_by = "ORDER BY posts.post_id ASC"; break;
    case 'title': $order_by = "ORDER BY posts.title ASC"; break;
    default: $order_by = "ORDER BY posts.post_id DESC"; break;
}


$sql = "SELECT posts.*, users.username, 
        (SELECT status FROM swap_requests WHERE post_id = posts.post_id AND sender_id = $current_user_id LIMIT 1) AS request_status
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        $where_clause $order_by";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; padding: 0; }
        .hero-text { text-align: center; margin-top: 100px; margin-bottom: 60px; }
        .hero-text h1 { margin: 0; font-size: 3rem; color: #2c3e50; font-weight: 700; }
        .hero-text p { color: #7f8c8d; font-size: 1.2rem; margin-top: 15px; }
        .search-section { background-color: #f1f3f5; padding: 20px 0; margin: 0 auto 40px auto; border-radius: 12px; display: flex; justify-content: center; align-items: center; width: 90%; max-width: 1100px; }
        .search-form-container { display: flex; align-items: center; gap: 15px; flex-wrap: nowrap; }
        .search-form-container input[type="text"], .search-form-container select { padding: 10px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; background-color: #fff; height: 45px; box-sizing: border-box; outline: none; }
        .search-form-container input[type="text"] { width: 350px; }
        .search-form-container select { width: 180px; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 1em; padding-right: 30px; }
        .search-btn { background-color: #5cb85c; color: white; border: none; padding: 0 40px; height: 45px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s; display: inline-flex; align-items: center; justify-content: center; line-height: normal; }
        .search-btn:hover { background-color: #45a049; }
        .results-count { text-align: left; width: 90%; max-width: 1100px; margin: 0 auto 20px auto; color: #7f8c8d; font-size: 1.1rem; font-weight: 500; }
        .dashboard-container { width: 90%; max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; padding-bottom: 50px; }
        .skill-card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s; }
        .skill-card:hover { transform: translateY(-5px); }
        .request-btn { width: 100%; padding: 12px; border: none; border-radius: 6px; margin-top: 10px; font-weight: bold; transition: 0.2s; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo"><i class="fas fa-sync-alt"></i> SkillSwap</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="post_skill.php">Post a Skill</a></li>
            <li><a href="requests.php">My Requests</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="admin/dashboard.php" style="color: #e74c3c; font-weight: bold;"><i class="fas fa-user-shield"></i> Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="hero-text">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Explore available skills below.</p>
    </div>

    <div class="search-section">
        <form class="search-form-container" action="dashboard.php" method="GET">
            <input type="text" name="search" placeholder="Search skill (e.g. Design)..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

            <select name="category">
                <option value="">All Categories</option>
                <option value="Tech" <?php if(isset($_GET['category']) && $_GET['category'] == 'Tech') echo 'selected'; ?>>Tech</option>
                <option value="Creative Design" <?php if(isset($_GET['category']) && $_GET['category'] == 'Creative Design') echo 'selected'; ?>>Creative Design</option>
                <option value="Languages" <?php if(isset($_GET['category']) && $_GET['category'] == 'Languages') echo 'selected'; ?>>Languages</option>
            </select>

            <select name="sort">
                <option value="newest" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'newest') echo 'selected'; ?>>Sort By</option>
                <option value="oldest" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'oldest') echo 'selected'; ?>>Oldest</option>
                <option value="title" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'title') echo 'selected'; ?>>Title (A-Z)</option>
            </select>

            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="results-count">
        Results found: <?php echo $result ? $result->num_rows : 0; ?>
    </div>

    <div class="dashboard-container">
    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="skill-card">
                <div class="card-header">
                    <h3 style="color: #2ecc71; margin-bottom: 15px;"><?php echo htmlspecialchars($row['title']); ?></h3>
                </div>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                <p><strong>By:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
                <p style="color: #555; line-height: 1.5;"><?php echo htmlspecialchars($row['description']); ?></p>
                
                <?php 
                if ($row['user_id'] == $current_user_id) {
                    echo '<button class="request-btn" style="background:#bdc3c7; color: white;" disabled>Your Skill</button>';
                } elseif ($row['request_status'] == 'pending' || $row['request_status'] == 'accepted') {
                    echo '<button class="request-btn" style="background: #2ecc71; color: white; cursor: default;" disabled><i class="fas fa-check"></i> Request Sent</button>';
                } else {
                    ?>
                    <form action="send_request.php" method="POST">
                        <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                        <input type="hidden" name="receiver_id" value="<?php echo $row['user_id']; ?>">
                        <button type="submit" class="request-btn" style="background: #3498db; color: white; cursor: pointer;">Request Swap</button>
                    </form>
                <?php } ?>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center; width:100%; grid-column: 1 / -1; font-size: 1.2rem; color: #95a5a6;'>No skills matching your selection.</p>";
    }
    ?>
    </div>
</body>
</html>
