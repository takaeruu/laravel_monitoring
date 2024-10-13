<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
            <div class="sidebar-header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="<?= url('images/' . $yogi->logo_website) ?>" alt="logo" style="max-width: 150%; height: auto; max-height: 100px;" />
        </div>
        <div class="toggler">
            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
    </div>
</div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <!-- Dashboard -->
                        <li class="sidebar-item {{ Request::is('home/dashboard') ? 'active' : '' }}">
                            <a href="{{ url('home/dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Kelas -->
                        <li class="sidebar-item {{ Request::is('home/kelas') ? 'active' : '' }}">
                            <a href="{{ url('home/kelas') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Kelas</span>
                            </a>
                        </li>

                        <?php
      if (session()->get('status') == 'admin' || session()->get('status') == 'admin_ruangan'){
        ?>
                        <li class="sidebar-item {{ Request::is('home/kelas_admin') ? 'active' : '' }}">
                            <a href="{{ url('home/kelas_admin') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Kelas Admin</span>
                            </a>
                        </li>
                        <?php 
      } else {

      }
?>

<?php
      if (session()->get('status') == 'admin'){
        ?>
                        <li class="sidebar-item {{ Request::is('home/kelas_akses') ? 'active' : '' }}">
                            <a href="{{ url('home/kelas_akses') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Daftar Kelas</span>
                            </a>
                        </li>
                        <?php 
      } else {

      }
?>

<?php
      if (session()->get('status') == 'admin' || session()->get('status') == 'admin_ruangan'){
        ?>
                        <li class="sidebar-item {{ Request::is('home/restore') ? 'active' : '' }}">
                            <a href="{{ url('home/restore') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Restore</span>
                            </a>
                        </li>
                        <?php 
      } else {

      }
?>

<?php
      if (session()->get('status') == 'admin'){
        ?>
                        <li class="sidebar-item {{ Request::is('home/setting') ? 'active' : '' }}">
                            <a href="{{ url('home/setting') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Restore Edit</span>
                            </a>
                        </li>

                        <?php 
      } else {

      }
?>


<?php
      if (session()->get('status') == 'admin'){
        ?>
                        <li class="sidebar-item {{ Request::is('home/setting') ? 'active' : '' }}">
                            <a href="{{ url('home/setting') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Setting</span>
                            </a>
                        </li>

                        <?php 
      } else {

      }
?>


                        
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
