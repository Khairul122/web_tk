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
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">Data Sekolah TK</h4>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Nama TK</th>
                      <th>Alamat</th>
                      <th>Deskripsi</th>
                      <th>Kontak</th>
                      <th>Email</th>
                      <th>Foto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($data)): $no = 1;
                      foreach ($data as $row): ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= htmlspecialchars($row['nama_tk']) ?></td>
                          <td><?= htmlspecialchars($row['alamat']) ?></td>
                          <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                          <td><?= htmlspecialchars($row['kontak']) ?></td>
                          <td><?= htmlspecialchars($row['email']) ?></td>
                          <td>
                            <?php if (!empty($row['foto'])): ?>
                              <img src="foto_sekolah/<?= htmlspecialchars($row['foto']) ?>" alt="Foto Sekolah" width="100" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                            <?php else: ?>
                              <span>Tidak ada foto</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach;
                    else: ?>
                      <tr>
                        <td colspan="7" class="text-center">Belum ada data sekolah TK.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                  <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center p-0">
                      <img id="modalImage" src="" alt="Popup Gambar" style="width: 100%; height: auto;" class="rounded shadow">
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
    function showImage(el) {
      const modalImg = document.getElementById("modalImage");
      modalImg.src = el.src;
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
