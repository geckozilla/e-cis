<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kp')">kembali</a>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $path = 'downloads/foto';
        $file = get_file_name($this->uri->segment(3));
        $filepath = base_url($path) . '/' . $file;

        $is_file_exist = read_file($filepath);
        ?>

        <div class="col-md-3 col-lg-2">
            <img src="<?= base_url($path) . '/' . ($is_file_exist ? str_replace(' ', '_', $file) . '?' . rand() : 'nofoto.jpg'); ?>" width="100%" class="img-rounded">
        </div>
        <div class="col-md-9 col-lg-10">
            <table id="datatables" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Golongan</th>
                        <th>TMT Gol</th>
                        <th>No SK</th>
                        <th>Tanggal SK</th>
                        <th>No BKN</th>
                        <th>Tanggal BKN</th>
                        <th>Jenis KP</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($data_pegawai)) {
                        foreach ($data_pegawai as $pegawai) {
                            echo "<tr>";
                            echo "<td>" . convert_golongan($pegawai->gol) . "</td>";
                            echo "<td>" . $pegawai->tmt_gol . "</td>";
                            echo "<td>" . $pegawai->no_sk . "</td>";
                            echo "<td>" . $pegawai->tgl_sk . "</td>";
                            echo "<td>" . $pegawai->no_bkn . "</td>";
                            echo "<td>" . $pegawai->tgl_bkn . "</td>";
                            echo "<td>" . $pegawai->nama_kp . "</td>";
                            echo "<td>"
                            . "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"kp/select/" . $pegawai->nip . "/" . $pegawai->id_kp . "/\")'>edit</i></span>"
                            . "&nbsp;&nbsp;"
                            . "<span href='#' class='btn btn-danger btn-xs' onclick='ConfirmDelete(\"" . $pegawai->id_kp . "\")'>hapus</i></span>"
                            . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>      

    <div class="panel-footer">
        <strong>&nbsp;</strong>
        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="#" onclick="BukaPage('kp/select/<?= $this->uri->segment(3); ?>')">tambah</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "order": [[2, "asc"]]
        });
    });

    function ConfirmDelete(id) //PEGAWAI_TAMPIL
    {
        var x = confirm("Hapus KP ini?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('kp/delete'); ?>',
                type: 'POST',
                data: {id_kp: id},
                success: function(result) {
                    BukaPage('kp/view/<?= $this->uri->segment(3); ?>')
                }
            });
        }
    }
</script>