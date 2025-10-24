<?php
session_start();
include "db.php";
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$current_user = $_SESSION['user'];
$current_user_role = $current_user['role'];
$current_user_id  = (int)$current_user['id'];

// No session messages - using JavaScript alerts instead
$msg = "";

/* Tambah tugas oleh PM. Wajib: proyek milik PM dan member di bawah PM */
if ($current_user_role === 'Project Manager' && isset($_POST['tambah'])) {
  $task_nama = trim($_POST['nama'] ?? "");
  $task_deskripsi = trim($_POST['desk'] ?? "");
  $project_id = (int)($_POST['proj'] ?? 0);
  $assigned_user_id = (int)($_POST['asgn'] ?? 0);
  $due_date = $_POST['due_date'] ?? null;

  if ($task_nama === "" || $project_id <= 0 || $assigned_user_id <= 0) {
    echo "<script>alert('Nama, proyek, dan member wajib diisi.'); window.location.href='tasks.php';</script>";
    exit;
  } else {
    // cek apakah proyek milik PM yang sedang login
    $checkProjectStmt = $conn->prepare("SELECT 1 FROM projects WHERE id = ? AND manager_id = ?");
    $checkProjectStmt->bind_param("ii", $project_id, $current_user_id);
    $checkProjectStmt->execute();
    $isProjectValid = $checkProjectStmt->get_result()->num_rows === 1;
    $checkProjectStmt->close();

    // cek apakah user yang ditugaskan adalah team member di bawah PM ini
    $checkMemberStmt = $conn->prepare("SELECT 1 FROM users WHERE id = ? AND role = 'Team Member' AND project_manager_id = ?");
    $checkMemberStmt->bind_param("ii", $assigned_user_id, $current_user_id);
    $checkMemberStmt->execute();
    $isMemberValid = $checkMemberStmt->get_result()->num_rows === 1;
    $checkMemberStmt->close();

    if ($isProjectValid && $isMemberValid) {
      $insertTaskStmt = $conn->prepare(
        "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to, due_date)
         VALUES (?, ?, ?, ?, ?)"
      );
      $insertTaskStmt->bind_param("sssis", $task_nama, $task_deskripsi, $project_id, $assigned_user_id, $due_date);
      $insertTaskStmt->execute();
      $insertTaskStmt->close();
      echo "<script>alert('Tugas ditambahkan.'); window.location.href='tasks.php';</script>";
      exit;
    } else {
      echo "<script>alert('Validasi gagal. Pastikan proyek milik Anda dan member di bawah Anda.'); window.location.href='tasks.php';</script>";
      exit;
    }
  }
}

/* Hapus tugas oleh PM pada proyek miliknya dan Super Admin bisa hapus semua */
if (($current_user_role === 'Project Manager' || $current_user_role === 'Super Admin') && isset($_GET['hapus'])) {
  $tid = (int)$_GET['hapus'];
  
  if ($current_user_role === 'Project Manager') {
    // PM can only delete tasks from their own projects
    $stmt = $conn->prepare(
      "DELETE t FROM tasks t
       JOIN projects p ON p.id = t.project_id
       WHERE t.id = ? AND p.manager_id = ?"
    );
    $stmt->bind_param("ii", $tid, $current_user_id);
  } else {
    // Super Admin can delete any task
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $tid);
  }
  
  $stmt->execute();
  $stmt->close();
  echo "<script>alert('Tugas dihapus.'); window.location.href='tasks.php';</script>";
  exit;
}

