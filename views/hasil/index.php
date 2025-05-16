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
                    <i class="mdi mdi-trophy"></i>
                  </span> Hasil Rekomendasi Taman Kanak-kanak
                </h3>
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                      <span></span>Hasil Perhitungan AHP dan VIKOR
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['success']); endif; ?>

          <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['error']); endif; ?>

          <!-- Quick Action Buttons -->
          <div class="row">
            <div class="col-md-12 mb-4">
              <div class="card">
                <div class="card-body py-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Aksi Cepat</h4>
                    <div>
                      <a href="index.php?controller=Hasil&action=hitungUlang" class="btn btn-gradient-primary">
                        <i class="mdi mdi-refresh"></i> Hitung Ulang
                      </a>
                      <a href="index.php?controller=Hasil&action=cetak" class="btn btn-gradient-success" target="_blank">
                        <i class="mdi mdi-printer"></i> Cetak Hasil
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php if (empty($hasil)): ?>
            <!-- No Results -->
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body text-center py-5">
                    <h4 class="text-muted mb-4">Belum Ada Hasil Rekomendasi</h4>
                    <p>Anda belum memiliki preferensi yang tersimpan. Silakan isi preferensi terlebih dahulu.</p>
                    <a href="index.php?controller=Preferensi&action=index" class="btn btn-gradient-primary mt-3">
                      <i class="mdi mdi-tune"></i> Atur Preferensi
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <!-- Top 3 Recommendations -->
            <div class="row">
              <?php 
              $topThree = array_slice($hasil, 0, 3);
              $cardColors = ['bg-gradient-success', 'bg-gradient-primary', 'bg-gradient-info'];
              
              foreach ($topThree as $index => $tk): 
              ?>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card <?= $cardColors[$index] ?> card-img-holder text-white">
                  <div class="card-body">
                    <h4 class="font-weight-normal mb-3">
                      Peringkat #<?= ($index + 1) ?>
                      <i class="mdi mdi-trophy mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-2"><?= htmlspecialchars($tk['nama_tk']) ?></h2>
                    <p>
                      <i class="mdi mdi-map-marker"></i> <?= htmlspecialchars(substr($tk['alamat'], 0, 60)) . (strlen($tk['alamat']) > 60 ? '...' : '') ?>
                    </p>
                    <p>
                      <i class="mdi mdi-star"></i> Nilai Q: <?= number_format($tk['nilai_q'], 5) ?>
                    </p>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Lengkap Rekomendasi</h4>
                    <p class="card-description">Urutan rekomendasi berdasarkan perhitungan metode VIKOR</p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Peringkat</th>
                            <th>Nama TK</th>
                            <th>Alamat</th>
                            <th>Nilai S</th>
                            <th>Nilai R</th>
                            <th>Nilai Q</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($hasil as $index => $tk): ?>
                          <tr class="<?= $index < 3 ? 'table-info' : '' ?>">
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($tk['nama_tk']) ?></td>
                            <td><?= htmlspecialchars(substr($tk['alamat'], 0, 40)) . (strlen($tk['alamat']) > 40 ? '...' : '') ?></td>
                            <td><?= number_format($tk['nilai_s'], 5) ?></td>
                            <td><?= number_format($tk['nilai_r'], 5) ?></td>
                            <td><b><?= number_format($tk['nilai_q'], 5) ?></b></td>
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
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Matriks Nilai Kriteria</h4>
                    <p class="card-description">Nilai masing-masing TK untuk setiap kriteria</p>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-sm">
                        <thead class="table-light">
                          <tr>
                            <th>No</th>
                            <th>Nama TK</th>
                            <?php foreach ($kriteria as $krit): ?>
                            <th title="<?= htmlspecialchars($krit['nama']) ?>"><?= $krit['kode'] ?></th>
                            <?php endforeach; ?>
                            <th>Q</th>
                            <th>Peringkat</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($hasil as $index => $tk): ?>
                          <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($tk['nama_tk']) ?></td>
                            <?php foreach ($kriteria as $krit): ?>
                              <td>
                                <?php
                                $nilai = '-';
                                if (isset($nilaiSekolah[$tk['sekolah_id']])) {
                                  foreach ($nilaiSekolah[$tk['sekolah_id']] as $n) {
                                    if ($n['kriteria_id'] == $krit['id']) {
                                      $nilai = number_format($n['nilai'], 1);
                                      break;
                                    }
                                  }
                                }
                                echo $nilai;
                                ?>
                              </td>
                            <?php endforeach; ?>
                            <td><?= number_format($tk['nilai_q'], 3) ?></td>
                            <td>
                              <span class="badge <?= $index < 3 ? 'bg-success' : 'bg-secondary' ?>">
                                #<?= $index + 1 ?>
                              </span>
                            </td>
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
                    <h4 class="card-title">Preferensi Anda</h4>
                    <p class="card-description">Tingkat kepentingan yang Anda tetapkan untuk setiap kriteria</p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="table-success">
                          <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Nilai</th>
                            <th>Visualisasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($preferensi as $pref): ?>
                          <tr>
                            <td><?= $pref['kode_kriteria'] ?></td>
                            <td><?= htmlspecialchars($pref['nama_kriteria']) ?></td>
                            <td><?= $pref['nilai_preferensi'] ?></td>
                            <td>
                              <?php
                              $starCount = (int)$pref['nilai_preferensi'];
                              for ($i = 0; $i < $starCount; $i++) {
                                echo '<i class="mdi mdi-star text-warning"></i>';
                              }
                              for ($i = $starCount; $i < 5; $i++) {
                                echo '<i class="mdi mdi-star-outline text-muted"></i>';
                              }
                              ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-3">
                      <a href="index.php?controller=Preferensi&action=index" class="btn btn-gradient-primary">
                        <i class="mdi mdi-tune"></i> Ubah Preferensi
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Bobot Kriteria</h4>
                    <p class="card-description">Bobot akhir setelah disesuaikan dengan preferensi Anda</p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="table-primary">
                          <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Jenis</th>
                            <th>Bobot AHP</th>
                            <th>Bobot Akhir</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($bobot as $b): ?>
                          <tr>
                            <td><?= $b['kode_kriteria'] ?></td>
                            <td><?= htmlspecialchars($b['nama_kriteria']) ?></td>
                            <td>
                              <?php if ($b['jenis_kriteria'] == 'benefit'): ?>
                              <span class="badge bg-success">Benefit</span>
                              <?php else: ?>
                              <span class="badge bg-danger">Cost</span>
                              <?php endif; ?>
                            </td>
                            <td><?= number_format($b['bobot'], 3) ?></td>
                            <td>
                              <?php
                              $bobotAkhir = $b['bobot'];
                              foreach ($preferensi as $p) {
                                if ($p['kriteria_id'] == $b['kriteria_id']) {
                                  $scale = $p['nilai_preferensi'] / 3;
                                  $bobotAkhir = $b['bobot'] * $scale;
                                  break;
                                }
                              }
                              echo number_format($bobotAkhir, 3);
                              ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>

</html>