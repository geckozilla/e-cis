<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <img alt="" src="<?= base_url('bootstrap/img/login_logo.png'); ?>" class="body-logo">
        <a class="navbar-brand" href="<?= base_url(); ?>"> <?= lang('base_title'); ?></a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right"
        <li class="dropdown navbar-static-top">
            <span id="jam" style="color:#265a88 ;">Loading Date/Time. . .</span>
        </li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?= @$user->first_name . ' ' . @$user->last_name; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#" onclick="BukaPage('user/edit_user/<?= $this->ion_auth->user()->row()->id; ?>/?p=1')"><i class="fa fa-user fa-fw"></i> Ubah Data Diri</a></li>
                <li class="divider"></li>
                <li><a href="<?= base_url('user/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
        </li>
    </ul>

    <!-- /.navbar-sidebar -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php
                $isadmin = $this->ion_auth->in_group('admin');
                ?>
                <?php if (true) { ?>
                    <li><a onclick="BukaPage('dashboard')"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                <?php } if ($this->ion_auth->in_group('pegawai')) { ?>
                    <li><a onclick="BukaPage('pegawai')"><i class="fa fa-users fa-fw"></i> Pegawai</a></li>
                <?php } if ($this->ion_auth->in_group('kgb')) { ?>
                    <li><a onclick="BukaPage('kgb')"><i class="fa fa-eject fa-fw"></i> Kenaikan Gaji Berkala</a></li>
                <?php } if ($this->ion_auth->in_group('cuti')) { ?>
                    <li><a onclick="BukaPage('cuti')"><i class="fa fa-calendar fa-fw"></i> Cuti</a></li>
                <?php } if ($this->ion_auth->in_group('slks')) { ?>
                    <li><a onclick="BukaPage('slks')"><i class="fa fa-shirtsinbulk fa-fw"></i> Satya Lencana Karya Satya</a></li>
                <?php } if ($this->ion_auth->in_group('diklat')) { ?>
                    <li><a onclick="BukaPage('diklat')"><i class="fa fa-institution fa-fw"></i> Diklat</a></li>
                <?php } if ($this->ion_auth->in_group('kp')) { ?>
                    <li><a onclick="BukaPage('kp')"><i class="fa fa-angle-double-up fa-fw"></i> Kenaikan Pangkat</a></li>
                <?php } if ($this->ion_auth->in_group('jabatan')) { ?>
                    <li><a onclick="BukaPage('jabatan')"><i class="fa fa-hand-rock-o fa-fw"></i> Jabatan</a></li>
                <?php } if ($this->ion_auth->in_group('pendidikan')) { ?>
                    <li><a onclick="BukaPage('pendidikan')"><i class="fa fa-university fa-fw"></i> Pendidikan</a></li>
                <?php } if ($this->ion_auth->in_group('admin')) { ?>
                    <li><a onclick="BukaPage('report')"><i class="fa fa-file-pdf-o fa-fw"></i> Report</a></li>
                <?php } if ($isadmin) { ?>
                    <li><a onclick = "BukaPage('user')"><i class = "fa fa-gears fa-fw"></i> User</a></li>
                    <li><a onclick = "BukaPage('user/view_group')"><i class = "fa fa-gears fa-fw"></i> Group</a></li>
                    <?php } ?>
            </ul>
        </div>
    </div>
</nav>