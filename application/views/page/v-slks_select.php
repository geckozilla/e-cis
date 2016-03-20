<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('slks/view/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        if (!empty($data)) {
            $slks = $data;
            $nip = $slks->nip;
            $masa_kerja = $slks->masa_kerja;
            $no_sk = $slks->no_sk;
            $tgl_sk = $slks->tgl_sk;
        } else {
            $nip = $this->uri->segment(3);
            $masa_kerja = '';
            $no_sk = '';
            $tgl_sk = '';
        }

        $list_jenis = array(
            '10' => '10 Tahun',
            '20' => '20 Tahun',
            '30' => '30 Tahun',
        );
        ?>

        <form id="formku" role="form" action="#" method="post" autocomplete="off" >
            <div class="row">
                <div class="col-lg-6 form-horizontal">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">NIP :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="nip" name="nip" value="<?= $nip; ?>" readonly="">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Masa Kerja :</label>
                        <div class="col-sm-7">
                            <?= form_dropdown('masa_kerja', $list_jenis, $masa_kerja, 'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Nomor SK :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="kuantitas" name="no_sk" value="<?= $no_sk; ?>">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Tanggal :</label>
                        <div class="col-sm-7">
                            <input type='text' class="form-control" id="tgl_sk" class="form-control" name="tgl_sk" value="<?= $tgl_sk; ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="hidden" name="mode" value="<?= $mode; ?>"/>
                    <input type="hidden" name="id_slks" value="<?= @$slks->id_slks; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>/>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" title="simpan" id="simpan"><i class="fa fa-save"></i></button>
                        <button class="btn btn-primary" id="reset">reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#tgl_sk").mask("9999-99-99", {placeholder: "_"});
    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'slks/simpan', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                //$(".isi").load("<?= base_url('slks/select/' . $this->uri->segment(3)); ?>/" + responseData);
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $(".isi").load("<?= base_url('slks/select/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>");
    })
</script>