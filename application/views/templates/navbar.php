<!-- Navbar -->
<?php
$role = $this->session->userdata('role');
$is_guru = in_array($role, array('guru', 'pengajar'), TRUE);
$is_anak = ($role === 'anak');
$dashboard_link = $is_anak ? site_url('anak') : ($is_guru ? site_url('guru') : site_url('admin'));
$secondary_link = $is_anak ? site_url('auth/logout') : ($is_guru ? site_url('guru/anak') : site_url('admin/kontak'));
$secondary_icon = $is_anak ? 'fas fa-sign-out-alt' : ($is_guru ? 'fas fa-child' : 'far fa-address-card');
$secondary_label = $is_anak ? 'Logout' : ($is_guru ? 'Data Anak' : 'Kontak');
$secondary_title = $is_anak ? 'Keluar dari sistem' : ($is_guru ? 'Lihat data anak' : 'Kontak Pengembang');
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="main-navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo $dashboard_link; ?>" class="nav-link">Dashboard</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Contact Link (Text like Dashboard) -->
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo $secondary_link; ?>" class="nav-link" title="<?php echo $secondary_title; ?>">
                <i class="<?php echo $secondary_icon; ?> mr-1"></i> <?php echo $secondary_label; ?>
            </a>
        </li>

        <!-- Dark/Light Mode Toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="theme-toggle" title="Ganti Tema">
                <i class="fas fa-moon" id="theme-icon"></i>
            </a>
        </li>

        <!-- Fullscreen Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- Control Sidebar Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"
                title="Pengaturan">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Theme Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        if (!themeToggle || !themeIcon) {
            return;
        }

        // Deteksi preferensi OS Theme
        const osThemeQuery = window.matchMedia('(prefers-color-scheme: dark)');

        function applyTheme(isDark) {
            if (isDark) {
                body.classList.add('dark-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                body.classList.remove('dark-mode');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // Initial Check
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            applyTheme(savedTheme === 'dark');
        } else {
            // Berpatokan pada preferensi sistem jika belum pernah diset secara manual
            applyTheme(osThemeQuery.matches);
        }

        // Event listener jika user mengganti tema sistemnya secara live
        osThemeQuery.addEventListener('change', function (e) {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
            }
        });

        // Toggle theme manual on click
        themeToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isCurrentlyDark = body.classList.contains('dark-mode');

            if (isCurrentlyDark) {
                applyTheme(false);
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme(true);
                localStorage.setItem('theme', 'dark');
            }
        });
    });
</script>