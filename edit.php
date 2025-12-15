<?php
include 'koneksi.php';
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = intval($_GET['id']);
$stmt = $koneksi->prepare("SELECT * FROM absensi_ukri WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();
if (!$data) {
    die("Data tidak ditemukan.");
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Absensi</title>
</head>
<body>
    <h1>Edit Absensi</h1>
    <form method="post" action="proses_edit.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <input type="hidden" name="old_file" value="<?php echo htmlspecialchars($data['bukti_foto']); ?>">

        <label>Nama Mahasiswa</label><br>
        <input type="text" name="nama_mahasiswa" required value="<?php echo htmlspecialchars($data['nama_mahasiswa']); ?>"><br><br>

        <label>NPM</label><br>
        <input type="text" name="npm" required value="<?php echo htmlspecialchars($data['npm']); ?>"><br><br>

        <label>Kelas</label><br>
        <input type="text" name="kelas" required value="<?php echo htmlspecialchars($data['kelas']); ?>"><br><br>

        <label>Status Kehadiran</label><br>
        <select name="status_kehadiran" required>
            <option value="Hadir" <?php if($data['status_kehadiran']=='Hadir') echo 'selected'; ?>>Hadir</option>
            <option value="Sakit" <?php if($data['status_kehadiran']=='Sakit') echo 'selected'; ?>>Sakit</option>
            <option value="Izin" <?php if($data['status_kehadiran']=='Izin') echo 'selected'; ?>>Izin</option>
        </select><br><br>

        <label>Bukti Foto Saat Ini</label><br>
        <?php if (!empty($data['bukti_foto']) && file_exists('bukti/'.$data['bukti_foto'])): ?>
            <img src="bukti/<?php echo rawurlencode($data['bukti_foto']); ?>" style="width:150px"><br>
        <?php else: ?>
            <em>Tidak ada bukti</em><br>
        <?php endif; ?>
        <br>
        <label>Ganti Bukti Foto (opsional)</label><br>
        <input type="file" name="bukti" accept=".jpg,.jpeg,.png"><br><small>Biarkan kosong jika tidak ingin mengganti</small><br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php" style="margin-left:8px">Batal</a>
    </form>
</body>
</html>
<?php $koneksi->close(); ?>
