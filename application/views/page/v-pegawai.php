<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('pegawai/select')">tambah</a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped table-hover" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Golongan</th>
                    <th>Bagian</th>
                    <th>Pendidikan</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
<script>
    function ConfirmDelete(nip) //PEGAWAI_TAMPIL
    {
        var x = confirm("Pegawai dengan NIP " + nip + " akan dihapus?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('pegawai/delete'); ?>',
                type: 'POST',
                data: {nip: nip},
                success: function(result) {
                    BukaPage('pegawai/view')
                }
            });
        }
    }
    $(document).ready(function() {

        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $('#mytable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo site_url('pegawai/view_ajax'); ?>",
            "columns": [
                {
                    "data": null,
                    "class": "text-center",
                    "orderable": false
                },
                {"data": "nip"},
                {"data": "nama"},
                {"data": "gol"},
                {"data": "bag"},
                {"data": "pddk"},
                {
                    "class": "text-center",
                    "data": "nip"
                }
            ],
            "order": [[3, 'desc']],
            "rowCallback": function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);

                var temp = $('td:eq(1)', row).text();
                var string = '<a href="#" onclick="BukaPage(\'pegawai/select/' + temp + '\')">edit</a> | \n\
                <a href="#" onclick="ConfirmDelete(\'' + temp + '\')">delete</a>';
                $('td:eq(-1)', row).html(string);
            },
        });
    });
</script>