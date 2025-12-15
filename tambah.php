<?php
// form tambah
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Absensi</title>
</head>
<body>
    <h1>Tambah Absensi Mahasiswa</h1>
    <form method="post" action="proses_tambah.php" enctype="multipart/form-data">
        <label>Nama Mahasiswa</label><br>
        <input type="text" name="nama_mahasiswa" required><br><br>

        <label>NPM</label><br>
        <input type="text" name="npm" required><br><br>

        <label>Kelas</label><br>
        <input type="text" name="kelas" required placeholder="Contoh: 4A"><br><br>

        <label>Status Kehadiran</label><br>
        <select name="status_kehadiran" required>
            <option value="">-- Pilih --</option>
            <option value="Hadir">Hadir</option>
            <option value="Sakit">Sakit</option>
            <option value="Izin">Izin</option>
        </select><br><br>

        <label>Bukti Foto (Selfie / Surat)</label><br>
        <input type="file" name="bukti" accept=".jpg,.jpeg,.png" ><br><small></small><br><br>

        <button type="submit">Simpan</button>
        <a href="index.php" style="margin-left:8px">Batal</a>
    </form>
</body>
</html>
