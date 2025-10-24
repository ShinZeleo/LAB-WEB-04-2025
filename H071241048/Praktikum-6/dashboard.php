<?php
session_start();
include "db.php";
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$current_user = $_SESSION['user'];
$current_user_role = $current_user['role'];
$current_user_id  = (int)$current_user['id'];

// Clear any session messages since we'll use alerts instead
if (isset($_SESSION['admin_message'])) {
    unset($_SESSION['admin_message']);
}
if (isset($_SESSION['admin_message'])) {
    unset($_SESSION['admin_message']);
}

/* ========== Aksi Super Admin ========== */
if ($current_user_role === 'Super Admin') {

  // Hapus user, tetapi tidak boleh hapus diri sendiri, dan tidak boleh hapus Super Admin terakhir
  if (isset($_GET['hapus_user'])) {
    $user_id_to_delete = (int)$_GET['hapus_user'];

    if ($user_id_to_delete === $current_user_id) {
      echo "<script>alert('Tidak bisa hapus akun sendiri.'); window.location.href='dashboard.php';</script>";
      exit;
    } else {
      $user_to_delete_query = $conn->query("SELECT id, role, project_manager_id FROM users WHERE id=$user_id_to_delete");
      if ($user_to_delete_query && $user_to_delete_query->num_rows === 1) {
        $user_to_delete_data = $user_to_delete_query->fetch_assoc();
        $user_role_to_delete = $user_to_delete_data['role'];
        $project_manager_id_to_check = $user_to_delete_data['project_manager_id'];
        
        if ($user_role_to_delete === 'Super Admin') {
          $super_admin_count_query = $conn->query("SELECT COUNT(*) c FROM users WHERE role='Super Admin'");
          $super_admin_count = (int)$super_admin_count_query->fetch_assoc()['c'];
          if ($super_admin_count <= 1) {
            echo "<script>alert('Tidak boleh menghapus Super Admin terakhir.'); window.location.href='dashboard.php';</script>";
            exit;
          } else {
            // Check if Super Admin is managing any projects
            $projects_count_query = $conn->query("SELECT COUNT(*) c FROM projects WHERE manager_id=$user_id_to_delete");
            $projects_count = (int)$projects_count_query->fetch_assoc()['c'];
            if ($projects_count > 0) {
              echo "<script>alert('Tidak dapat menghapus Super Admin karena masih memiliki proyek. Hapus dulu proyeknya.'); window.location.href='dashboard.php';</script>";
              exit;
            } else {
              $conn->query("DELETE FROM users WHERE id=$user_id_to_delete");
              echo "<script>alert('User terhapus.'); window.location.href='dashboard.php';</script>";
              exit;
            }
          }
        } elseif ($user_role_to_delete === 'Project Manager') {
          // Check if Project Manager has any Team Members assigned (cascade deletion rule)
          $team_members_count_query = $conn->query("SELECT COUNT(*) c FROM users WHERE project_manager_id=$user_id_to_delete");
          $team_members_count = (int)$team_members_count_query->fetch_assoc()['c'];
          if ($team_members_count > 0) {
            echo "<script>alert('Tidak dapat menghapus Project Manager karena masih memiliki Team Member di bawahnya. Hapus dulu semua Team Membernya.'); window.location.href='dashboard.php';</script>";
            exit;
          } else {
            // Check if Project Manager has any projects (cascade deletion rule)
            $projects_count_query = $conn->query("SELECT COUNT(*) c FROM projects WHERE manager_id=$user_id_to_delete");
            $projects_count = (int)$projects_count_query->fetch_assoc()['c'];
            if ($projects_count > 0) {
              echo "<script>alert('Tidak dapat menghapus Project Manager karena masih memiliki proyek. Hapus dulu semua proyeknya.'); window.location.href='dashboard.php';</script>";
              exit;
            } else {
              $conn->query("DELETE FROM users WHERE id=$user_id_to_delete");
              echo "<script>alert('User terhapus.'); window.location.href='dashboard.php';</script>";
              exit;
            }
          }
        } else { // Team Member
          // Check if Team Member has any tasks assigned (cascade deletion rule)
          $tasks_count_query = $conn->query("SELECT COUNT(*) c FROM tasks WHERE assigned_to=$user_id_to_delete");
          $tasks_count = (int)$tasks_count_query->fetch_assoc()['c'];
          if ($tasks_count > 0) {
            echo "<script>alert('Tidak dapat menghapus Team Member karena masih memiliki tugas. Hapus dulu semua tugasnya.'); window.location.href='dashboard.php';</script>";
            exit;
          } else {
            $conn->query("DELETE FROM users WHERE id=$user_id_to_delete");
            echo "<script>alert('User terhapus.'); window.location.href='dashboard.php';</script>";
            exit;
          }
        }
      } else {
        echo "<script>alert('User tidak ditemukan.'); window.location.href='dashboard.php';</script>";
        exit;
      }
    }
  }

  // Tambah user baru
  if (isset($_POST['tambah_user'])) {
    $new_username = trim($_POST['uname'] ?? "");
    $new_password  = trim($_POST['pass'] ?? "");
    $new_role = trim($_POST['urole'] ?? "");
    $project_manager_id = (int)($_POST['pm_id'] ?? 0);

    if ($new_username === "" || $new_password === "" || $new_role === "") {
      echo "<script>alert('Semua kolom wajib diisi.'); window.location.href='dashboard.php';</script>";
      exit;
    } else {

      // Super Admin cannot be created through this form
      if ($new_role === 'Super Admin') {
        echo "<script>alert('Tidak dapat menambah Super Admin melalui form ini.'); window.location.href='dashboard.php';</script>";
        exit;
      } else {
        if ($new_role === 'Team Member' && $project_manager_id <= 0) {
          echo "<script>alert('Team Member wajib punya Project Manager.'); window.location.href='dashboard.php';</script>";
          exit;
        } else {
          // Check if username already exists
          $check_username_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
          $check_username_stmt->bind_param("s", $new_username);
          $check_username_stmt->execute();
          $check_result = $check_username_stmt->get_result();
          
          if ($check_result->num_rows > 0) {
            echo "<script>alert('Username sudah digunakan. Gunakan username lain.'); window.location.href='dashboard.php';</script>";
            exit;
            $check_username_stmt->close();
          } else {
            $check_username_stmt->close();

            $insert_user_stmt = $conn->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, MD5(?), ?, ?)");

            if ($new_role === 'Project Manager') {
              $null_value = null;
              $insert_user_stmt->bind_param("sssi", $new_username, $new_password, $new_role, $null_value);
            } else {
              $insert_user_stmt->bind_param("sssi", $new_username, $new_password, $new_role, $project_manager_id);
            }
            $insert_user_stmt->execute();
            $insert_user_stmt->close();
            echo "<script>alert('User ditambahkan.'); window.location.href='dashboard.php';</script>";
            exit;
          }
        }
      }
    }
  }
}

