<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('cuti')">kembali</a>
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
                        <th>Jenis</th>
                        <th>Kuantitas</th>
                        <th>Keterangan</th>
                        <th>Created</th>
                        <th>Periode</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <?php
                $list_jenis = array(
                    '' => '-',
                    '1' => 'Sisa Tahun ' . ($tahun - 1),
                    '2' => 'Jatah Tahun ' . $tahun,
                    '4' => 'Cuti',
                    '5' => 'Ijin',
                );
                $total = 0;
                if (!empty($data_cuti)) {
                    foreach ($data_cuti as $cuti) {
                        echo "<tr>";
                        echo "<td>" . $list_jenis[$cuti->jenis] . "</td>";
                        echo "<td>" . $cuti->kuantitas . "</td>";
                        echo "<td>" . $cuti->keterangan . "</td>";
                        echo "<td>" . $cuti->created . "</td>";
                        echo "<td>" . $cuti->tahun . "</td>";
                        if ($cuti->jenis > 2) {
                            echo "<td>"
                            . "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"cuti/select/" . $cuti->nip . "/" . $cuti->id_cuti . "/\")'>edit</i></span>"
                            . "&nbsp;&nbsp;"
                            . "<span href='#' class='btn btn-danger btn-xs' onclick='ConfirmDelete(\"" . $cuti->id_cuti . "\")'>hapus</i></span>"
                            . "</td>";
                        } else {
                            echo "<td>"
                            //. "<span href='#' class='btn btn-info btn-xs' onclick='BukaPage(\"cuti/select/" . $cuti->nip . "/" . $cuti->id_cuti . "/\")'>edit</i></span>"
                            . "</td>";
                        }
                        echo "</tr>";
                        $total+=$cuti->kuantitas;
                    }
                }
                ?>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="panel-footer">
        <strong>Sisa Hak Cuti: <?= $total; ?></strong>
        <div class="pull-right">
            <?php if (!empty($data_cuti)) { ?>
                <a class="btn btn-success btn-xs" href="#" onclick="BukaPage('cuti/select/<?= $this->uri->segment(3); ?>/cuti')">+ cuti</a>
                <a class="btn btn-info btn-xs" href="#" onclick="BukaPage('cuti/select/<?= $this->uri->segment(3); ?>/ijin')">+ ijin</a>
            <?php } else { ?>
                <button type="button" class="btn btn-primary btn-xs" onclick="createCuti()">Buat data baru</button>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "order": [[3, "asc"]]
        });
    });

    function ConfirmDelete(id) //PEGAWAI_TAMPIL
    {
        var x = confirm("Hapus data cuti?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('cuti/delete'); ?>',
                type: 'POST',
                data: {id_cuti: id},
                success: function(result) {
                    BukaPage('cuti/view/<?= $this->uri->segment(3); ?>')
                }
            });
        }
    }


    function createCuti() {

        var x = confirm("Data yang sudah diinput tidak dapat diubah.\nApakah anda yakin sudah memiliki data cuti yang valid \nuntuk pegawai ini?");

        if (x) {
            var sisa_lalu = prompt("Silakan masukkan sisa cuti tahun lalu");
            if (sisa_lalu != null) {
                var jatah_ini = prompt("Jatah tahun ini");
                if (jatah_ini != null) {
                    var sisa_lalu = parseInt(sisa_lalu);
                    var jatah_ini = parseInt(jatah_ini);
                    CreateSisa(sisa_lalu);
                    CreateJatah(jatah_ini);
                }
            }
        }
    }
    function CreateSisa(x)
    {
        $.ajax({
            url: '<?php echo base_url('cuti/simpan'); ?>',
            type: 'POST',
            data: {kuantitas: x, jenis: 1, mode: 'tambah', nip: '<?= $this->uri->segment(3); ?>'},
            success: function(result) {
                BukaPage('cuti/view/<?= $this->uri->segment(3); ?>')
            }
        });
    }
    function CreateJatah(x)
    {
        $.ajax({
            url: '<?php echo base_url('cuti/simpan'); ?>',
            type: 'POST',
            data: {kuantitas: x, jenis: 2, mode: 'tambah', nip: '<?= $this->uri->segment(3); ?>'},
            success: function(result) {
                BukaPage('cuti/view/<?= $this->uri->segment(3); ?>')
            }
        });
    }
</script>