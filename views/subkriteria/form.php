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
                  <h4 class="card-title"><?= isset($subkriteria) ? 'Edit' : 'Tambah' ?> Subkriteria</h4>

                  <form action="index.php?controller=Subkriteria&action=<?= isset($subkriteria) ? 'update' : 'simpan' ?>" method="POST">
                    <?php if (isset($subkriteria)): ?>
                      <input type="hidden" name="id" value="<?= $subkriteria['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                      <label for="kriteria_id" class="form-label">Pilih Kriteria</label>
                      <select class="form-select" name="kriteria_id" id="kriteria_id" required>
                        <option value="">-- Pilih Kriteria --</option>
                        <?php foreach ($kriteria as $k): ?>
                          <option value="<?= $k['id'] ?>" <?= isset($subkriteria) && $subkriteria['kriteria_id'] == $k['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama Subkriteria</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?= $subkriteria['nama'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="nilai" class="form-label">Nilai</label>
                      <input type="number" class="form-control" id="nilai" name="nilai" value="<?= $subkriteria['nilai'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="keterangan" class="form-label">Keterangan</label>
                      <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $subkriteria['keterangan'] ?? '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?controller=Subkriteria&action=index" class="btn btn-secondary">Kembali</a>
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
