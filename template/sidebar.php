<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=HomeAdmin&action=homeAdmin">
          <i class="mdi mdi-grid-large menu-icon"></i>
          <span class="menu-title">Dashboard Admin</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Sekolah&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">Data Sekolah</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Kriteria&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">Data Kriteria</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=SubKriteria&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">Data Sub Kriteria</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=BobotKriteria&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">Data Bobot</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=NilaiTK&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">Nilai TK</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=AHP&action=index">
          <i class="mdi mdi-database menu-icon"></i>
          <span class="menu-title">AHP</span>
        </a>
      </li>

    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'orangtua'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Orangtua&action=homeOrangtua">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Dashboard Orang Tua</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=PreferensiOrangtua&action=index">
          <i class="mdi mdi-school menu-icon"></i>
          <span class="menu-title">Rekomendas TK</span>
        </a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Vikor&action=index">
          <i class="mdi mdi-school menu-icon"></i>
          <span class="menu-title">Preferensi</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Hasil&action=index">
          <i class="mdi mdi-school menu-icon"></i>
          <span class="menu-title">Hasil</span>
        </a>
      </li>
    <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Login&action=login">
          <i class="mdi mdi-login menu-icon"></i>
          <span class="menu-title">Silakan Login</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>