<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Handle profile photo upload
    $photoName = '';
    if ($_FILES['photo']['name']) {
        $photoName = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photoName);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, role, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $role, $photoName);
    $stmt->execute();

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Team Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .form-container {
            max-width: 550px;
            margin: 60px auto;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Add New Team Member</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter full name">
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required placeholder="Enter phone number">
            </div>
            <div class="mb-3">
                <label class="form-label">Job Role</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select role</option>
                    <option value="Developer">Developer</option>
                    <option value="Designer">Designer</option>
                    <option value="Manager">Manager</option>
                    <option value="Tester">Tester</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="photo" accept="image/*" class="form-control">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Add Team Member</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <a href="index.php" class="text-decoration-none">← Back to Team List</a>
        </div>
    </div>
</div>

<!-- Toast Success Message -->
<?php if (!empty($success)) : ?>
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                ✅ Team member added successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
