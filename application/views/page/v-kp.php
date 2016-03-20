<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
    </div>
    <div class="panel-body">

        <table class="table table-bordered table-striped table-hover" id="mytable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">NIP</th>
                    <th width="20%">Nama</th>
                    <th width="10%">Golongan</th>
                    <th>TMT Golongan</th>
                    <th>Jenis KP</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
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
            "ajax": "<?php echo site_url('kp/listing_ajax'); ?>",
            "columns": [
                {
                    "data": null,
                    "class": "text-center",
                    "orderable": false
                },
                {"data": "nip"},
                {"data": "nama"},
                {
                    "data": "gol"
                },
                {
                    "class": "text-center",
                    "data": "tmt_gol"
                },
                {"data": "nama_kp"},
                {
                    "class": "text-center",
                    "data": "nip"
                }
            ],
            "order": [[4, 'desc']],
            "rowCallback": function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);

                var temp = $('td:eq(1)', row).text();
                var string = '<a href="#" onclick="BukaPage(\'kp/view/' + temp + '\')">view</a>';

                $('td:eq(-1)', row).html(string);
            },
        });
    });
</script>