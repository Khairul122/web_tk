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
                    <i class="mdi mdi-chart-bar"></i>
                  </span> Detail Hasil Perhitungan AHP
                </h3>
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?controller=AHP&action=index">AHP</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hasil Perhitungan</li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <?php if (!$hasil): ?>
          <div class="alert alert-warning">
            Belum ada hasil perhitungan AHP. Silakan lakukan perhitungan terlebih dahulu.
          </div>
          <div class="text-center mt-4">
            <a href="index.php?controller=AHP&action=index" class="btn btn-gradient-primary">Kembali ke AHP</a>
          </div>
          <?php else: ?>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Matriks Perbandingan Awal</h4>
                  <p class="card-description">Matriks perbandingan berpasangan yang diisi oleh pengguna</p>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Kriteria</th>
                          <?php foreach ($kriteria as $k): ?>
                          <th><?= $k['kode'] ?></th>
                          <?php endforeach; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kriteria as $baris): ?>
                        <tr>
                          <td><strong><?= $baris['kode'] ?></strong></td>
                          <?php foreach ($kriteria as $kolom): ?>
                          <td><?= number_format($hasil['matriksA'][$baris['id']][$kolom['id']], 4) ?></td>
                          <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                          <td><strong>Jumlah</strong></td>
                          <?php foreach ($kriteria as $k): ?>
                          <td><strong><?= number_format($hasil['jumlahKolom'][$k['id']], 4) ?></strong></td>
                          <?php endforeach; ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Matriks Normalisasi</h4>
                  <p class="card-description">Hasil normalisasi matriks perbandingan berpasangan</p>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Kriteria</th>
                          <?php foreach ($kriteria as $k): ?>
                          <th><?= $k['kode'] ?></th>
                          <?php endforeach; ?>
                          <th>Jumlah</th>
                          <th>Bobot</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kriteria as $baris): ?>
                        <tr>
                          <td><strong><?= $baris['kode'] ?></strong></td>
                          <?php 
                          $jumlahBaris = 0;
                          foreach ($kriteria as $kolom): 
                            $jumlahBaris += $hasil['matriksNormalisasi'][$baris['id']][$kolom['id']];
                          ?>
                          <td><?= number_format($hasil['matriksNormalisasi'][$baris['id']][$kolom['id']], 4) ?></td>
                          <?php endforeach; ?>
                          <td><?= number_format($jumlahBaris, 4) ?></td>
                          <td><strong><?= number_format($hasil['bobot'][$baris['id']], 4) ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Hasil Bobot Kriteria</h4>
                  <p class="card-description">Bobot prioritas dari setiap kriteria</p>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Kriteria</th>
                          <th>Kode</th>
                          <th>Bobot</th>
                          <th>Persentase</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kriteria as $k): ?>
                        <tr>
                          <td><?= $k['nama'] ?></td>
                          <td><strong><?= $k['kode'] ?></strong></td>
                          <td><?= number_format($hasil['bobot'][$k['id']], 4) ?></td>
                          <td><?= number_format($hasil['bobot'][$k['id']] * 100, 2) ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Consistency Ratio</h4>
                  <p class="card-description">Pengecekan konsistensi matriks perbandingan</p>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Kriteria</th>
                          <th>Consistency Vector</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kriteria as $k): ?>
                        <tr>
                          <td><strong><?= $k['kode'] ?></strong></td>
                          <td><?= number_format($hasil['consistencyVector'][$k['id']], 4) ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="mt-4">
                    <table class="table">
                      <tr>
                        <td>Lambda Max (λmax)</td>
                        <td><?= number_format($hasil['lambdaMax'], 4) ?></td>
                      </tr>
                      <tr>
                        <td>Consistency Index (CI)</td>
                        <td><?= number_format($hasil['ci'], 4) ?></td>
                      </tr>
                      <tr>
                        <td>Random Index (RI)</td>
                        <td><?= number_format($hasil['ri'], 4) ?></td>
                      </tr>
                      <tr>
                        <td><strong>Consistency Ratio (CR)</strong></td>
                        <td>
                          <strong><?= number_format($hasil['cr'], 4) ?></strong>
                          <?php if ($hasil['cr'] <= 0.1): ?>
                          <span class="badge bg-success">Konsisten</span>
                          <?php else: ?>
                          <span class="badge bg-danger">Tidak Konsisten</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    </table>
                    
                    <?php if ($hasil['cr'] <= 0.1): ?>
                    <div class="alert alert-success mt-3">
                      <i class="mdi mdi-check-circle"></i> Matriks perbandingan konsisten (CR ≤ 0.1). Hasil bobot kriteria dapat digunakan.
                    </div>
                    <?php else: ?>
                    <div class="alert alert-danger mt-3">
                      <i class="mdi mdi-alert-circle"></i> Matriks perbandingan tidak konsisten (CR > 0.1). Silakan perbaiki perbandingan antar kriteria.
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center mt-4 mb-4">
            <a href="index.php?controller=AHP&action=index" class="btn btn-gradient-primary">Kembali ke AHP</a>
          </div>
          
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>

</html>