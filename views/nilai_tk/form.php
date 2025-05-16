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
            <div class="col-md-10 offset-md-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Input Nilai TK Sekaligus</h4>

                  <form action="index.php?controller=NilaiTk&action=simpan" method="POST">
                    <div class="mb-3">
                      <label for="sekolah_id" class="form-label">Pilih TK</label>
                      <select class="form-select" name="sekolah_id" id="sekolah_id" required>
                        <option value="">-- Pilih TK --</option>
                        <?php foreach ($sekolah as $s): ?>
                          <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_tk']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <hr>

                    <?php foreach ($kriteria as $k): ?>
                      <div class="mb-4 border p-3 rounded">
                        <h6><?= htmlspecialchars($k['kode']) ?> - <?= htmlspecialchars($k['nama']) ?></h6>

                        <input type="hidden" name="kriteria_id[]" value="<?= $k['id'] ?>">

                        <div class="mb-2">
                          <label for="nilai_<?= $k['id'] ?>" class="form-label">Nilai:</label>
                          <input type="number" step="0.01" name="nilai[]" class="form-control nilai-input" required>
                        </div>

                        <div class="mb-2">
                          <label for="subkriteria_id_<?= $k['id'] ?>" class="form-label">Subkriteria (opsional):</label>
                          <select class="form-select subkriteria-select" name="subkriteria_id[]" onchange="isiNilaiOtomatis(this)">
                            <option value="" data-nilai="">-- Pilih Subkriteria --</option>
                            <?php foreach ($subkriteria as $sub): ?>
                              <?php if ($sub['kriteria_id'] == $k['id']): ?>
                                <option value="<?= $sub['id'] ?>" data-nilai="<?= $sub['nilai'] ?>">
                                  <?= htmlspecialchars($sub['nama']) ?>
                                </option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary">Simpan Semua Nilai</button>
                    <a href="index.php?controller=NilaiTk&action=index" class="btn btn-secondary">Kembali</a>
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
  <script>
    function isiNilaiOtomatis(selectElement) {
      const selectedOption = selectElement.options[selectElement.selectedIndex];
      const nilai = selectedOption.getAttribute('data-nilai');

      const formGroup = selectElement.closest('.mb-4');
      const inputNilai = formGroup.querySelector('.nilai-input');

      if (nilai !== "") {
        inputNilai.value = nilai;
      }
    }
  </script>
</body>
</html>
