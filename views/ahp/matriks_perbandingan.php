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
              <div class="page-header">
                <h3 class="page-title">
                  <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-matrix"></i>
                  </span> Matriks Perbandingan Berpasangan
                </h3>
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?controller=AHP&action=index">AHP</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Matriks Perbandingan</li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['error']); endif; ?>

          <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['success']); endif; ?>

          <div class="row mb-4">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mode Pengisian Matriks</h4>
                  <p class="card-description">Pilih cara pengisian matriks perbandingan</p>
                  
                  <div class="d-flex gap-3">
                    <a href="index.php?controller=AHP&action=matriksManual" class="btn btn-primary">
                      <i class="mdi mdi-pencil"></i> Isi Manual
                    </a>
                    <?php if ($isBohotAHPExist): ?>
                    <a href="index.php?controller=AHP&action=matriksOtomatis" class="btn btn-success">
                      <i class="mdi mdi-auto-fix"></i> Isi Otomatis dari Bobot
                    </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Panduan Skala Perbandingan</h4>
                  <p class="card-description">Gunakan skala berikut untuk mengisi nilai perbandingan berpasangan</p>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Nilai</th>
                          <th>Definisi</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Sama penting</td>
                          <td>Kedua kriteria memiliki kepentingan yang sama</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Cukup penting</td>
                          <td>Satu kriteria sedikit lebih penting dari yang lain</td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Lebih penting</td>
                          <td>Satu kriteria lebih penting dari yang lain</td>
                        </tr>
                        <tr>
                          <td>7</td>
                          <td>Sangat penting</td>
                          <td>Satu kriteria sangat lebih penting dari yang lain</td>
                        </tr>
                        <tr>
                          <td>9</td>
                          <td>Mutlak lebih penting</td>
                          <td>Satu kriteria mutlak lebih penting dari yang lain</td>
                        </tr>
                        <tr>
                          <td>2, 4, 6, 8</td>
                          <td>Nilai tengah</td>
                          <td>Nilai antara dua penilaian yang berdekatan</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Input Matriks Perbandingan</h4>
                  <p class="card-description">Isi nilai perbandingan berpasangan antar kriteria</p>
                  
                  <form action="index.php?controller=AHP&action=simpanMatriks" method="POST">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="table-light">
                          <tr>
                            <th>Kriteria</th>
                            <?php foreach ($kriteria as $k): ?>
                            <th><?= $k['kode'] ?> - <?= $k['nama'] ?></th>
                            <?php endforeach; ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($kriteria as $baris): ?>
                          <tr>
                            <td><strong><?= $baris['kode'] ?> - <?= $baris['nama'] ?></strong></td>
                            <?php foreach ($kriteria as $kolom): ?>
                            <td>
                              <?php if ($baris['id'] == $kolom['id']): ?>
                                <input type="hidden" name="kriteria_baris[]" value="<?= $baris['id'] ?>">
                                <input type="hidden" name="kriteria_kolom[]" value="<?= $kolom['id'] ?>">
                                <input type="hidden" name="nilai[]" value="1">
                                <span class="badge bg-secondary">1</span>
                              <?php elseif ($baris['id'] < $kolom['id']): ?>
                                <input type="hidden" name="kriteria_baris[]" value="<?= $baris['id'] ?>">
                                <input type="hidden" name="kriteria_kolom[]" value="<?= $kolom['id'] ?>">
                                <select name="nilai[]" class="form-select form-select-sm">
                                  <?php 
                                  $selectedValue = isset($matriksValues[$baris['id']][$kolom['id']]) ? $matriksValues[$baris['id']][$kolom['id']] : '';
                                  for ($i = 1; $i <= 9; $i++) {
                                    $selected = ($selectedValue == $i) ? 'selected' : '';
                                    echo "<option value=\"$i\" $selected>$i</option>";
                                  }
                                  for ($i = 2; $i <= 9; $i++) {
                                    $value = 1 / $i;
                                    $display = "1/" . $i;
                                    $selected = (abs($selectedValue - $value) < 0.0001) ? 'selected' : '';
                                    echo "<option value=\"$value\" $selected>$display</option>";
                                  }
                                  ?>
                                </select>
                              <?php else: ?>
                                <?php
                                  $inverseValue = isset($matriksValues[$kolom['id']][$baris['id']]) ? $matriksValues[$kolom['id']][$baris['id']] : '';
                                  if ($inverseValue > 0) {
                                    $displayValue = ($inverseValue >= 1) ? "1/" . $inverseValue : number_format(1 / $inverseValue, 2);
                                  } else {
                                    $displayValue = "?";
                                  }
                                ?>
                                <span class="badge bg-info"><?= $displayValue ?></span>
                              <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    
                    <div class="mt-4">
                      <button type="submit" class="btn btn-gradient-primary me-2">
                        <i class="mdi mdi-content-save"></i> Simpan Matriks
                      </button>
                      <a href="index.php?controller=AHP&action=index" class="btn btn-light">Kembali</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Petunjuk Pengisian</h4>
                  <p>Untuk mengisi matriks perbandingan, ikuti langkah-langkah berikut:</p>
                  <ol>
                    <li>Tentukan tingkat kepentingan relatif antara dua kriteria dengan menggunakan skala 1-9.</li>
                    <li>Jika kriteria pada baris lebih penting dari kriteria pada kolom, pilih nilai > 1.</li>
                    <li>Jika kriteria pada baris kurang penting dari kriteria pada kolom, pilih nilai berupa pecahan (1/nilai).</li>
                    <li>Setelah mengisi semua nilai perbandingan, klik "Simpan Matriks".</li>
                    <li>Nilai perbandingan kebalikan (bagian bawah diagonal) akan dihitung otomatis.</li>
                  </ol>
                  <p><strong>Catatan:</strong> Pastikan pengisian nilai konsisten untuk mendapatkan hasil AHP yang valid (CR < 0.1).</p>
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