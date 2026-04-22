<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-bg: #2c3e50; 
            --blue: #3498db; 
            --main-bg: #f4f7f6; 
            --green: #2ecc71; 
            --text-dark: #2c3e50;
            --text-muted: #7f8c8d;
        }
        
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; background: var(--main-bg); }
        
        
        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; color: white; position: fixed; z-index: 100; }
        .sidebar h2 { padding: 25px 20px; font-size: 1.4rem; border-bottom: 1px solid #3e4f5f; margin: 0; font-weight: 700; letter-spacing: 1px; }
        .sidebar-menu { list-style: none; padding: 0; margin-top: 20px; }
        .sidebar-menu li a { display: block; padding: 15px 25px; color: #bdc3c7; text-decoration: none; transition: 0.3s; font-size: 0.95rem; }
        .sidebar-menu li a.active { background: var(--blue); color: white; border-left: 5px solid white; }
        .sidebar-menu li a:hover:not(.active) { background: #34495e; color: white; }

        
        .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 40px; box-sizing: border-box; }
        .white-box { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        
        th { 
            text-align: left; 
            color: var(--text-muted); 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            padding: 15px 10px;
            border-bottom: 2px solid #edf2f7;
        }

        td { 
            padding: 18px 10px; 
            border-bottom: 1px solid #f1f5f9; 
            color: var(--text-dark);
            font-size: 0.95rem;
            vertical-align: middle;
        }

        tr:hover td { background-color: #f8fafc; } 

        
        td:first-child { color: var(--text-muted); font-weight: 600; width: 50px; }

        
        .user-name { font-weight: 700; color: #2d3748; }

        
        .badge { 
            display: inline-block;
            padding: 5px 14px; 
            border-radius: 20px; 
            font-size: 0.75rem; 
            font-weight: 700;
            text-transform: capitalize;
        }
        .badge-user { background: #ebf8ff; color: #3182ce; }
        .badge-admin { background: #f0fff4; color: #38a169; }
        .badge-error { background: #fff5f5; color: #e53e3e; } 

        
        .btn-trash { 
            color: #e53e3e; 
            text-decoration: none; 
            font-size: 1.1rem; 
            transition: 0.2s;
            padding: 8px;
            border-radius: 5px;
        }
        .btn-trash:hover { background: #fff5f5; color: #c53030; }
        
        .header-title { margin-bottom: 30px; }
        .header-title h1 { margin: 0; font-size: 1.8rem; color: var(--text-dark); }
        .header-title p { margin: 5px 0 0; color: var(--text-muted); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SkillMate Admin</h2>
        <ul class="sidebar-menu">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <li>
                <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="manage_users.php" class="<?= ($current_page == 'manage_users.php') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Manage Users
                </a>
            </li>
            <li>
                <a href="manage_posts.php" class="<?= ($current_page == 'manage_posts.php') ? 'active' : '' ?>">
                    <i class="fas fa-edit"></i> Manage Posts
                </a>
            </li>

            <li style="margin-top: 30px; border-top: 1px solid #3e4f5f;">
                <a href="../dashboard.php" style="color: var(--green);">
                    <i class="fas fa-external-link-alt"></i> View User Site
                </a>
            </li>

            <li>
                <a href="../logout.php" style="color: #e74c3c;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
