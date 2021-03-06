<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('diklat')">kembali</a>
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
                        <th>Tahun</th>
                        <th>Nama Diklat</th>
                        <th>Jenis Diklat</th>
                        <th>Jam Diklat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <?php
                if (!empty($data_diklat)) {
                    foreach ($data_diklat as $diklat) {
                        echo "<tr>";
                        echo "<td>" . $diklat->tahun_diklat . "</td>";
                        echo "<td>" . $diklat->nama_diklat . "</td>";
                        echo "<td>" . $diklat->nama_jenis . "</td>";
                        echo "<td>" . $diklat->jam_diklat . "</td>";
                        echo "<td>"
                        . "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"diklat/select/" . $diklat->nip . "/" . $diklat->id_diklat . "/\")'>edit</i></span>"
                        . "&nbsp;&nbsp;"
                        . "<span href='#' class='btn btn-danger btn-xs' onclick='ConfirmDelete(\"" . $diklat->id_diklat . "\")'>hapus</i></span>"
                        . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        <strong>&nbsp;</strong>
        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="#" onclick="BukaPage('diklat/select/<?= $this->uri->segment(3); ?>')">tambah</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable();
    });


    function ConfirmDelete(id) //PEGAWAI_TAMPIL
    {
        var x = confirm("Hapus data SLKS?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('diklat/delete'); ?>',
                type: 'POST',
                data: {id: id},
                success: function(result) {
                    BukaPage('diklat/view/<?= $this->uri->segment(3); ?>')
                }
            });
        }
    }
</script>