<?php
    $conn = new mysqli("localhost", "root", "", "db_manajemen_proyek");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
?>

<!-- 
Database Schema:
- users: id, username, password, role, project_manager_id
- projects: id, nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id
- tasks: id, nama_tugas, deskripsi, project_id, assigned_to, status, due_date

Super Admin: admin / admin123
Project Manager: manager1 / manager123
Team Member: member1 / member123 
-->