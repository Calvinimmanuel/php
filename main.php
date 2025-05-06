<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
require 'db.php';
$username = $_SESSION['username'];
$tasks = $conn->query("SELECT * FROM tasks WHERE username = '$username'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-3">To-Do List - <?= htmlspecialchars($username) ?></h2>
        <form method="POST" action="add_task.php" class="d-flex mb-3" id="task-form">
            <input type="text" name="task" class="form-control me-2" required>
            <button class="btn btn-primary">Tambah</button>
        </form>
        <ul class="list-group" id="task-list">
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center <?= $task['done'] ? 'completed' : '' ?>"
                    id="task-<?= $task['id'] ?>">
                    <?= htmlspecialchars($task['task']) ?>
                    <div>
                        <a href="done.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-success">Selesai</a>
                        <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
        <a href="logout.php" class="btn btn-outline-secondary mt-3">Logout</a>
    </div>
</body>
</html>