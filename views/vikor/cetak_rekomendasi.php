<!DOCTYPE html>
<html>
<head>
  <title>Laporan Rekomendasi Taman Kanak-kanak</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      font-size: 12pt;
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    .header h2 {
      margin-bottom: 5px;
    }
    .header p {
      margin-top: 0;
      color: #666;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .info-box {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
    }
    .top-recommendation {
      background-color: #d4edda;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #c3e6cb;
    }
    .footer {
      margin-top: 50px;
      text-align: center;
      font-size: 10pt;
      color: #666;
    }
    @media print {
      body {
        margin: 0;
        padding: 15px;
      }
      .no-print {
        display: none;
      }
      .page-break {
        page-break-before: always;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>LAPORAN REKOMENDASI TAMAN KANAK-KANAK</h2>
    <p>Hasil Perhitungan Menggunakan Metode VIKOR</p>
    <p>Tanggal: <?= date('d-m-Y'); ?></p>
  </div>
  
  <?php if (count($hasilRekomendasi) > 0): ?>
  <div class="top-recommendation">
    <h3>Rekomendasi Terbaik</h3>
    <table>
      <tr>
        <th style="width: 30%">Nama TK</th>
        <td><?= $hasilRekomendasi[0]['nama_tk']; ?></td>
      </tr>
      <tr>
        <th>Alamat</th>
        <td><?= $hasilRekomendasi[0]['alamat']; ?></td>
      </tr>
      <tr>
        <th>Nilai Q (VIKOR Index)</th>
        <td><?= number_format($hasilRekomendasi[0]['nilai_q'], 4); ?></td>
      </tr>
      <tr>
        <th>Nilai S (Utility Measure)</th>
        <td><?= number_format($hasilRekomendasi[0]['nilai_s'], 4); ?></td>
      </tr>
      <tr>
        <th>Nilai R (Regret Measure)</th>
        <td><?= number_format($hasilRekomendasi[0]['nilai_r'], 4); ?></td>
      </tr>
      <?php if (!empty($hasilRekomendasi[0]['kontak'])): ?>
      <tr>
        <th>Kontak</th>
        <td><?= $hasilRekomendasi[0]['kontak']; ?></td>
      </tr>
      <?php endif; ?>
    </table>
  </div>
  
  <div class="info-box">
    <h3>Informasi Perhitungan</h3>
    <p>Perhitungan rekomendasi dilakukan dengan metode VIKOR (VIseKriterijumska Optimizacija I Kompromisno Resenje) yang dioptimasi dengan pembobotan menggunakan AHP (Analytical Hierarchy Process). Hasil rekomendasi ini memperhitungkan preferensi orang tua dan bobot kriteria yang telah ditentukan.</p>
    <p><strong>Parameter V (VIKOR):</strong> <?= isset($_SESSION['parameter_vikor_v']) ? $_SESSION['parameter_vikor_v'] : 0.5; ?></p>
    <p><strong>Tanggal Perhitungan:</strong> <?= date('d-m-Y H:i:s', strtotime($hasilRekomendasi[0]['tanggal_rekomendasi'])); ?></p>
  </div>
  
  <h3>Daftar Rekomendasi Taman Kanak-kanak</h3>
  <table>
    <thead>
      <tr>
        <th>Peringkat</th>
        <th>Nama TK</th>
        <th>Alamat</th>
        <th>Nilai Q</th>
        <th>Nilai S</th>
        <th>Nilai R</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($hasilRekomendasi as $hasil): ?>
      <tr>
        <td><?= $hasil['peringkat']; ?></td>
        <td><?= $hasil['nama_tk']; ?></td>
        <td><?= $hasil['alamat']; ?></td>
        <td><?= number_format($hasil['nilai_q'], 4); ?></td>
        <td><?= number_format($hasil['nilai_s'], 4); ?></td>
        <td><?= number_format($hasil['nilai_r'], 4); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <div class="info-box">
    <h3>Keterangan Metrik VIKOR</h3>
    <ul>
      <li><strong>Nilai S (Utility Measure)</strong> - Merepresentasikan nilai utility rata-rata. Nilai S yang lebih rendah menunjukkan alternatif yang lebih baik dari segi utility mayoritas.</li>
      <li><strong>Nilai R (Regret Measure)</strong> - Merepresentasikan nilai regret maksimum. Nilai R yang lebih rendah menunjukkan alternatif dengan regret individual minimum.</li>
      <li><strong>Nilai Q (VIKOR Index)</strong> - Merupakan indeks akhir VIKOR yang menggabungkan S dan R. Nilai Q yang lebih rendah menunjukkan alternatif yang lebih baik.</li>
    </ul>
  </div>
  
  <?php else: ?>
  <div class="info-box">
    <h3>Tidak Ada Hasil Rekomendasi</h3>
    <p>Belum ada data hasil perhitungan rekomendasi. Silakan lakukan perhitungan terlebih dahulu.</p>
  </div>
  <?php endif; ?>
  
  <div class="footer">
    <p>Laporan ini digenerate oleh Sistem Rekomendasi Pemilihan Taman Kanak-kanak</p>
    <p>© <?= date('Y'); ?> - Universitas Malikussaleh</p>
  </div>
  
  <div class="no-print" style="text-align: center; margin-top: 20px;">
    <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Cetak Laporan</button>
    <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Tutup</button>
  </div>
  
  <script>
    window.onload = function() {

    }
  </script>
</body>
</html>