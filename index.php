<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 60px;
        }
        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        .btn-action {
            margin-right: 5px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Top bar with welcome message and logout -->
    <div class="top-bar">
        <div>Welcome, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong></div>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>

    <h2 class="text-center mb-4">OUR Ranchi Heroes</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="create.php" class="btn btn-primary">➕ Add New Team Member</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $photo = $row['photo'] ? "uploads/{$row['photo']}" : "https://via.placeholder.com/50";
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td><img src='$photo' alt='Photo'></td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['role']) . "</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning btn-action'>Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger btn-action' onclick=\"return confirm('Are you sure you want to delete this member?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No team members found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
