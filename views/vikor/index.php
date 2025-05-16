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
                  <h4 class="card-title">Metode VIKOR</h4>
                  <p class="card-description">
                    Metode VIKOR (VIseKriterijumska Optimizacija I Kompromisno Resenje) digunakan untuk menyelesaikan permasalahan multi kriteria.
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
                  
                  <div class="row mt-4">
                    <div class="col-md-4 stretch-card grid-margin">
                      <div class="card bg-gradient-primary card-img-holder text-white">
                        <div class="card-body">
                          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                          <h4 class="font-weight-normal mb-3">Parameter VIKOR <i class="mdi mdi-settings mdi-24px float-right"></i>
                          </h4>
                          <h2 class="mb-5">V = <?= isset($parameterVikor['nilai_v']) ? number_format($parameterVikor['nilai_v'], 2) : '0.50'; ?></h2>
                          <a href="index.php?controller=Vikor&action=parameterVikor" class="text-white">Pengaturan Parameter</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                      <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                          <h4 class="font-weight-normal mb-3">Preferensi Kriteria <i class="mdi mdi-account-check mdi-24px float-right"></i>
                          </h4>
                          <h2 class="mb-5"><?= count($bobotKriteria); ?> Kriteria</h2>
                          <a href="index.php?controller=Vikor&action=preferensiOrangTua" class="text-white">Pengaturan Preferensi</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                      <div class="card bg-gradient-info card-img-holder text-white">
                        <div class="card-body">
                          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                          <h4 class="font-weight-normal mb-3">Hasil Rekomendasi <i class="mdi mdi-chart-bar mdi-24px float-right"></i>
                          </h4>
                          <h2 class="mb-5"><?= count($hasilRekomendasi); ?> Sekolah</h2>
                          <a href="index.php?controller=Vikor&action=hasilRekomendasi" class="text-white">Lihat Hasil</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 mt-4">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Langkah-langkah Metode VIKOR</h4>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mt-3">
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">1</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Membuat matriks keputusan dan menentukan bobot kriteria</p>
                                  </div>
                                </div>
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">2</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Menentukan nilai terbaik (f*) dan nilai terburuk (f-) untuk setiap kriteria</p>
                                  </div>
                                </div>
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">3</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Menghitung nilai utility measure (S) dan regret measure (R)</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mt-3">
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">4</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Menghitung nilai indeks VIKOR (Q)</p>
                                  </div>
                                </div>
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">5</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Melakukan perankingan berdasarkan nilai Q</p>
                                  </div>
                                </div>
                                <div class="d-flex py-2">
                                  <div class="wrapper mr-3">
                                    <p class="mb-0 text-primary font-weight-medium text-xl-center">6</p>
                                  </div>
                                  <div class="wrapper">
                                    <p class="mb-0">Mengusulkan solusi kompromi berdasarkan hasil perankingan</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="mt-4 text-center">
                            <a href="index.php?controller=Vikor&action=hitungRekomendasi" class="btn btn-gradient-primary btn-lg">
                              <i class="mdi mdi-calculator"></i> Hitung Rekomendasi
                            </a>
                            <a href="index.php?controller=Vikor&action=matriksKeputusan" class="btn btn-gradient-info btn-lg">
                              <i class="mdi mdi-table"></i> Lihat Matriks Keputusan
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <?php if (count($hasilRekomendasi) > 0): ?>
                  <div class="row mt-4">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Top 5 Rekomendasi TK</h4>
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
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $counter = 0;
                                foreach ($hasilRekomendasi as $hasil): 
                                  $counter++;
                                  if ($counter > 5) break;
                                ?>
                                <tr>
                                  <td><?= $hasil['peringkat']; ?></td>
                                  <td><?= $hasil['nama_tk']; ?></td>
                                  <td><?= substr($hasil['alamat'], 0, 50) . (strlen($hasil['alamat']) > 50 ? '...' : ''); ?></td>
                                  <td><?= number_format($hasil['nilai_s'], 4); ?></td>
                                  <td><?= number_format($hasil['nilai_r'], 4); ?></td>
                                  <td><?= number_format($hasil['nilai_q'], 4); ?></td>
                                  <td>
                                    <a href="index.php?controller=Vikor&action=detailRekomendasi&sekolah_id=<?= $hasil['sekolah_id']; ?>" class="btn btn-sm btn-gradient-info">
                                      <i class="mdi mdi-eye"></i> Detail
                                    </a>
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($hasilRekomendasi) == 0): ?>
                                <tr>
                                  <td colspan="7" class="text-center">Belum ada hasil rekomendasi</td>
                                </tr>
                                <?php endif; ?>
                              </tbody>
                            </table>
                          </div>
                          <?php if (count($hasilRekomendasi) > 0): ?>
                          <div class="mt-3 text-center">
                            <a href="index.php?controller=Vikor&action=hasilRekomendasi" class="btn btn-outline-primary">
                              <i class="mdi mdi-format-list-bulleted"></i> Lihat Semua Rekomendasi
                            </a>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
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