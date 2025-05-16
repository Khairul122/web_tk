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
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Parameter VIKOR</h4>
                  <p class="card-description">
                    Pengaturan parameter untuk perhitungan metode VIKOR.
                  </p>
                  
                  <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?= $_SESSION['success']; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                  <?php endif; ?>

                  <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?= $_SESSION['error']; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                  <?php endif; ?>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card bg-gradient-light">
                        <div class="card-body">
                          <h5 class="card-title">Keterangan Parameter V</h5>
                          <p>Parameter V pada metode VIKOR mewakili bobot dari strategi "utility of the majority" (maksimum group utility). Nilai ini berkisar antara 0 sampai 1.</p>
                          <ul>
                            <li>V = 0.5: Pendekatan seimbang antara utility kelompok dan regret individual</li>
                            <li>V > 0.5: Lebih menekankan pada utility kelompok (mayoritas)</li>
                            <li>V < 0.5: Lebih menekankan pada mengurangi regret individual (minoritas)</li>
                          </ul>
                          <p>Secara default, nilai V yang digunakan adalah 0.5 yang merepresentasikan keseimbangan antara utility maksimum kelompok dan regret minimum individual.</p>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <form class="forms-sample" method="POST" action="index.php?controller=Vikor&action=simpanParameter">
                        <div class="form-group">
                          <label for="nilai_v">Nilai V</label>
                          <input type="number" class="form-control" id="nilai_v" name="nilai_v" placeholder="Masukkan nilai V" value="<?= isset($parameterVikor['nilai_v']) ? $parameterVikor['nilai_v'] : '0.5'; ?>" step="0.01" min="0" max="1" required>
                          <small class="form-text text-muted">Masukkan nilai antara 0 dan 1</small>
                        </div>
                        <div class="form-group">
                          <label for="keterangan">Keterangan</label>
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Tambahkan keterangan tentang parameter (opsional)"><?= isset($parameterVikor['keterangan']) ? $parameterVikor['keterangan'] : ''; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a href="index.php?controller=Vikor&action=index" class="btn btn-light">Batal</a>
                      </form>
                    </div>
                  </div>
                  
                  <!-- Penjelasan Pengaruh Parameter V -->
                  <div class="row mt-4">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Pengaruh Parameter V Terhadap Hasil Rekomendasi</h5>
                          <p>Parameter V memengaruhi perhitungan nilai indeks VIKOR (Q) dengan rumus:</p>
                          <div class="text-center mb-3">
                            <strong>Q<sub>i</sub> = V × (S<sub>i</sub> - S<sup>*</sup>)/(S<sup>-</sup> - S<sup>*</sup>) + (1-V) × (R<sub>i</sub> - R<sup>*</sup>)/(R<sup>-</sup> - R<sup>*</sup>)</strong>
                          </div>
                          <p>Dimana:</p>
                          <ul>
                            <li>S<sub>i</sub> adalah nilai utility measure untuk alternatif ke-i</li>
                            <li>R<sub>i</sub> adalah nilai regret measure untuk alternatif ke-i</li>
                            <li>S<sup>*</sup> dan R<sup>*</sup> adalah nilai terbaik dari S dan R</li>
                            <li>S<sup>-</sup> dan R<sup>-</sup> adalah nilai terburuk dari S dan R</li>
                          </ul>
                          <p>Mengubah nilai parameter V dapat menggeser peringkat hasil rekomendasi terutama jika terdapat perbedaan signifikan antara nilai S dan R antar alternatif.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
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