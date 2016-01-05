<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('cuti')">kembali</a>
        </div>
    </div>
    <div class="panel-body">
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
                        echo "<td></td>";
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

    <div class="panel-footer">
        <strong>Sisa Hak Cuti: <?= $total; ?></strong>
        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="#" onclick="BukaPage('cuti/select/<?= $this->uri->segment(3); ?>/cuti')">+ cuti</a>
            <a class="btn btn-info btn-xs" href="#" onclick="BukaPage('cuti/select/<?= $this->uri->segment(3); ?>/ijin')">+ ijin</a>
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
</script>