<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('slks')">kembali</a>
        </div>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nomor SK</th>
                    <th>Tanggal SK</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <?php
            if (!empty($data_slks)) {
                foreach ($data_slks as $slks) {
                    echo "<tr>";
                    echo "<td>" . $slks->masa_kerja . " tahun</td>";
                    echo "<td>" . ($slks->no_sk == '' ? '-' : $slks->no_sk) . "</td>";
                    echo "<td>" . $slks->tgl_sk . "</td>";
                    echo "<td>"
                    . "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"slks/select/" . $slks->nip . "/" . $slks->id_slks . "/\")'>edit</i></span>"
                    . "&nbsp;&nbsp;"
                    . "<span href='#' class='btn btn-danger btn-xs' onclick='ConfirmDelete(\"" . $slks->id_slks . "\")'>hapus</i></span>"
                    . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="panel-footer">
        <strong>&nbsp;</strong>
        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="#" onclick="BukaPage('slks/select/<?= $this->uri->segment(3); ?>')">tambah</a>
        </div>
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
        var x = confirm("Hapus data SLKS?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('slks/delete'); ?>',
                type: 'POST',
                data: {id: id},
                success: function(result) {
                    BukaPage('slks/view/<?= $this->uri->segment(3); ?>')
                }
            });
        }
    }
</script>