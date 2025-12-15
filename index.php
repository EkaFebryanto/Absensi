<?php
include 'koneksi.php';

$q = "";
if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
}

// Query: jika ada kata kunci, cari berdasarkan nama_mahasiswa atau npm
if ($q !== "") {
    $like = "%{$q}%";
    $stmt = $koneksi->prepare("SELECT * FROM absensi_ukri WHERE nama_mahasiswa LIKE ? OR npm LIKE ? ORDER BY id ASC");
    $stmt->bind_param("ss", $like, $like);
} else {
    $stmt = $koneksi->prepare("SELECT * FROM absensi_ukri ORDER BY id ASC");
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Absensi - UKRI</title>
    <style>
        table{border-collapse:collapse;width:100%}
        th,td{border:1px solid #e40e0eff;padding:8px}
        th{background:#fffff}
        img.thumb{width:80px;height:auto}
        .actions a{margin-right:6px}
    </style>
</head>
<body>
    <h1><center>Daftar Absensi Mahasiswa</center></h1>

    <form method="get" style="margin-bottom:12px">
        <input type="text" name="q" placeholder="Cari nama atau NPM..." value="<?php echo htmlspecialchars($q); ?>">
        <button type="submit">Cari</button>
        <a href="index.php" style="margin-left:8px">Reset</a>
    </form>

    <p><a href="tambah.php">+ Tambah Absensi</a></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Bukti Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['npm']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                <td><?php echo htmlspecialchars($row['status_kehadiran']); ?></td>
                <td style="text-align:center">
                    <?php if (!empty($row['bukti_foto']) && file_exists('bukti/'.$row['bukti_foto'])): ?>
                        <a href="bukti/<?php echo rawurlencode($row['bukti_foto']); ?>" target="_blank">
                            <img src="bukti/<?php echo rawurlencode($row['bukti_foto']); ?>" class="thumb" alt="bukti">
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="detail.php?id=<?php echo $row['id']; ?>">Detail</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
<?php
$stmt->close();
$koneksi->close();
?>