/* ========== Ringkasan sederhana ========== */
$total_projects = 0;
$total_tasks = 0;
$completed_tasks = 0;

if ($current_user_role === 'Super Admin') {
  $total_projects = (int)$conn->query("SELECT COUNT(*) c FROM projects")->fetch_assoc()['c'];
  $total_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks")->fetch_assoc()['c'];
  $completed_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks WHERE status='selesai'")->fetch_assoc()['c'];
} elseif ($current_user_role === 'Project Manager') {
  $total_projects = (int)$conn->query("SELECT COUNT(*) c FROM projects WHERE manager_id=$current_user_id")->fetch_assoc()['c'];
  $total_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks t JOIN projects p ON p.id=t.project_id WHERE p.manager_id=$current_user_id")->fetch_assoc()['c'];
  $completed_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks t JOIN projects p ON p.id=t.project_id WHERE p.manager_id=$current_user_id AND t.status='selesai'")->fetch_assoc()['c'];
} else {
  $total_projects = (int)$conn->query("SELECT COUNT(DISTINCT project_id) c FROM tasks WHERE assigned_to=$current_user_id")->fetch_assoc()['c'];
  $total_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks WHERE assigned_to=$current_user_id")->fetch_assoc()['c'];
  $completed_tasks = (int)$conn->query("SELECT COUNT(*) c FROM tasks WHERE assigned_to=$current_user_id AND status='selesai'")->fetch_assoc()['c'];
}

