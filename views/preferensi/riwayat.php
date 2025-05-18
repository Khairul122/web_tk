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
                  <h4 class="card-title text-primary">Riwayat Kuisioner Preferensi Orang Tua</h4>
                  
                  <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                      <?= $_SESSION['success']; ?>
                      <?php unset($_SESSION['success']); ?>
                    </div>
                  <?php endif; ?>
                  
                  <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                      <?= $_SESSION['error']; ?>
                      <?php unset($_SESSION['error']); ?>
                    </div>
                  <?php endif; ?>
                  
                  <div class="mb-3">
                    <a href="index.php?controller=PreferensiOrangtua&action=index" class="btn btn-primary">
                      <i class="mdi mdi-plus"></i> Isi Kuesioner Baru
                    </a>
                  </div>

                  <?php if (empty($riwayat_preferensi)): ?>
                    <div class="alert alert-info">
                      Belum ada data preferensi yang tersimpan.
                    </div>
                  <?php else: ?>
                    <?php foreach ($riwayat_preferensi as $timestamp => $preferensi_set): ?>
                      <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Preferensi Tanggal: <?= date('d F Y H:i', strtotime($timestamp)) ?></h5>
                          <a href="index.php?controller=PreferensiOrangtua&action=hapusKuisioner&created_at=<?= urlencode($timestamp) ?>" 
                             class="btn btn-sm btn-danger" 
                             onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="mdi mdi-delete"></i> Hapus
                          </a>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%">No</th>
                                  <th width="40%">Kriteria</th>
                                  <th width="15%">Nilai</th>
                                  <th width="40%">Keterangan</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($preferensi_set as $kriteria_id => $data): ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama_kriteria'] ?></td>
                                    <td><?= $data['nilai'] ?></td>
                                    <td>
                                      <?php 
                                        $nilai = floatval($data['nilai']);
                                        if ($nilai == 0) {
                                          echo 'Tidak';
                                        } elseif ($nilai == 1) {
                                          echo 'Sangat Kurang / Tidak';
                                        } elseif ($nilai == 2) {
                                          echo 'Kurang';
                                        } elseif ($nilai == 3) {
                                          echo 'Cukup';
                                        } elseif ($nilai == 4) {
                                          echo 'Baik';
                                        } elseif ($nilai == 5) {
                                          echo 'Sangat Baik / Ya';
                                        } else {
                                          echo 'Nilai Kustom: ' . $nilai;
                                        }
                                      ?>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
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