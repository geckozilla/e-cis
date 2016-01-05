<?php
if ($this->uri->segment(2) == 'view') {
    ?>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered" border="1">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Kuantitas</th>
                    <th>Keterangan</th>
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
    <?php
} else {
    ?>

    <form id="formku" role="form" action="<?= base_url('x_cuti/view'); ?>" method="post" autocomplete="off" >
        <div class="row">
            <div class="col-lg-6 form-horizontal">
                <div class="form-group form-group-sm">
                    <label class="control-label col-sm-5">NIP :</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="nip" name="nip">
                        <button type="submit" class="btn btn-primary" title="simpan" id="simpan">lihat</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
}?>