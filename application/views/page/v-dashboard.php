<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?> panel-transparent">
    <div class="panel-heading">
        <b><?= $header; ?></b>
    </div>
    <div class="panel-body">

        <div class="col-lg-12 col-md-12 placeholder">
            <div class="alert alert-info alert-dismissable text-center">
                <h4>Modul <a href="#" onclick="BukaPage('diklat')" style="color:red" >Diklat</a> telah berhasil ditambahkan. Silakan lakukan uji coba serta lengkapi datanya.</h4>
            </div>

        </div>
        <?php
        if (!empty($alert_kgb)) {
            ?>
            <div class="row placeholders">
                <div class="col-lg-12 col-md-12 placeholder">
                    <?php
                    foreach ($alert_kgb as $kgb) {
                        if ($kgb->last_date_kgb < $kgb->next_date_kgb) {
                            ?>
                            <div class="placeholder col-lg-3 col-md-6">
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" type="button" class="close">×</button>
                                    <?= "<u><b>" . $kgb->nama . "</b></u> akan KGB kurang dari " . terbilang($kgb->sisa_bln_kgb) . " bulan lagi. Buat <a onclick='BukaPage(\"kgb/select/" . $kgb->nip . "\")' class='alert-link'>pemberitahuan</a>!"; ?> .
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row placeholders">
            <div class="col-lg-8 col-md-12 placeholder">   
                <div class="col-lg-6 col-md-6 placeholder">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $pegawai_aktif; ?></div>
                                    <div>Pegawai Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 placeholder">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-3">
                                    <i class="fa fa-male fa-5x"></i>
                                </div>
                                <div class="col-lg-9 text-right">
                                    <div class="huge"><?= $pegawai_pria; ?></div>
                                    <div>Pria</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 placeholder">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-3">
                                    <i class="fa fa-female fa-5x"></i>
                                </div>
                                <div class="col-lg-9 text-right">
                                    <div class="huge"><?= $pegawai_wanita; ?></div>
                                    <div>Wanita</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 placeholder"> 
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <b>Persebaran Golongan Ruang</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="graph1" style="height: 200px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 placeholder"> 
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <b>Persebaran Pendidikan</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="graph2" style="height: 200px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 placeholder"> 
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <b>Persebaran Bagian</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="graph3" style="height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 placeholder"> 
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Log Timeline
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?php
                            if (!empty($log_timeline)) {
                                foreach ($log_timeline as $log) {
                                    ?>
                                    <a class="list-group-item" href="#" title="<?= $log->log_detail; ?>">
                                        <?= $log->log_user . ' ' . $log->log_event; ?>
                                        <span class="pull-right text-muted small"><em><?= $log->waktu; ?></em>
                                        </span>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>

        </div>
    </div>
    <div class="panel-footer">
        Page rendered in <strong>{elapsed_time}</strong> seconds.
        &nbsp;
    </div>
</div>
<script>
    // Use Morris.Bar
    Morris.Bar({
        element: 'graph1',
        data:
<?php
$coma = '';
$cetak = 1;
echo '[';
if (!empty($persebaran_golongan)) {
    foreach ($persebaran_golongan as $golongan) {
        $cetak = $golongan->jum_gol > 0 ? $cetak = $cetak + 1 : $cetak;
        if ($cetak > 0) {
            $jumlah = $golongan->jum_gol > 0 ? $golongan->jum_gol : 0;
            echo $coma . '{x:"' . $golongan->golongan . '",y:' . $jumlah . '}';
            $coma = ",";
        }
    }
}
echo ']';
?>,
        hideHover: true,
        xkey: 'x',
        xLabelAngle: 60,
        ykeys: ['y'],
        labels: ['Jumlah'],
        barColors: function(row, series, type) {
            if (type === 'bar') {
                var color = (Math.ceil(170 * row.y / this.ymax) + 85);
                return 'rgb(0,0,' + color + ')';
            }
            else {
                return '#000';
            }
        }
    });

    Morris.Bar({
        element: 'graph2',
        data:
<?php
$coma = '';
$cetak = 1;
echo '[';
if (!empty($persebaran_pendidikan)) {
    foreach ($persebaran_pendidikan as $pendidikan) {
        $jumlah = $pendidikan->jum_pendidikan > 0 ? $pendidikan->jum_pendidikan : 0;
        echo $coma . '{x:"' . $pendidikan->nama_tkt_pendidikan . '",y:' . $jumlah . '}';
        $coma = ",";
    }
}
echo ']';
?>,
        hideHover: true,
        xkey: 'x',
        xLabelAngle: 60,
        ykeys: ['y'],
        labels: ['Jumlah'],
        barColors: function(row, series, type) {
            if (type === 'bar') {
                var color = (Math.ceil(170 * row.y / this.ymax) + 85);
                return 'rgb(' + color + ',0,0)';
            }
            else {
                return '#000';
            }
        }
    });


    Morris.Bar({
        element: 'graph3',
        data:
<?php
$coma = '';
$cetak = 1;
echo '[';
if (!empty($persebaran_bagian)) {
    foreach ($persebaran_bagian as $bagian) {
        $jumlah = $bagian->jum_bag > 0 ? $bagian->jum_bag : 0;
        echo $coma . '{x:"' . $bagian->alias_bag . '",y:' . $jumlah . '}';
        $coma = ",";
    }
}
echo ']';
?>,
        hideHover: true,
        xkey: 'x',
        xLabelAngle: 60,
        ykeys: ['y'],
        labels: ['Jumlah'],
        barColors: function(row, series, type) {
            if (type === 'bar') {
                var color = (Math.ceil(170 * row.y / this.ymax) + 85);
                return 'rgb(0,' + color + ',0)';
            }
            else {
                return '#000';
            }
        }
    });
</script>
