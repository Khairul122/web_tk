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
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Hasil Rekomendasi Taman Kanak-kanak</h4>
                    <div>
                      <a href="index.php?controller=Vikor&action=hitungRekomendasi" class="btn btn-gradient-primary">
                        <i class="mdi mdi-refresh"></i> Hitung Ulang
                      </a>
                      <a href="index.php?controller=Vikor&action=cetakRekomendasi" target="_blank" class="btn btn-gradient-success">
                        <i class="mdi mdi-printer"></i> Cetak
                      </a>
                    </div>
                  </div>
                  
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
                  
                  <?php if (count($hasilRekomendasi) > 0): ?>
                    <!-- Informasi Terbaik -->
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <div class="card bg-gradient-success text-white">
                          <div class="card-body">
                            <div class="d-flex align-items-center">
                              <div class="mr-4">
                                <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                  <h1 class="mb-0">1</h1>
                                </div>
                              </div>
                              <div>
                                <h3 class="mb-1"><?= $hasilRekomendasi[0]['nama_tk']; ?></h3>
                                <p class="mb-1"><?= $hasilRekomendasi[0]['alamat']; ?></p>
                                <div class="d-flex">
                                  <div class="mr-4">
                                    <span class="font-weight-bold">Nilai Q:</span> <?= number_format($hasilRekomendasi[0]['nilai_q'], 4); ?>
                                  </div>
                                  <div class="mr-4">
                                    <span class="font-weight-bold">Nilai S:</span> <?= number_format($hasilRekomendasi[0]['nilai_s'], 4); ?>
                                  </div>
                                  <div>
                                    <span class="font-weight-bold">Nilai R:</span> <?= number_format($hasilRekomendasi[0]['nilai_r'], 4); ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="mt-3">
                              <a href="index.php?controller=Vikor&action=detailRekomendasi&sekolah_id=<?= $hasilRekomendasi[0]['sekolah_id']; ?>" class="btn btn-light">
                                <i class="mdi mdi-eye"></i> Lihat Detail
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Tabel Hasil -->
                    <div class="table-responsive">
                      <table class="table table-hover" id="tabelHasilRekomendasi">
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
                          <?php foreach ($hasilRekomendasi as $hasil): ?>
                          <tr <?= ($hasil['peringkat'] == 1) ? 'class="table-success"' : ''; ?>>
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
                        </tbody>
                      </table>
                    </div>
                    
                    <!-- Penjelasan Metrik -->
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Penjelasan Metrik VIKOR</h5>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="card bg-gradient-info text-white">
                                  <div class="card-body">
                                    <h5 class="card-title">Nilai S (Utility Measure)</h5>
                                    <p>Merepresentasikan nilai utility rata-rata. Nilai S yang lebih rendah menunjukkan alternatif yang lebih baik dari segi utility mayoritas.</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="card bg-gradient-danger text-white">
                                  <div class="card-body">
                                    <h5 class="card-title">Nilai R (Regret Measure)</h5>
                                    <p>Merepresentasikan nilai regret maksimum. Nilai R yang lebih rendah menunjukkan alternatif dengan regret individual minimum.</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="card bg-gradient-success text-white">
                                  <div class="card-body">
                                    <h5 class="card-title">Nilai Q (VIKOR Index)</h5>
                                    <p>Merupakan indeks akhir VIKOR yang menggabungkan S dan R. Nilai Q yang lebih rendah menunjukkan alternatif yang lebih baik.</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  <?php else: ?>
                    <div class="alert alert-warning">
                      <h4 class="alert-heading">Belum Ada Hasil Rekomendasi</h4>
                      <p>Anda belum melakukan perhitungan rekomendasi. Silahkan klik tombol "Hitung Ulang" untuk mendapatkan rekomendasi Taman Kanak-kanak.</p>
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
  
  <script>
    $(document).ready(function() {
      $('#tabelHasilRekomendasi').DataTable({
        "order": [[ 0, "asc" ]],
        "language": {
          "lengthMenu": "Tampilkan _MENU_ data per halaman",
          "zeroRecords": "Tidak ada data yang ditemukan",
          "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
          "infoEmpty": "Tidak ada data yang tersedia",
          "infoFiltered": "(difilter dari _MAX_ data)",
          "search": "Cari:",
          "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Selanjutnya",
            "previous": "Sebelumnya"
          }
        }
      });
    });
  </script>
</body>

</html>