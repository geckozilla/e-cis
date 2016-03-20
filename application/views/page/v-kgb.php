<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kgb/setting')"><i class="fa fa-gear "> Pengaturan KGB </i></a>
        </div>
    </div>
    <div class="panel-body">

        <table class="table table-bordered table-striped table-hover" id="mytable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">NIP</th>
                    <th width="20%">Nama</th>
                    <th width="10%">Golongan</th>
                    <th>Next KGB</th>
                    <th>MKG</th>
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
            "ajax": "<?php echo site_url('kgb/listing_ajax'); ?>",
            "columns": [
                {
                    "data": null,
                    "class": "text-center",
                    "orderable": false
                },
                {"data": "nip"},
                {"data": "nama"},
                {"data": "gol"},
                {"data": "kgb"},
                {"data": "mkg"},
                {
                    "class": "text-center",
                    "data": "last"
                }
            ],
            "order": [[4, 'asc']],
            "rowCallback": function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);

                var temp = $('td:eq(1)', row).text();
                var next_kgb = new Date($('td:eq(4)', row).text()).getTime();
                var last_kgb = new Date($('td:eq(6)', row).text()).getTime();
                var string = '<a href="#" onclick="BukaPage(\'kgb/view/' + temp + '\')">view</a>';
                if (last_kgb < next_kgb) {
                    string = string + ' | <a href="#" onclick="BukaPage(\'kgb/select/' + temp + '\')">buat</a>';
                }
                $('td:eq(-1)', row).html(string);
            },
        });
    });
</script>