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
                    <h4 class="card-title">Detail Rekomendasi: <?= $detailRekomendasi['nama_tk']; ?></h4>
                    <div>
                      <a href="index.php?controller=Vikor&action=hasilRekomendasi" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                      </a>
                    </div>
                  </div>
                  
                  <!-- Informasi Sekolah -->
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Informasi TK</h5>
                          <div class="table-responsive">
                            <table class="table">
                              <tr>
                                <th style="width: 30%">Nama TK</th>
                                <td><?= $detailRekomendasi['nama_tk']; ?></td>
                              </tr>
                              <tr>
                                <th>Alamat</th>
                                <td><?= $detailRekomendasi['alamat']; ?></td>
                              </tr>
                              <tr>
                                <th>Deskripsi</th>
                                <td><?= $detailRekomendasi['deskripsi'] ?? 'Tidak ada deskripsi'; ?></td>
                              </tr>
                              <tr>
                                <th>Kontak</th>
                                <td><?= $detailRekomendasi['kontak'] ?? 'Tidak ada kontak'; ?></td>
                              </tr>
                              <tr>
                                <th>Email</th>
                                <td><?= $detailRekomendasi['email'] ?? 'Tidak ada email'; ?></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Hasil Perhitungan VIKOR</h5>
                          <div class="table-responsive">
                            <table class="table">
                              <tr>
                                <th style="width: 30%">Peringkat</th>
                                <td><span class="badge badge-success"><?= $detailRekomendasi['peringkat']; ?></span></td>
                              </tr>
                              <tr>
                                <th>Nilai S</th>
                                <td><?= number_format($detailRekomendasi['nilai_s'], 4); ?></td>
                              </tr>
                              <tr>
                                <th>Nilai R</th>
                                <td><?= number_format($detailRekomendasi['nilai_r'], 4); ?></td>
                              </tr>
                              <tr>
                                <th>Nilai Q</th>
                                <td><?= number_format($detailRekomendasi['nilai_q'], 4); ?></td>
                              </tr>
                              <tr>
                                <th>Tanggal Perhitungan</th>
                                <td><?= date('d-m-Y H:i:s', strtotime($detailRekomendasi['tanggal_rekomendasi'])); ?></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Foto Sekolah -->
                  <?php if (!empty($detailRekomendasi['foto'])): ?>
                  <div class="row mb-4">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Foto TK</h5>
                          <div class="text-center">
                            <img src="uploads/<?= $detailRekomendasi['foto']; ?>" alt="<?= $detailRekomendasi['nama_tk']; ?>" class="img-fluid" style="max-height: 300px;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  
                  <!-- Lokasi Peta -->
                  <?php if (!empty($detailRekomendasi['latitude']) && !empty($detailRekomendasi['longitude'])): ?>
                  <div class="row mb-4">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Lokasi TK</h5>
                          <div id="mapTK" style="height: 300px;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  
                  <!-- Nilai Kriteria -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Nilai Kriteria</h5>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Kode</th>
                                  <th>Kriteria</th>
                                  <th>Nilai</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach($detailNilai as $nilai): ?>
                                <tr>
                                  <td><?= $nilai['kode_kriteria']; ?></td>
                                  <td><?= $nilai['nama_kriteria']; ?></td>
                                  <td><?= $nilai['nilai']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
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
  
  <?php if (!empty($detailRekomendasi['latitude']) && !empty($detailRekomendasi['longitude'])): ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
  <script>
    function initMap() {
      const sekolahLocation = {
        lat: <?= $detailRekomendasi['latitude']; ?>, 
        lng: <?= $detailRekomendasi['longitude']; ?>
      };
      
      const map = new google.maps.Map(document.getElementById("mapTK"), {
        zoom: 15,
        center: sekolahLocation,
      });
      
      const marker = new google.maps.Marker({
        position: sekolahLocation,
        map: map,
        title: "<?= $detailRekomendasi['nama_tk']; ?>"
      });
      
      const infowindow = new google.maps.InfoWindow({
        content: "<strong><?= $detailRekomendasi['nama_tk']; ?></strong><br><?= $detailRekomendasi['alamat']; ?>"
      });
      
      marker.addListener("click", () => {
        infowindow.open(map, marker);
      });
      
      infowindow.open(map, marker);
    }
  </script>
  <?php endif; ?>
</body>

</html>