<?php
include 'koneksi.php';
if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = intval($_GET['id']);
$stmt = $koneksi->prepare("SELECT * FROM absensi_ukri WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();
if (!$data) { die("Data tidak ditemukan."); }
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Detail Absensi</title></head>
<body>
    <h1>Detail Absensi</h1>
    <p><strong>NPM:</strong> <?php echo htmlspecialchars($data['npm']); ?></p>
    <p><strong>Nama:</strong> <?php echo htmlspecialchars($data['nama_mahasiswa']); ?></p>
    <p><strong>Kelas:</strong> <?php echo htmlspecialchars($data['kelas']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($data['status_kehadiran']); ?></p>
    <p><strong>Bukti Foto:</strong><br>
    <?php if (!empty($data['bukti_foto']) && file_exists('bukti/'.$data['bukti_foto'])): ?>
        <a href="bukti/<?php echo rawurlencode($data['bukti_foto']); ?>" target="_blank">
            <img src="bukti/<?php echo rawurlencode($data['bukti_foto']); ?>" style="width:300px">
        </a>
    <?php else: ?>
        <em>Tidak ada bukti</em>
    <?php endif; ?>
    </p>
    <p><a href="index.php">Kembali</a></p>
</body>
</html>
<?php $koneksi->close(); ?>
