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
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary">Data Subkriteria</h4>
                <a href="index.php?controller=Subkriteria&action=tambah" class="btn btn-success btn-sm">+ Tambah Subkriteria</a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Kriteria</th>
                      <th>Nama Subkriteria</th>
                      <th>Nilai</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($data)): ?>
                      <?php
                        $grouped = [];
                        foreach ($data as $row) {
                          $grouped[$row['nama_kriteria']][] = $row;
                        }
                        $no = 1;
                        foreach ($grouped as $nama_kriteria => $sublist):
                      ?>
                        <tr class="table-primary">
                          <td colspan="6"><strong><?= htmlspecialchars($nama_kriteria) ?></strong></td>
                        </tr>
                        <?php foreach ($sublist as $row): ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_kriteria']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['nilai']) ?></td>
                            <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            <td>
                              <a href="index.php?controller=Subkriteria&action=edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <a href="index.php?controller=Subkriteria&action=hapus&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="text-center">Belum ada data subkriteria.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
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
