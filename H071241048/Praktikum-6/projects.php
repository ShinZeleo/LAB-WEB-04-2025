<?php
session_start();
include "db.php";
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$current_user = $_SESSION['user'];
$current_user_role = $current_user['role'];
$current_user_id  = (int)$current_user['id'];

// No session messages - using JavaScript alerts instead
$msg = "";

/* Tambah proyek oleh Project Manager */
if ($current_user_role === 'Project Manager' && isset($_POST['tambah'])) {
  $project_nama = trim($_POST['nama'] ?? "");
  $project_deskripsi = trim($_POST['desk'] ?? "");
  $project_tanggal_mulai = $_POST['mulai'] ?? null;
  $project_tanggal_selesai = $_POST['selesai'] ?? null;

  if ($project_nama === "") { 
    echo "<script>alert('Nama proyek wajib diisi.'); window.location.href='projects.php';</script>";
    exit;
  } elseif ($project_tanggal_mulai && $project_tanggal_selesai && $project_tanggal_selesai < $project_tanggal_mulai) {
    echo "<script>alert('Tanggal selesai harus lebih dari tanggal mulai.'); window.location.href='projects.php';</script>";
    exit;
  } else {
    $insertProjectStmt = $conn->prepare(
      "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
       VALUES (?, ?, ?, ?, ?)"
    );
    $insertProjectStmt->bind_param("ssssi", $project_nama, $project_deskripsi, $project_tanggal_mulai, $project_tanggal_selesai, $current_user_id);
    $insertProjectStmt->execute();
    $insertProjectStmt->close();
    echo "<script>alert('Proyek ditambahkan.'); window.location.href='projects.php';</script>";
    exit;
  }
}

/* Hapus proyek */
if (isset($_GET['hapus'])) {
  $pid = (int)$_GET['hapus'];
  
  // Check if project has any tasks before deletion (for cascade deletion rule)
  $tasks_count_query = $conn->query("SELECT COUNT(*) c FROM tasks WHERE project_id=$pid");
  $tasks_count = (int)$tasks_count_query->fetch_assoc()['c'];
  if ($tasks_count > 0) {
    echo "<script>alert('Tidak dapat menghapus proyek karena masih memiliki tugas. Hapus dulu semua tugasnya.'); window.location.href='projects.php';</script>";
    exit;
  } else {
    if ($current_user_role === 'Super Admin') {
      $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
      $stmt->bind_param("i", $pid);
      $stmt->execute();
      $stmt->close();
      echo "<script>alert('Proyek dihapus.'); window.location.href='projects.php';</script>";
      exit;
    } elseif ($current_user_role === 'Project Manager') {
      $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
      $stmt->bind_param("ii", $pid, $current_user_id);
      $stmt->execute();
      $stmt->close();
      echo "<script>alert('Proyek dihapus bila milik sendiri.'); window.location.href='projects.php';</script>";
      exit;
    }
  }
}

/* Edit proyek oleh PM */
if ($current_user_role === 'Project Manager' && isset($_POST['edit'])) {
  $project_id = (int)$_POST['id'];
  $project_nama = trim($_POST['nama'] ?? "");
  $project_deskripsi = trim($_POST['desk'] ?? "");
  $project_tanggal_mulai = $_POST['mulai'] ?? null;
  $project_tanggal_selesai = $_POST['selesai'] ?? null;

  $checkPermissionStmt = $conn->prepare("SELECT 1 FROM projects WHERE id = ? AND manager_id = ?");
  $checkPermissionStmt->bind_param("ii", $project_id, $current_user_id);
  $checkPermissionStmt->execute();
  $result = $checkPermissionStmt->get_result();
  if ($result && $result->num_rows === 1) {
    $checkPermissionStmt->close();
    
    // Validate that end date is after start date
    if ($project_tanggal_mulai && $project_tanggal_selesai && $project_tanggal_selesai < $project_tanggal_mulai) {
      echo "<script>alert('Tanggal selesai harus lebih dari tanggal mulai.'); window.location.href='projects.php';</script>";
      exit;
    } else {
      $updateProjectStmt = $conn->prepare(
        "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?
         WHERE id = ? AND manager_id = ?"
      );
      $updateProjectStmt->bind_param("ssssii", $project_nama, $project_deskripsi, $project_tanggal_mulai, $project_tanggal_selesai, $project_id, $current_user_id);
      $updateProjectStmt->execute();
      $updateProjectStmt->close();
      echo "<script>alert('Proyek diperbarui.'); window.location.href='projects.php';</script>";
      exit;
    }
  } else {
    $checkPermissionStmt->close();
    echo "<script>alert('Tidak berhak mengedit proyek ini.'); window.location.href='projects.php';</script>";
    exit;
  }
}