/* Edit tugas oleh PM pada proyek miliknya */
if ($current_user_role === 'Project Manager' && isset($_POST['edit'])) {
  $task_id = (int)($_POST['id'] ?? 0);
  $task_nama = trim($_POST['nama'] ?? "");
  $task_deskripsi = trim($_POST['desk'] ?? "");
  $task_status = trim($_POST['status'] ?? "belum");
  $due_date = $_POST['due_date'] ?? null;

  $checkPermissionStmt = $conn->prepare(
    "SELECT 1
     FROM tasks t JOIN projects p ON p.id = t.project_id
     WHERE t.id = ? AND p.manager_id = ?"
  );
  $checkPermissionStmt->bind_param("ii", $task_id, $current_user_id);
  $checkPermissionStmt->execute();
  $hasPermission = $checkPermissionStmt->get_result()->num_rows === 1;
  $checkPermissionStmt->close();

  if ($hasPermission) {
    $updateTaskStmt = $conn->prepare(
      "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, status = ?, due_date = ?
       WHERE id = ?"
    );
    $updateTaskStmt->bind_param("ssssi", $task_nama, $task_deskripsi, $task_status, $due_date, $task_id);
    $updateTaskStmt->execute();
    $updateTaskStmt->close();
    echo "<script>alert('Tugas diperbarui.'); window.location.href='tasks.php';</script>";
    exit;
  } else {
    echo "<script>alert('Tidak berhak mengedit tugas ini.'); window.location.href='tasks.php';</script>";
    exit;
  }
}

/* Ubah status oleh Team Member pada tugas miliknya */
if ($current_user_role === 'Team Member' && isset($_POST['ubah_status'])) {
  $task_id = (int)($_POST['id'] ?? 0);
  $task_status = trim($_POST['status'] ?? "belum");

  $updateStatusStmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
  $updateStatusStmt->bind_param("sii", $task_status, $task_id, $current_user_id);
  $updateStatusStmt->execute();
  $updateStatusStmt->close();
  echo "<script>alert('Status diperbarui bila tugas milik Anda.'); window.location.href='tasks.php';</script>";
  exit;
}

/* List tugas sesuai peran */
if ($current_user_role === 'Super Admin') {
  $tasks_list = $conn->query("SELECT t.*, p.nama_proyek FROM tasks t LEFT JOIN projects p ON p.id=t.project_id ORDER BY t.id DESC");
} elseif ($current_user_role === 'Project Manager') {
  $tasks_list = $conn->query("SELECT t.*, p.nama_proyek FROM tasks t JOIN projects p ON p.id=t.project_id WHERE p.manager_id=$current_user_id ORDER BY t.id DESC");
} else {
  $tasks_list = $conn->query("SELECT t.*, p.nama_proyek FROM tasks t LEFT JOIN projects p ON p.id=t.project_id WHERE t.assigned_to=$current_user_id ORDER BY t.id DESC");
}

