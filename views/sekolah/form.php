<?php include('template/header.php'); ?>

<body class="with-welcome-text">
    <div class="container-scroller">
        <?php include 'template/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'template/setting_panel.php'; ?>
            <?php include 'template/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?= isset($sekolah) ? 'Edit' : 'Tambah' ?> Sekolah TK</h4>

                                    <form action="index.php?controller=Sekolah&action=<?= isset($sekolah) ? 'update' : 'simpan' ?>" method="POST" enctype="multipart/form-data">
                                        <?php if (isset($sekolah)): ?>
                                            <input type="hidden" name="id" value="<?= $sekolah['id'] ?>">
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label for="nama_tk" class="form-label">Nama TK</label>
                                            <input type="text" class="form-control" name="nama_tk" id="nama_tk" value="<?= $sekolah['nama_tk'] ?? '' ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= $sekolah['alamat'] ?? '' ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"><?= $sekolah['deskripsi'] ?? '' ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="kontak" class="form-label">Kontak</label>
                                            <input type="text" class="form-control" name="kontak" id="kontak" value="<?= $sekolah['kontak'] ?? '' ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?= $sekolah['email'] ?? '' ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" name="latitude" id="latitude" value="<?= $sekolah['latitude'] ?? '' ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" name="longitude" id="longitude" value="<?= $sekolah['longitude'] ?? '' ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto (Upload)</label>
                                            <input type="file" class="form-control" name="foto" id="foto" <?= isset($sekolah) ? '' : 'required' ?>>
                                            <?php if (!empty($sekolah['foto'])): ?>
                                                <small>File sebelumnya: <?= $sekolah['foto'] ?></small>
                                            <?php endif; ?>
                                        </div>


                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="index.php?controller=Sekolah&action=index" class="btn btn-secondary">Kembali</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include 'template/script.php'; ?>
</body>

</html>