/* List proyek sesuai peran */
if ($current_user_role === 'Super Admin') {
  $projects_list = $conn->query("SELECT * FROM projects ORDER BY id DESC");
} elseif ($current_user_role === 'Project Manager') {
  $projects_list = $conn->query("SELECT * FROM projects WHERE manager_id=$current_user_id ORDER BY id DESC");
} else {
  $projects_list = $conn->query("SELECT DISTINCT p.* FROM projects p JOIN tasks t ON t.project_id=p.id WHERE t.assigned_to=$current_user_id ORDER BY p.id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects - Project Management</title>
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
                    <a href="tasks.php" class="hover:bg-blue-500 px-3 py-2 rounded transition">Tasks</a>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-folder-open mr-2 text-blue-600"></i> Daftar Proyek
            </h3>
            <?php if($msg): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4">
                <p class="font-bold">Peringatan:</p>
                <p><?= htmlspecialchars($msg) ?></p>
            </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">ID</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Nama</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Deskripsi</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Mulai</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Selesai</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Manager</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($project = $projects_list->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-sm"><?= (int)$project['id'] ?></td>
                            <td class="py-3 px-4 text-sm font-medium"><?= htmlspecialchars($project['nama_proyek']) ?></td>
                            <td class="py-3 px-4 text-sm max-w-xs truncate" title="<?= htmlspecialchars($project['deskripsi']) ?>"><?= htmlspecialchars($project['deskripsi']) ?></td>
                            <td class="py-3 px-4 text-sm"><?= htmlspecialchars((string)$project['tanggal_mulai']) ?></td>
                            <td class="py-3 px-4 text-sm"><?= htmlspecialchars((string)$project['tanggal_selesai']) ?></td>
                            <td class="py-3 px-4 text-sm"><?= (int)$project['manager_id'] ?></td>
                            <td class="py-3 px-4">
                                <?php if ($current_user_role === 'Super Admin'): ?>
                                <a href="?hapus=<?= (int)$project['id'] ?>" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Hapus proyek ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
                                <?php elseif ($current_user_role === 'Project Manager' && (int)$project['manager_id'] === $current_user_id): ?>
                                <a href="#" onclick="isiFormEdit(<?= (int)$project['id'] ?>,'<?= htmlspecialchars($project['nama_proyek'], ENT_QUOTES) ?>','<?= htmlspecialchars($project['deskripsi'], ENT_QUOTES) ?>','<?= $project['tanggal_mulai'] ?>','<?= $project['tanggal_selesai'] ?>'); return false;" class="text-blue-600 hover:text-blue-800 mr-3 flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="?hapus=<?= (int)$project['id'] ?>" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Hapus proyek ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
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
                    <i class="fas fa-folder-plus mr-2 text-green-600"></i> Tambah Proyek Baru
                </h4>
                <form method="post" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                        <input type="text" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nama proyek" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="desk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi proyek"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="mulai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="selesai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <button type="submit" name="tambah" value="1" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Proyek
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md p-5">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i> Edit Proyek
                </h4>
                <form method="post" id="formEdit" class="space-y-4">
                    <input type="hidden" name="id" id="e_id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                        <input type="text" name="nama" id="e_nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Nama proyek" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="desk" id="e_desk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Deskripsi proyek"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="mulai" id="e_mulai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="selesai" id="e_selesai" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>
                    <button type="submit" name="edit" value="1" class="w-full bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
                <script>
                function isiFormEdit(id, nama, desk, mulai, selesai) {
                    document.getElementById('e_id').value = id;
                    document.getElementById('e_nama').value = nama;
                    document.getElementById('e_desk').value = desk;
                    document.getElementById('e_mulai').value = mulai || "";
                    document.getElementById('e_selesai').value = selesai || "";
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