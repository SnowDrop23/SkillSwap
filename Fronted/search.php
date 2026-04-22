<?php
session_start();
include 'db_config.php';

$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Find Your SkillMate | Search</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial;
            background: #f5f7fa;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .user-nav {
            text-align: right;
            padding: 15px 50px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .container {
            width: 75%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 50px;
        }

        form {
            background: #f1f3f5;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        input,
        select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        button {
            padding: 12px 25px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .card {
            background: #fff;
            padding: 25px;
            margin-top: 20px;
            border-radius: 12px;
            border-left: 6px solid #2ecc71;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .category-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php if ($isLoggedIn): ?>
        <div class="user-nav">
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span>
            <a href="logout.php" style="margin-left: 15px; color: #e74c3c; text-decoration: none; font-weight: bold;">🚪 Logout</a>
        </div>
    <?php endif; ?>

    <div class="container">
        <h1>🔍 Find Your SkillMate</h1>

        <form method="GET" action="search.php">
            <input type="text" name="keyword" placeholder="Search skill or username..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
            <select name="category">
                <option value="">All Categories</option>
                <option value="IT & Tech">IT & Tech</option>
                <option value="Creative Design">Creative Design</option>
                <option value="Media & Arts">Media & Arts</option>
                <option value="Academic/Education">Academic/Education</option>
            </select>
            <button type="submit">Search Now</button>
        </form>

        <?php
        $keyword = mysqli_real_escape_string($conn, $_GET['keyword'] ?? '');
        $category = mysqli_real_escape_string($conn, $_GET['category'] ?? '');

        
        $query = "SELECT p.title, p.description, p.category, u.fullname, s.skill_name
                  FROM posts p
                  JOIN users u ON p.user_id = u.id
                  JOIN skills s ON p.offer_skill_id = s.skill_id
                  WHERE 1=1";

        if (!empty($keyword)) {
            $query .= " AND (s.skill_name LIKE '%$keyword%' OR u.fullname LIKE '%$keyword%' OR p.title LIKE '%$keyword%')";
        }

        if (!empty($category)) {
            $query .= " AND p.category = '$category'";
        }

        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            echo "<div style='margin-top:25px; text-align:left; color:#7f8c8d; font-weight:bold;'>Found " . mysqli_num_rows($result) . " available skillmates:</div>";

            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class='card'>
                    <span class="category-badge"><?php echo htmlspecialchars($row['category']); ?></span>
                    <h3 style="margin-top:10px;">
                        <?php echo htmlspecialchars($row['fullname']); ?>
                        <small style="font-weight:normal; color:#bdc3c7;">offers</small>
                        <?php echo htmlspecialchars($row['skill_name']); ?>
                    </h3>
                    <p><strong><?php echo htmlspecialchars($row['title']); ?>:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                </div>
        <?php }
        } ?>
    </div>
</body>

</html>