/* Data pendukung form PM */
if ($current_user_role === 'Project Manager') {
  $projects_managed_by_user = $conn->query("SELECT id, nama_proyek FROM projects WHERE manager_id=$current_user_id ORDER BY nama_proyek");
  $team_members_under_user  = $conn->query("SELECT id, username FROM users WHERE role='Team Member' AND project_manager_id=$current_user_id ORDER BY username");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks - Project Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold flex items-center">
                    <i class="fas fa-tasks mr-2"></i> Project Management System
                </h1>
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="hover:bg-blue-500 px-3 py-2 rounded transition">Dashboard</a>
                    <a href="projects.php" class="hover:bg-blue-500 px-3 py-2 rounded transition">Projects</a>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-tasks mr-2 text-blue-600"></i> Daftar Tugas
            </h3>

        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">ID</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Proyek</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Nama</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Deskripsi</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Assigned To</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($task = $tasks_list->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-sm"><?= (int)$task['id'] ?></td>
                            <td class="py-3 px-4 text-sm"><?= htmlspecialchars($task['nama_proyek'] ?? '') ?></td>
                            <td class="py-3 px-4 text-sm font-medium"><?= htmlspecialchars($task['nama_tugas']) ?></td>
                            <td class="py-3 px-4 text-sm max-w-xs truncate" title="<?= htmlspecialchars($task['deskripsi']) ?>"><?= htmlspecialchars($task['deskripsi']) ?></td>
                            <td class="py-3 px-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    <?php 
                                    $status = $task['status'];
                                    if($status === 'belum') echo 'bg-red-100 text-red-800';
                                    elseif($status === 'proses') echo 'bg-blue-100 text-blue-800';
                                    else echo 'bg-green-100 text-green-800';
                                    ?>">
                                    <i class="fas fa-circle mr-1 text-xs"></i> <?= htmlspecialchars($task['status']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm"><?= (int)$task['assigned_to'] ?></td>
                            <td class="py-3 px-4">
                                <?php if ($current_user_role === 'Project Manager'): ?>
                                <a href="#" onclick="isiEdit(<?= (int)$task['id'] ?>,'<?= htmlspecialchars($task['nama_tugas'], ENT_QUOTES) ?>','<?= htmlspecialchars($task['deskripsi'], ENT_QUOTES) ?>','<?= htmlspecialchars($task['status'], ENT_QUOTES) ?>'); return false;" class="text-blue-600 hover:text-blue-800 mr-3 flex items-center mb-2">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="?hapus=<?= (int)$task['id'] ?>" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Hapus tugas ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
                                <?php elseif ($current_user_role === 'Super Admin'): ?>
                                <a href="?hapus=<?= (int)$task['id'] ?>" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Hapus tugas ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
                                <?php elseif ($current_user_role === 'Team Member' && (int)$task['assigned_to'] === $current_user_id): ?>
                                <form method="post" class="flex items-center">
                                    <input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
                                    <select name="status" class="text-sm mr-2 px-2 py-1 border border-gray-300 rounded">
                                        <?php
                                        $opts = ['belum','proses','selesai'];
                                        foreach($opts as $o){
                                          $sel = $o === $task['status'] ? 'selected' : '';
                                          echo "<option $sel>$o</option>";
                                        }
                                      ?>
                                    </select>
                                    <button type="submit" name="ubah_status" value="1" class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </form>
                                <?php else: ?>
                                <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($current_user_role === 'Project Manager'): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-5">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i> Tambah Tugas Baru
                </h4>
                <form method="post" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tugas</label>
                        <input type="text" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nama tugas" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="desk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi tugas"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proyek</label>
                            <select name="proj" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih proyek</option>
                                <?php while($project = $projects_managed_by_user->fetch_assoc()): ?>
                                <option value="<?= (int)$project['id'] ?>"><?= htmlspecialchars($project['nama_proyek']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                            <select name="asgn" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih member</option>
                                <?php while($member = $team_members_under_user->fetch_assoc()): ?>
                                <option value="<?= (int)$member['id'] ?>"><?= htmlspecialchars($member['username']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="tambah" value="1" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Tugas
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md p-5">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i> Edit Tugas
                </h4>
                <form method="post" id="formEdit" class="space-y-4">
                    <input type="hidden" name="id" id="e_id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tugas</label>
                        <input type="text" name="nama" id="e_nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Nama tugas" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="desk" id="e_desk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Deskripsi tugas"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="e_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="belum">belum</option>
                            <option value="proses">proses</option>
                            <option value="selesai">selesai</option>
                        </select>
                    </div>
                    <button type="submit" name="edit" value="1" class="w-full bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
                <script>
                function isiEdit(id, nama, desk, status) {
                    document.getElementById('e_id').value = id;
                    document.getElementById('e_nama').value = nama;
                    document.getElementById('e_desk').value = desk;
                    document.getElementById('e_status').value = status;
                }
                </script>
            </div>
        </div>
        <?php endif; ?>

        <div class="mt-6">
            <a href="dashboard.php" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
    
    <footer class="mt-8 text-center text-gray-600 text-sm py-4 border-t border-gray-200">
        <p>&copy; <?= date('Y') ?> Project Management System. All rights reserved.</p>
    </footer>
</body>
</html>