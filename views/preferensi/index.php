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
                  <h4 class="card-title text-primary">Kuisioner Preferensi Orang Tua</h4>
                  
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
                    <div class="d-flex justify-content-between">
                      <p>Silahkan isi kuesioner preferensi orang tua dalam pemilihan TK berikut ini.</p>
                      <?php if ($sudah_isi): ?>
                        <a href="index.php?controller=PreferensiOrangtua&action=riwayatKuisioner" class="btn btn-info">
                          <i class="mdi mdi-history"></i> Lihat Riwayat Kuesioner
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <form method="POST" action="index.php?controller=PreferensiOrangtua&action=simpanKuisioner">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?? 0 ?>">

                    <div class="mb-4">
                      <h5 class="text-primary">1. Akreditas Sekolah</h5>
                      <div class="mb-3">
                        <label class="form-label">Apakah sekolah TK ini sudah memiliki akreditas resmi dari lembaga pendidikan yang diakui?</label>
                        <select name="preferensi[2]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah ibu merasa penting dalam pemilihan sekolah Tk disini?</label>
                        <select name="preferensi[2]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Ya</option>
                          <option value="1">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">2. Biaya SPP</h5>
                      <div class="mb-3">
                        <label class="form-label">Berapa besar biaya SPP bulanan disekolah ini?</label>
                        <select name="preferensi[6]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Rp 50.000</option>
                          <option value="4">Rp 100.000</option>
                          <option value="3">Rp 150.000</option>
                          <option value="2">Rp 200.000</option>
                          <option value="1">Rp 500.000</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah ibu kesusahan dalam memilih sekolah TK disini? (berkaitan dengan biaya sebagai salah satu pertimbangan)</label>
                        <select name="preferensi[6]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">Ya</option>
                          <option value="5">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">3. Jarak Lokasi</h5>
                      <div class="mb-3">
                        <label class="form-label">Berapa jarak tempuh dari ibu ke TK tersebut?</label>
                        <select name="preferensi[4]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">1 km</option>
                          <option value="4">2 km</option>
                          <option value="3">5 km</option>
                          <option value="2">7 km</option>
                          <option value="1">10 km</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah ibu merasa bingung/bimbang untuk memilih sekolah TK disini? (dapat dikaitkan dengan jarak sebagai salah satu pertimbangan)</label>
                        <select name="preferensi[4]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">Ya</option>
                          <option value="5">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">4. Fasilitas</h5>
                      <div class="mb-3">
                        <label class="form-label">Apakah fasilitas disekolah cukup memadai untuk mendukung kegiatan belajar?</label>
                        <select name="preferensi[7]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Bagaimana kondisi kebersihan dan keamanan fasilitas disekolah?</label>
                        <select name="preferensi[7]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">5. Atribut</h5>
                      <div class="mb-3">
                        <label class="form-label">Apakah wajib memakai atribut atau perlengkapan yang dimiliki anak saat bersekolah di TK ini?</label>
                        <select name="preferensi[8]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Ya</option>
                          <option value="1">Tidak</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah TK ini memiliki ruang kegiatan khusus, seperti ruang seni atau musik?</label>
                        <select name="preferensi[8]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Ya</option>
                          <option value="1">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">6. Jumlah Guru</h5>
                      <div class="mb-3">
                        <label class="form-label">Apakah wali kelas memiliki tugas dan tanggung jawab tertentu dalam mengawasi perkembangan setiap anak?</label>
                        <select name="preferensi[12]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Ya</option>
                          <option value="1">Tidak</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Bagaimana ibu menilai komunikasi antara guru dan orang tua?</label>
                        <select name="preferensi[12]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">7. Jumlah Murid Perkelas</h5>
                      <div class="mb-3">
                        <label class="form-label">Berapa jumlah siswa yang ada di setiap kelas di sekolah TK ini?</label>
                        <select name="preferensi[11]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">10 Siswa</option>
                          <option value="4">20 Siswa</option>
                          <option value="3">30 Siswa</option>
                          <option value="2">40 Siswa</option>
                          <option value="1">50 Siswa</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Bagaimana ibu menilai kenyamanan ruang kelas untuk anak-anak belajar dan berinteraksi?</label>
                        <select name="preferensi[11]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">8. Waktu Pembelajaran (Jam Operasional)</h5>
                      <div class="mb-3">
                        <label class="form-label">Berapa lama durasi jam belajar setiap harinya?</label>
                        <select name="preferensi[9]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 Jam</option>
                          <option value="2">2 Jam</option>
                          <option value="3">3 Jam</option>
                          <option value="4">4 Jam</option>
                          <option value="5">5 Jam</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah lingkungan belajar di sekolah sudah cukup mendukung untuk anak-anak?</label>
                        <select name="preferensi[9]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">9. Kualitas Pengajaran</h5>
                      <div class="mb-3">
                        <label class="form-label">Bagaimana ibu menilai kualitas pengajaran di sekolah TK ini?</label>
                        <select name="preferensi[5]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Apakah materi yang diajarkan sudah cukup mendukung perkembangan anak?</label>
                        <select name="preferensi[5]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-primary">10. Metode & Aktivitas Belajar</h5>
                      <div class="mb-3">
                        <label class="form-label">Apakah metode pengajaran di sekolah ini sesuai dengan harapan ibu?</label>
                        <select name="preferensi[10]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="1">1 - Sangat Kurang</option>
                          <option value="2">2 - Kurang</option>
                          <option value="3">3 - Cukup</option>
                          <option value="4">4 - Baik</option>
                          <option value="5">5 - Sangat Baik</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Adakah taman atau kebun kecil untuk pembelajaran alam dan eksplorasi anak?</label>
                        <select name="preferensi[10]" class="form-select" required>
                          <option value="">-- Pilih jawaban --</option>
                          <option value="5">Ya</option>
                          <option value="1">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Preferensi</button>
                  </form>

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