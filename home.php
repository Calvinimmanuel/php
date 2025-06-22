<?php
ob_start();
include "service/database.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["is_logged_in"]) || !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$message = "";

// Handle Add Task
if (isset($_POST["add_task"])) {
    $task = trim($_POST["task"]);
    if (!empty($task)) {
        $stmt = $db->prepare("INSERT INTO tasks (username, task) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $task);
        if ($stmt->execute()) {
            $message = "Task added successfully!";
        } else {
            $message = "Error adding task.";
        }
        $stmt->close();
    } else {
        $message = "Task cannot be empty.";
    }
}

// Handle Edit Task
if (isset($_POST["edit_task"])) {
    $task_id = $_POST["task_id"];
    $task = trim($_POST["task"]);
    if (!empty($task)) {
        $stmt = $db->prepare("UPDATE tasks SET task = ? WHERE id = ? AND username = ?");
        $stmt->bind_param("sis", $task, $task_id, $username);
        if ($stmt->execute()) {
            $message = "Task updated successfully!";
        } else {
            $message = "Error updating task.";
        }
        $stmt->close();
    } else {
        $message = "Task cannot be empty.";
    }
}

// Handle Delete Task
if (isset($_GET["delete"])) {
    $task_id = $_GET["delete"];
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $task_id, $username);
    if ($stmt->execute()) {
        $message = "Task deleted successfully!";
        header("Location: home.php?t=" . time());
        exit;
    } else {
        $message = "Error deleting task.";
    }
    $stmt->close();
}

// Fetch Tasks
$stmt = $db->prepare("SELECT id, task, created_at FROM tasks WHERE username = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List - My Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="container mx-auto p-4 max-w-2xl">
        <?php include "layout/header.html" ?>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">To Do List for <?php echo htmlspecialchars($username); ?></h1>
        
        <!-- Message Display -->
        <?php if ($message): ?>
            <p class="text-center mb-4 <?php echo strpos($message, 'Error') === false ? 'text-green-500' : 'text-red-500'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <!-- Add Task Form -->
        <form action="home.php" method="post" class="mb-6">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    name="task" 
                    placeholder="Enter a new task" 
                    class="flex-grow px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                <button 
                    type="submit" 
                    name="add_task" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200"
                >
                    Add Task
                </button>
            </div>
        </form>

        <!-- Task List -->
        <div class="space-y-4">
            <?php if (empty($tasks)): ?>
                <p class="text-center text-gray-600">No tasks yet. Add one above!</p>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                        <!-- Task Display -->
                        <div class="flex-grow">
                            <p class="text-gray-800"><?php echo htmlspecialchars($task['task']); ?></p>
                            <p class="text-sm text-gray-500">Created: <?php echo $task['created_at']; ?></p>
                        </div>
                        <!-- Edit/Delete Buttons -->
                        <div class="flex gap-2">
                            <!-- Edit Form (Hidden by default, toggled by JS) -->
                            <form action="home.php" method="post" class="hidden edit-form-<?php echo $task['id']; ?>">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <input 
                                    type="text" 
                                    name="task" 
                                    value="<?php echo htmlspecialchars($task['task']); ?>" 
                                    class="px-2 py-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                <button 
                                    type="submit" 
                                    name="edit_task" 
                                    class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600"
                                >
                                    Save
                                </button>
                            </form>
                            <!-- Edit/Delete Buttons -->
                            <button 
                                onclick="toggleEditForm(<?php echo $task['id']; ?>)"
                                class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 edit-btn-<?php echo $task['id']; ?>"
                            >
                                Edit
                            </button>
                            <a 
                                href="home.php?delete=<?php echo $task['id']; ?>" 
                                class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this task?')"
                            >
                                Delete
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php include "layout/footer.html" ?>
    </div>

    <!-- JavaScript for Toggling Edit Form -->
    <script>
        function toggleEditForm(taskId) {
            const editForm = document.querySelector(`.edit-form-${taskId}`);
            const editBtn = document.querySelector(`.edit-btn-${taskId}`);
            const taskDisplay = editForm.parentElement.previousElementSibling;
            editForm.classList.toggle('hidden');
            taskDisplay.classList.toggle('hidden');
            editBtn.classList.toggle('hidden');
        }
    </script>
</body>
</html>