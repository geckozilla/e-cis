<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('diklat/view/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        if (!empty($data)) {
            $diklat = $data;
            $nip = $diklat->nip;
            $nama_diklat = $diklat->nama_diklat;
            $jenis_diklat = $diklat->jenis_diklat;
            $tahun_diklat = $diklat->tahun_diklat;
            $jam_diklat = $diklat->jam_diklat;
            $keterangan = $diklat->keterangan;
        } else {
            $nip = $this->uri->segment(3);
            $nama_diklat = '';
            $jenis_diklat = '';
            $tahun_diklat = '';
            $jam_diklat = '';
            $keterangan = '';
        }

        $list_jenis = array();
        foreach ($data_jenis as $j) {
            $list_jenis[$j->id_jenis] = $j->nama_jenis;
        }
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
                        <label class="control-label col-sm-5">Jenis :</label>
                        <div class="col-sm-7">
                            <?= form_dropdown('jenis_diklat', $list_jenis, $jenis_diklat, 'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Tahun :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="kuantitas" name="tahun_diklat" value="<?= $tahun_diklat; ?>" type="number" maxlength="4" max="<?= date('Y'); ?>">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Nama Diklat :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="kuantitas" name="nama_diklat" value="<?= $nama_diklat; ?>">
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Jam Pelajaran :</label>
                        <div class="col-sm-7">
                            <input class="form-control" class="form-control" name="jam_diklat" value="<?= $jam_diklat; ?>" />
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Keterangan :</label>
                        <div class="col-sm-7">
                            <input class="form-control" class="form-control" name="keterangan" value="<?= $keterangan; ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="hidden" name="mode" value="<?= $mode; ?>"/>
                    <input type="hidden" name="id_diklat" value="<?= @$diklat->id_diklat; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>/>
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
    $("#date_awal").mask("9999-99-99", {placeholder: "_"});
    $("#date_akhir").mask("9999-99-99", {placeholder: "_"});
    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'diklat/simpan', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                $(".isi").load("<?= base_url('diklat/view/' . $this->uri->segment(3)); ?>/" + responseData);
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $(".isi").load("<?= base_url('diklat/select/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>");
    })
</script>