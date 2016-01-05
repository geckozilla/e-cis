<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
    </div>
    <div class="panel-body">
        Sehubungan dengan berakhirnya periode tahun <?= date('Y', strtotime('-1 year')); ?>, <b>Admin</b> diwajibkan input hak cuti pegawai untuk periode <?= date('Y'); ?> sebelum dapat mengakses modul <b>CUTI</b>.<br><br>

        <?php if ($this->ion_auth->in_group('admin')) { ?>
            <form id="formku" role="form" action="<?= base_url('cuti'); ?>" method="post" autocomplete="off" >
                <div class="row">
                    <div class="col-lg-6 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-6">Masukkan Jumlah Hak Cuti :<br>(setelah dikurangi cuti bersama)</label>
                            <div class="col-sm-3">  
                                <input type='number' class="form-control" id="date_awal" class="form-control" name="new_q" value="" min="1" max="20" />
                            </div>
                            <div class="col-sm-3">  
                                <button type="submit" class="btn btn-primary btn-sm" title="simpan" id="simpan">simpan</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <b>Silakan hubungi Admin!</b>
        <?php } ?>
    </div>
</div>
<script>
    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'cuti', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                if (responseData == 1) {
                    $.notify('Data telah dibuat', {
                        className: 'success',
                    });
                    $(".isi").load("<?= base_url('cuti'); ?>");
                } else {
                    $.notify('Data gagal dibuat, hubungi Administrator.', {
                        className: 'error',
                    });
                }

            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
</script>
<?php
die();
?>