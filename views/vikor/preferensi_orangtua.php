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
                  <h4 class="card-title">Preferensi Kriteria Orang Tua</h4>
                  <p class="card-description">
                    Silakan tentukan preferensi Anda terhadap masing-masing kriteria
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
                  
                  <!-- Form Preferensi -->
                  <form class="forms-sample" method="POST" action="index.php?controller=Vikor&action=simpanPreferensi">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Jenis</th>
                            <th>Nilai Preferensi (1-5)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($kriteria as $k): ?>
                            <tr>
                              <td><?= $k['kode']; ?></td>
                              <td><?= $k['nama']; ?></td>
                              <td>
                                <span class="badge badge-<?= $k['jenis'] == 'benefit' ? 'success' : 'danger'; ?>">
                                  <?= $k['jenis']; ?>
                                </span>
                              </td>
                              <td style="width: 300px;">
                                <input type="hidden" name="kriteria_id[]" value="<?= $k['id']; ?>">
                                <?php
                                  $nilai_preferensi = 5; // Default value
                                  foreach ($preferensiOrangTua as $pref) {
                                    if ($pref['kriteria_id'] == $k['id']) {
                                      $nilai_preferensi = $pref['nilai_preferensi'];
                                      break;
                                    }
                                  }
                                ?>
                                <div class="form-group">
                                  <div class="d-flex align-items-center">
                                    <input type="range" class="form-control-range w-75" id="nilai_preferensi_<?= $k['id']; ?>" name="nilai_preferensi[]" min="1" max="5" step="1" value="<?= $nilai_preferensi; ?>" oninput="updatePreferensiValue(this)">
                                    <span class="badge badge-primary ml-3 preferensi-value" id="preferensi_value_<?= $k['id']; ?>"><?= $nilai_preferensi; ?></span>
                                  </div>
                                  <div class="d-flex justify-content-between">
                                    <small>Tidak Penting</small>
                                    <small>Sangat Penting</small>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    
                    <div class="mt-4">
                      <button type="submit" class="btn btn-gradient-primary mr-2">Simpan Preferensi</button>
                      <a href="index.php?controller=Vikor&action=index" class="btn btn-light">Batal</a>
                    </div>
                  </form>
                  
                  <!-- Penjelasan Preferensi -->
                  <div class="row mt-4">
                    <div class="col-12">
                      <div class="card bg-gradient-light">
                        <div class="card-body">
                          <h5 class="card-title">Keterangan Nilai Preferensi</h5>
                          <div class="row">
                            <div class="col-md-6">
                              <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-2">
                                  <span class="badge badge-primary mr-2">1</span>
                                  <span>Tidak Penting - Kriteria ini tidak menjadi pertimbangan utama</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                  <span class="badge badge-primary mr-2">2</span>
                                  <span>Kurang Penting - Kriteria ini dipertimbangkan namun dengan prioritas rendah</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                  <span class="badge badge-primary mr-2">3</span>
                                  <span>Cukup Penting - Kriteria ini memiliki prioritas menengah</span>
                                </li>
                              </ul>
                            </div>
                            <div class="col-md-6">
                              <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-2">
                                  <span class="badge badge-primary mr-2">4</span>
                                  <span>Penting - Kriteria ini memiliki prioritas tinggi</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                  <span class="badge badge-primary mr-2">5</span>
                                  <span>Sangat Penting - Kriteria ini menjadi pertimbangan utama</span>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="mt-3">
                            <p>Nilai preferensi ini akan digunakan untuk menyesuaikan bobot kriteria dalam perhitungan VIKOR. Kriteria dengan nilai preferensi lebih tinggi akan memiliki pengaruh lebih besar dalam perhitungan rekomendasi.</p>
                            <p class="mb-0">Sistem ini menggabungkan bobot kriteria dari metode AHP dengan preferensi orang tua untuk menghasilkan rekomendasi yang lebih sesuai dengan kebutuhan dan keinginan Anda.</p>
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
  </div>
  <?php include 'template/script.php'; ?>
  
  <script>
    function updatePreferensiValue(input) {
      const id = input.id.replace('nilai_preferensi_', '');
      document.getElementById('preferensi_value_' + id).innerText = input.value;
    }
  </script>
</body>

</html>