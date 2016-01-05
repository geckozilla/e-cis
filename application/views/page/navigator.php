<!--div class="panel panel-default">
    <div class="panel-heading"-->
<?php
$nip = $this->uri->segment(3);
$aksi = $this->uri->segment(2);
$modul = $this->uri->segment(1);
if ($modul == 'pegawai') {
    $submodul = 'select';
} elseif ($modul == 'kgb') {
    $submodul = 'view';
} elseif ($modul == 'cuti') {
    $submodul = 'view';
} elseif ($modul == 'slks') {
    $submodul = 'view';
} elseif ($modul == 'diklat') {
    $submodul = 'view';
} else {
    $modul = 'pegawai';
    $submodul = 'select';
}
?>
<script>
    var nipnama = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= base_url('json/nip_nama'); ?>?q=y',
        remote: {
            url: '<?= base_url('json/nip_nama'); ?>?q=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#carinip').click(function(e) {
        $('#carinip').select();
    })
    $('#carinip').typeahead(null, {
        name: 'best-pictures',
        display: 'nip',
        source: nipnama,
        templates: {
            empty: [
                '<div class="empty-message">',
                'pegawai tidak ditemukan',
                '</div>'
            ].join('\n'),
            suggestion: function(data) {
                return '<p><strong>' + data.nip + '</strong> – ' + data.nama + '</p>';
            }
        }
    }).on('typeahead:selected', function(evt, item) {
        BukaPage('<?= $modul; ?>/<?= $submodul; ?>/' + $('#carinip').val());
    });


    $('#cari_nip').on('submit', function(e) {
        e.preventDefault();
        var nip = $('#carinip').val();
        $.ajax({
            url: '<?php echo base_url('pegawai/is_nip_exist'); ?>',
            type: 'POST',
            data: {nip: nip},
            success: function(result) {
                if (result == 1) {
                    BukaPage('<?= $modul; ?>/<?= $submodul; ?>/' + $('#carinip').val());
                } else {

                    $.notify('Pegawai tidak ditemukan', {
                        className: 'error',
                    });
                }
            }
        });
    })

    function isNipExist(nip) {
    }
</script>
<?php
$modul = $this->uri->segment(1);
?>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline pull-left" id="cari_nip">
            <div class="form-group">
                <input type="text" style="width:200px;" id="carinip" value="<?= $nip; ?>"class="form-control input-sm" placeholder="Cari . . .">
            </div>
        </form>

        <div class="btn-group btn-group-sm pull-right">
            <a type="button" class="btn btn-primary btn-default <?= $modul == 'pegawai' ? 'active' : ''; ?>" onclick="BukaPage('<?= $aksi == '' ? 'pegawai' : 'pegawai/select/' . $nip; ?>')" >Pegawai</a>
            <a type="button" class="btn btn-primary <?= $modul == 'kgb' ? 'active' : ''; ?>" onclick="BukaPage('<?= $aksi == '' ? 'kgb' : 'kgb/view/' . $nip; ?>')" >KGB</a>
            <a type="button" class="btn btn-primary <?= $modul == 'cuti' ? 'active' : ''; ?>" onclick="BukaPage('<?= $aksi == '' ? 'cuti' : 'cuti/view/' . $nip; ?>')" >Cuti</a>
            <a type="button" class="btn btn-primary <?= $modul == 'slks' ? 'active' : ''; ?>" onclick="BukaPage('<?= $aksi == '' ? 'slks' : 'slks/view/' . $nip; ?>')" >SLKS</a>
            <a type="button" class="btn btn-primary <?= $modul == 'diklat' ? 'active' : ''; ?>" onclick="BukaPage('<?= $aksi == '' ? 'diklat' : 'diklat/view/' . $nip; ?>')" >Diklat</a>
        </div>
    </div>
    <br>
    <br>
</div>
<!--/div>
</div-->