/* ========== Data untuk form kelola user ========== */
if ($current_user_role === 'Super Admin') {
  $project_managers_list = $conn->query("SELECT id, username FROM users WHERE role='Project Manager' ORDER BY username");
  $all_users = $conn->query("SELECT id, username, role, project_manager_id FROM users ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Project Management</title>
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
                    <span class="flex items-center">
                        <i class="fas fa-user mr-1"></i> <?= htmlspecialchars($current_user['username']) ?>
                    </span>
                    <a href="projects.php" class="hover:bg-blue-500 px-3 py-2 rounded transition">Projects</a>
                    <a href="tasks.php" class="hover:bg-blue-500 px-3 py-2 rounded transition">Tasks</a>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i> Dashboard
            </h2>
            <p class="text-gray-600 mb-4">Halo, <span class="font-semibold"><?= htmlspecialchars($current_user['username']) ?></span> - Peran Anda: <span class="font-semibold text-blue-600"><?= htmlspecialchars($current_user_role) ?></span></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-folder text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jumlah Proyek</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $total_projects ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-tasks text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Tugas</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $total_tasks ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <i class="fas fa-check-circle text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tugas Selesai</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $completed_tasks ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($current_user_role === 'Super Admin'): ?>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-users-cog mr-2 text-purple-600"></i> Kelola User
            </h3>


            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-user-plus mr-2 text-blue-600"></i> Tambah User Baru
                </h4>
                <form method="post" class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="uname" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="pass" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Peran</label>
                            <select name="urole" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required
                                onchange="document.getElementById('pm_wrap').style.display = this.value==='Team Member' ? 'block' : 'none'">
                                <option value="">Pilih peran</option>
                                <option>Project Manager</option>
                                <option>Team Member</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" name="tambah_user" value="1" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2 px-4 rounded-lg transition">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div id="pm_wrap" style="display:none" class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Manager</label>
                        <select name="pm_id" class="w-full md:w-64 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="0">Pilih Project Manager</option>
                            <?php if(isset($project_managers_list)) { while($pm = $project_managers_list->fetch_assoc()): ?>
                            <option value="<?= (int)$pm['id'] ?>"><?= htmlspecialchars($pm['username']) ?></option>
                            <?php endwhile; } ?>
                        </select>
                    </div>
                </form>
            </div>

            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-list mr-2 text-blue-600"></i> Daftar User
                </h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">ID</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Username</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Role</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">PM</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($all_users)) { while($user = $all_users->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm"><?= (int)$user['id'] ?></td>
                                <td class="py-3 px-4 text-sm"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="py-3 px-4 text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        <?php 
                                        $role = $user['role'];
                                        if($role === 'Super Admin') echo 'bg-purple-100 text-purple-800';
                                        elseif($role === 'Project Manager') echo 'bg-blue-100 text-blue-800';
                                        else echo 'bg-green-100 text-green-800';
                                        ?>">
                                        <?= htmlspecialchars($role) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm"><?= htmlspecialchars((string)$user['project_manager_id']) ?></td>
                                <td class="py-3 px-4">
                                    <?php if ((int)$user['id'] !== $current_user_id): ?>
                                    <a href="?hapus_user=<?= (int)$user['id'] ?>" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Hapus user ini?')">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <footer class="mt-8 text-center text-gray-600 text-sm py-4">
        <p>&copy; <?= date('Y') ?> Project Management System. All rights reserved.</p>
    </footer>
</body>
</html>