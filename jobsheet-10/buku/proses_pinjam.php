<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$idBuku = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$idAnggota = filter_var($_POST['id_anggota'] ?? null, FILTER_VALIDATE_INT);

if (!$idBuku || !$idAnggota) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Buku dan anggota harus dipilih dengan benar.'];
    header('Location: list.php');
    exit;
}

$pdo->beginTransaction();

try {
    $anggotaStmt = $pdo->prepare("SELECT id FROM anggota WHERE id = :id");
    $anggotaStmt->execute(['id' => $idAnggota]);
    if (!$anggotaStmt->fetch(PDO::FETCH_ASSOC)) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }

    $bukuStmt = $pdo->prepare(
        "UPDATE buku
         SET stok = stok - 1
         WHERE id = :id AND stok > 0
         RETURNING judul"
    );
    $bukuStmt->execute(['id' => $idBuku]);
    $buku = $bukuStmt->fetch(PDO::FETCH_ASSOC);

    if (!$buku) {
        $existsStmt = $pdo->prepare("SELECT id FROM buku WHERE id = :id");
        $existsStmt->execute(['id' => $idBuku]);
        $bukuAda = $existsStmt->fetch(PDO::FETCH_ASSOC);
        $pdo->rollBack();

        $_SESSION['flash'] = [
            'type' => 'error',
            'pesan' => $bukuAda ? 'Stok buku habis, tidak dapat dipinjam.' : 'Buku tidak ditemukan.',
        ];
        header('Location: list.php');
        exit;
    }

    $peminjamanStmt = $pdo->prepare(
        "INSERT INTO peminjaman (id_buku, id_anggota)
         VALUES (:id_buku, :id_anggota)"
    );
    $peminjamanStmt->execute([
        'id_buku' => $idBuku,
        'id_anggota' => $idAnggota,
    ]);

    $pdo->commit();
} catch (\Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    throw $e;
}

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Buku "' . htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8') . '" berhasil dipinjam. Stok berkurang satu.',
];
header('Location: list.php');
exit;
