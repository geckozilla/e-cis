<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kp/view/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        if (!empty($data)) {
            $kp = $data;
        }
        $golongan = array();
        foreach ($data_golongan as $a) {
            $golongan[$a->id_golongan] = $a->golongan;
        }
        
        $jenis_kp = array();
        foreach ($data_kp_jenis as $r) {
            $jenis_kp[$r->kode_jenis] = $r->nama_kp;
        }
        ?>

        <form id="formku" role="form" action="#" method="post" autocomplete="off" >
            <div class="row">
                <div class="col-lg-4 col-md-6 form-horizontal">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">NIP :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="nip" name="nip" value="<?= @$this->uri->segment(3); ?>" readonly="">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Gol Ruang :</label>
                        <div class="col-sm-7">
                            <?= form_dropdown('gol', $golongan, @$kp->gol, 'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Tanggal SK :</label>
                        <div class="col-sm-7">
                            <div class='input-group date'>    
                                <input type='text' class="form-control" id="tgl_sk" class="form-control" name="tgl_sk" value="<?= @$kp->tgl_sk; ?>" />
                                <span class="input-group-addon input-sm">
                                    <span class="glyphicon glyphicon-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Tanggal BKN :</label>
                        <div class="col-sm-7">
                            <div class='input-group date'>    
                                <input type='text' class="form-control" id="tgl_bkn" class="form-control" name="tgl_bkn" value="<?= @$kp->tgl_bkn; ?>" />
                                <span class="input-group-addon input-sm">
                                    <span class="glyphicon glyphicon-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 form-horizontal">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Jenis KP :</label>
                        <div class="col-sm-7">
                            <?= form_dropdown('jenis_kp', $jenis_kp, @$kp->jenis_kp, 'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">TMT Golongan :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="tmt_gol" name="tmt_gol" value="<?= @$kp->tmt_gol; ?>" >
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Nomor SK :</label>
                        <div class="col-sm-7">
                            <input class="form-control" style="color: red;" id="no_sk" name="no_sk">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Nomor BKN :</label>
                        <div class="col-sm-7">
                            <input class="form-control" style="color: red;" id="no_bkn" name="no_bkn">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="hidden" name="mode" value="<?= $mode; ?>"/>
                    <input type="hidden" name="id_kp" value="<?= @$kp->id_kp; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>/> 
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
    $("#tmt_gol").mask("9999-99-99", {placeholder: "_"});
    $("#tgl_sk").mask("9999-99-99", {placeholder: "_"});
    $("#tgl_bkn").mask("9999-99-99", {placeholder: "_"});

    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'kp/simpan', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                $(".isi").load("<?= base_url('kp/view/' . $this->uri->segment(3)); ?>/" + responseData);
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $(".isi").load("<?= base_url('kp/select/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>");
    })
</script>