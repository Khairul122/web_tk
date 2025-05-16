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
                  <h4 class="card-title"><?= isset($kriteria) ? 'Edit' : 'Tambah' ?> Kriteria</h4>

                  <form action="index.php?controller=Kriteria&action=<?= isset($kriteria) ? 'update' : 'simpan' ?>" method="POST">
                    <?php if (isset($kriteria)): ?>
                      <input type="hidden" name="id" value="<?= $kriteria['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                      <label for="kode" class="form-label">Kode Kriteria</label>
                      <input type="text" class="form-control" id="kode" name="kode" value="<?= $kriteria['kode'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama Kriteria</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?= $kriteria['nama'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="deskripsi" class="form-label">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"><?= $kriteria['deskripsi'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="jenis" class="form-label">Jenis</label>
                      <select class="form-select" name="jenis" id="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="benefit" <?= (isset($kriteria) && $kriteria['jenis'] === 'benefit') ? 'selected' : '' ?>>Benefit</option>
                        <option value="cost" <?= (isset($kriteria) && $kriteria['jenis'] === 'cost') ? 'selected' : '' ?>>Cost</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?controller=Kriteria&action=index" class="btn btn-secondary">Kembali</a>
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
