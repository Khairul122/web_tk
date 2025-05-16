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
                  <h4 class="card-title">Matriks Keputusan</h4>
                  <p class="card-description">
                    Matriks keputusan untuk perhitungan metode VIKOR
                  </p>
                  
                  <div class="table-responsive">
                    <table class="table table-hover" id="tabelMatriksKeputusan">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>TK</th>
                          <?php foreach ($kriteria as $k): ?>
                          <th><?= $k['kode']; ?></th>
                          <?php endforeach; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        foreach ($sekolahTK as $sekolah):
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $sekolah['nama_tk']; ?></td>
                          <?php foreach ($kriteria as $k): ?>
                          <td><?= isset($matriksKeputusan[$sekolah['id']][$k['id']]) ? $matriksKeputusan[$sekolah['id']][$k['id']] : 0; ?></td>
                          <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <!-- Keterangan Kriteria -->
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Keterangan Kriteria</h5>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Kode</th>
                                  <th>Nama Kriteria</th>
                                  <th>Jenis</th>
                                  <th>Bobot VIKOR</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($kriteria as $k): ?>
                                <?php 
                                $bobot = 0;
                                foreach ($bobotKriteria as $bk) {
                                  if ($bk['kriteria_id'] == $k['id']) {
                                    $bobot = $bk['bobot'];
                                    break;
                                  }
                                }
                                ?>
                                <tr>
                                  <td><?= $k['kode']; ?></td>
                                  <td><?= $k['nama']; ?></td>
                                  <td>
                                    <span class="badge badge-<?= $k['jenis'] == 'benefit' ? 'success' : 'danger'; ?>">
                                      <?= $k['jenis']; ?>
                                    </span>
                                  </td>
                                  <td><?= number_format($bobot, 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Penjelasan Matriks Keputusan -->
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card bg-gradient-light">
                        <div class="card-body">
                          <h5 class="card-title">Penjelasan Matriks Keputusan</h5>
                          <p>Matriks keputusan adalah matriks yang berisi nilai setiap alternatif (TK) terhadap setiap kriteria. Matriks ini menjadi dasar perhitungan dalam metode VIKOR.</p>
                          <p>Langkah-langkah perhitungan VIKOR menggunakan matriks keputusan ini adalah:</p>
                          <ol>
                            <li>Menentukan nilai terbaik (f*) dan nilai terburuk (f-) untuk setiap kriteria berdasarkan jenis kriteria (benefit atau cost).</li>
                            <li>Menghitung nilai utility measure (S) dan regret measure (R) untuk setiap alternatif.</li>
                            <li>Menghitung nilai indeks VIKOR (Q) dengan parameter V yang telah ditentukan.</li>
                            <li>Meranking alternatif berdasarkan nilai Q dari terkecil ke terbesar.</li>
                          </ol>
                          <p class="mb-0">Hasil perhitungan VIKOR dapat dilihat pada halaman Hasil Rekomendasi.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="mt-4 text-center">
                    <a href="index.php?controller=Vikor&action=index" class="btn btn-light">
                      <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                    <a href="index.php?controller=Vikor&action=hitungRekomendasi" class="btn btn-gradient-primary">
                      <i class="mdi mdi-calculator"></i> Hitung Rekomendasi
                    </a>
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
  
  <script>
    $(document).ready(function() {
      $('#tabelMatriksKeputusan').DataTable({
        "scrollX": true,
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