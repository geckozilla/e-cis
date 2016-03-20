<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
    </div>
    <div class="panel-body">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <td>
                        Daftar Pegawai
                    </td>
                    <td>
                        <a href="report/semua_pegawai/<?= safe_encode('gol_akhir'); ?>/<?= safe_encode('desc'); ?>" target="_BLANK" class="btn btn-xs btn-primary">cetak</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Daftar Pegawai berdasarkan nama
                    </td>
                    <td>
                        <a href="report/semua_pegawai/<?= safe_encode('nama'); ?>/<?= safe_encode('asc'); ?>" target="_BLANK" class="btn btn-xs btn-primary">cetak</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Daftar Pegawai berdasarkan bagian
                    </td>
                    <td>
                        <a href="report/semua_pegawai/<?= safe_encode('bagian'); ?>/<?= safe_encode('asc'); ?>" target="_BLANK" class="btn btn-xs btn-primary">cetak</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        &nbsp;
    </div>
</div>