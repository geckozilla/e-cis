<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kgb')">kembali</a>
        </div>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered">
            <thead>
                <tr>
                    <th>Tgl KGB</th>
                    <th>No SK</th>
                    <th>MKG</th>
                    <th>Gaji lama</th>
                    <th>Gaji Baru</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (!empty($data_pegawai)) {
                    foreach ($data_pegawai as $pegawai) {
                        echo "<tr>";
                        echo "<td>" . $pegawai->tgl_mulai_sk_baru . "</td>";
                        echo "<td>" . $pegawai->no_sk_baru . "</td>";
                        echo "<td>" . preg_replace('/^.{2}/', "$0 ", str_pad($pegawai->mkg_sk_baru, 4, '0', STR_PAD_LEFT)) . "</td>";
                        echo "<td>" . number_format($pegawai->gapok_lama, 0, ',', '.') . "</td>";
                        echo "<td>" . number_format($pegawai->gapok_baru, 0, ',', '.') . "</td>";
                        echo "<td>"
                        . "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"kgb/select/" . $pegawai->nip . "/" . $pegawai->id_kgb . "/\")'>edit</i></span>"
                        . "&nbsp;&nbsp;"
                        . "<a href='" . base_url("report/kgb/" . safe_encode($pegawai->id_kgb)) . "' target='_BLANK' class='btn btn-default btn-xs' >cetak</i></a>"
                        . "&nbsp;&nbsp;"
                        . "<span href='#' class='btn btn-danger btn-xs' onclick='ConfirmDelete(\"" . $pegawai->id_kgb . "\")'>hapus</i></span>"
                        . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "order": [[2, "desc"]]
        });
    });

    function ConfirmDelete(id) //PEGAWAI_TAMPIL
    {
        var x = confirm("Hapus KGB ini?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('kgb/delete'); ?>',
                type: 'POST',
                data: {id_kgb: id},
                success: function(result) {
                    BukaPage('kgb/view/<?= $this->uri->segment(3); ?>')
                }
            });
        }
    }
</script>