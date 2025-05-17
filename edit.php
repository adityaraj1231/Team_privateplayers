<?php include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role  = $_POST['role'];

    // Check if new photo uploaded
    if ($_FILES['photo']['name']) {
        $photoName = time() . '_' . $_FILES['photo']['name'];
        $photoTmp  = $_FILES['photo']['tmp_name'];
        move_uploaded_file($photoTmp, "uploads/" . $photoName);

        // Update with photo
        $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', role='$role', photo='$photoName' WHERE id=$id");
    } else {
        // Update without changing photo
        $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', role='$role' WHERE id=$id");
    }

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Team Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        .profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Edit Team Member</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="<?= $row['phone'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="text" name="role" value="<?= $row['role'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Profile Photo</label><br>
            <?php if ($row['photo']) : ?>
                <img src="uploads/<?= $row['photo'] ?>" class="profile-photo" alt="Photo"><br>
            <?php endif; ?>
            <input type="file" name="photo" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-success">✅ Update</button>
        <a href="index.php" class="btn btn-secondary">🔙 Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
