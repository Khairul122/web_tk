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
            <div class="col-12">

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title text-primary">Kuisioner Preferensi Orang Tua</h4>

                  <?php if ($sudah_isi): ?>
                    <div class="alert alert-info">
                      Anda sudah mengisi kuisioner. Terima kasih.
                    </div>
                  <?php else: ?>
                    <form method="POST" action="index.php?controller=PreferensiOrangtua&action=simpanKuisioner">
                      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">

                      <?php foreach ($kriteria as $krit): ?>
                        <div class="mb-3">
                          <label class="form-label">
                            <?= "Seberapa penting <strong>{$krit['nama']}</strong> dalam memilih TK?" ?>
                          </label>
                          <select name="preferensi[<?= $krit['id'] ?>]" class="form-select" required>
                            <option value="">-- Pilih jawaban --</option>
                            <option value="1">Tidak penting</option>
                            <option value="2">Kurang penting</option>
                            <option value="3">Cukup penting</option>
                            <option value="4">Penting</option>
                            <option value="5">Sangat penting</option>
                          </select>
                        </div>
                      <?php endforeach; ?>

                      <button type="submit" class="btn btn-primary">Simpan Preferensi</button>
                    </form>
                  <?php endif; ?>

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
