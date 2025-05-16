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
                    <i class="mdi mdi-calculator"></i>
                  </span> Pembobotan Kriteria dengan Metode AHP
                </h3>
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                      <span></span>Analytical Hierarchy Process (AHP)
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

          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Daftar Kriteria</h4>
                  <p class="card-description">Kriteria yang digunakan dalam perhitungan AHP</p>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama Kriteria</th>
                          <th>Jenis</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kriteria as $k): ?>
                        <tr>
                          <td><?= $k['kode'] ?></td>
                          <td><?= $k['nama'] ?></td>
                          <td><label class="badge badge-<?= $k['jenis'] == 'benefit' ? 'success' : 'danger' ?>"><?= ucfirst($k['jenis']) ?></label></td>
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
                  <h4 class="card-title">Bobot Kriteria (AHP)</h4>
                  <p class="card-description">Hasil pembobotan kriteria menggunakan metode AHP</p>
                  
                  <?php if (count($bobotKriteria) > 0): ?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Kriteria</th>
                          <th>Bobot</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($bobotKriteria as $b): ?>
                        <tr>
                          <td><?= $b['kode_kriteria'] ?></td>
                          <td><?= $b['nama_kriteria'] ?></td>
                          <td><?= number_format($b['bobot'], 5) ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <?php else: ?>
                  <div class="alert alert-info">
                    Belum ada bobot kriteria yang dihitung. Silakan lakukan perhitungan AHP terlebih dahulu.
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Manajemen Perhitungan AHP</h4>
                  <p class="card-description">Menu untuk melakukan perhitungan AHP</p>
                  
                  <div class="d-flex justify-content-start mb-4">
                    <?php if ($isBohotAHPExist): ?>
                    <div class="alert alert-success me-3">
                      <i class="mdi mdi-check-circle"></i> Bobot AHP sudah tersedia di database. 
                    </div>
                    
                    <a href="index.php?controller=AHP&action=gunaBobotExisting" class="btn btn-gradient-success me-2">
                      <i class="mdi mdi-check-all"></i> Gunakan Bobot Yang Ada
                    </a>
                    
                    <a href="index.php?controller=AHP&action=rekonstruksiMatriks" class="btn btn-gradient-warning me-2">
                      <i class="mdi mdi-restore"></i> Rekonstruksi Matriks dari Bobot
                    </a>
                    <?php else: ?>
                    <a href="index.php?controller=AHP&action=matriksPerbandingan" class="btn btn-gradient-primary me-2">
                      <i class="mdi mdi-matrix"></i> Matriks Perbandingan
                    </a>
                    
                    <?php if ($isMatriksComplete): ?>
                    <a href="index.php?controller=AHP&action=hitungBobot" class="btn btn-gradient-success me-2">
                      <i class="mdi mdi-calculator"></i> Hitung Bobot
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($hasilPerhitungan)): ?>
                    <a href="index.php?controller=AHP&action=hasilPerhitungan" class="btn btn-gradient-info me-2">
                      <i class="mdi mdi-chart-bar"></i> Detail Hasil Perhitungan
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?controller=AHP&action=resetMatriks" class="btn btn-gradient-danger me-2" onclick="return confirm('Apakah Anda yakin ingin mereset matriks perbandingan?')">
                      <i class="mdi mdi-refresh"></i> Reset Matriks
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tentang Metode AHP</h4>
                  <p class="card-description">Analytical Hierarchy Process (AHP)</p>
                  
                  <p>AHP (Analytical Hierarchy Process) adalah metode untuk memecahkan suatu situasi yang kompleks tidak terstruktur ke dalam beberapa komponen dalam susunan hirarki, dengan memberi nilai subjektif tentang pentingnya setiap variabel secara relatif, dan menetapkan variabel mana yang memiliki prioritas paling tinggi.</p>
                  
                  <p><strong>Langkah-langkah AHP:</strong></p>
                  <ol>
                    <li>Mendefinisikan masalah dan menentukan kriteria</li>
                    <li>Membuat struktur hierarki dari kriteria</li>
                    <li>Membuat matriks perbandingan berpasangan</li>
                    <li>Menormalkan data dengan membagi nilai setiap elemen pada matriks dengan nilai total setiap kolom</li>
                    <li>Menghitung eigen vector untuk mendapatkan bobot prioritas</li>
                    <li>Menghitung konsistensi logis untuk memastikan bahwa penilaian konsisten (CR < 0.1)</li>
                  </ol>
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