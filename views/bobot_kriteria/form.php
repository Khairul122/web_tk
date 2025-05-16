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
                  <h4 class="card-title"><?= isset($bobot) ? 'Edit' : 'Tambah' ?> Bobot Kriteria</h4>

                  <form action="index.php?controller=BobotKriteria&action=<?= isset($bobot) ? 'update' : 'simpan' ?>" method="POST">
                    <?php if (isset($bobot)): ?>
                      <input type="hidden" name="id" value="<?= $bobot['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                      <label for="kriteria_id" class="form-label">Pilih Kriteria</label>
                      <select class="form-select" name="kriteria_id" id="kriteria_id" required>
                        <option value="">-- Pilih Kriteria --</option>
                        <?php foreach ($kriteria as $k): ?>
                          <option value="<?= $k['id'] ?>" <?= isset($bobot) && $bobot['kriteria_id'] == $k['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="bobot" class="form-label">Bobot</label>
                      <input type="number" step="0.00001" min="0" class="form-control" id="bobot" name="bobot" value="<?= $bobot['bobot'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="jenis" class="form-label">Jenis</label>
                      <select class="form-select" name="jenis" id="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="ahp" <?= isset($bobot) && $bobot['jenis'] == 'ahp' ? 'selected' : '' ?>>AHP</option>
                        <option value="vikor" <?= isset($bobot) && $bobot['jenis'] == 'vikor' ? 'selected' : '' ?>>VIKOR</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?controller=BobotKriteria&action=index" class="btn btn-secondary">Kembali</a>
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
