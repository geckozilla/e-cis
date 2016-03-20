<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kgb/view/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        if (!empty($data)) {
            $kgb = $data;
            $golongan = array();
            foreach ($data_golongan as $gol) {
                $golongan[$gol->id_golongan] = $gol->golongan;
            }
            ?>

            <form id="formku" role="form" action="#" method="post" autocomplete="off" >
                <div class="row">
                    <div class="col-lg-4 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">NIP :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="nip" name="nip" value="<?= @$kgb->nip; ?>" readonly="">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">Nama :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="nama" name="nama" value="<?= @$kgb->nama; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">Unit Kerja :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="unit_kerja" name="unit_kerja" value="<?= @$kgb->unit_kerja; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">Kepada :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="kepada" name="kepada" style = 'resize:none;height: 85px',><?= @$kgb->kepada; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">Dasar Hukum :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="dasar_hukum" name="dasar_hukum" value="<?= @$kgb->dasar_hukum; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4"">Jabatan Pejabat :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="jabatan_pejabat_baru" name="jabatan_pejabat_baru" style = 'resize:none;height: 70px',><?= @$kgb->jabatan_pejabat_baru; ?></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Tgl SK Lama :</label>
                            <div class="col-sm-7">
                                <div class='input-group date' id='datetimepicker_sk_lama'>    
                                    <input type='text' class="form-control" id="tgl_sk_lama" class="form-control" required="" name="tgl_sk_lama" value="<?= @$kgb->tgl_sk_lama; ?>" />
                                    <span class="input-group-addon input-sm">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Nomor SK Lama :</label>
                            <div class="col-sm-7">
                                <input class="form-control" required="" id="no_sk_lama" name="no_sk_lama" value="<?= @$kgb->no_sk_lama; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Tgl Mulai SK Lama :</label>
                            <div class="col-sm-7">
                                <div class='input-group date' id='datetimepicker_mulai_sk_lama'>    
                                    <input type='text' class="form-control" id="tgl_mulai_sk_lama" class="form-control" name="tgl_mulai_sk_lama" value="<?= @$kgb->tgl_mulai_sk_lama; ?>" />
                                    <span class="input-group-addon input-sm">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Gapok Lama :</label>
                            <div class="col-sm-7">
                                <div class='input-group date'>    
                                    <span class="input-group-addon input-sm">
                                        Rp.
                                    </span>                          
                                    <input class="form-control" id="gapok_lama" name="gapok_lama" value="<?= @$kgb->gapok_lama; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">MKG Lama :</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="mkg_sk_lama" name="mkg_sk_lama" value="<?= str_pad(@$kgb->mkg_sk_lama, 4, '0', STR_PAD_LEFT); ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Golru Lama :</label>
                            <div class="col-sm-7">
                                <?= form_dropdown('golru_lama', $golongan, @$kgb->golru_lama, 'class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Jabatan Pejabat Lama :</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="jabatan_pejabat_lama" name="jabatan_pejabat_lama" value="<?= @$kgb->jabatan_pejabat_lama; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Tgl SK Baru :</label>
                            <div class="col-sm-7">
                                <div class='input-group date' id='datetimepicker_sk_baru'>    
                                    <input type='text' class="form-control" id="tgl_sk_baru" class="form-control" name="tgl_sk_baru" value="<?= @$kgb->tgl_sk_baru; ?>" />
                                    <span class="input-group-addon input-sm">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Nomor SK Baru :</label>
                            <div class="col-sm-7">
                                <input class="form-control" style="color: red;" id="no_sk_baru" name="no_sk_baru" value="<?= $mode == 'edit' ? $kgb->no_sk_baru : ' Automatic'; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Tgl Mulai SK Baru :</label>
                            <div class="col-sm-7">
                                <div class='input-group date' id='datetimepicker_mulai_sk_baru'>    
                                    <input type='text' class="form-control" id="tgl_mulai_sk_baru" class="form-control" name="tgl_mulai_sk_baru" value="<?= @$kgb->tgl_mulai_sk_baru; ?>" />
                                    <span class="input-group-addon input-sm">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Gapok Baru :</label>
                            <div class="col-sm-7">
                                <div class='input-group date'>    
                                    <span class="input-group-addon input-sm">
                                        Rp.
                                    </span>                          
                                    <input class="form-control" id="gapok_baru" name="gapok_baru" value="<?= @$kgb->gapok_baru; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">MKG Baru :</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="mkg_sk_baru" name="mkg_sk_baru" value="<?= str_pad(@$kgb->mkg_sk_baru, 4, '0', STR_PAD_LEFT); ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Golru Baru :</label>
                            <div class="col-sm-7">
                                <?= form_dropdown('golru_baru', $golongan, @$kgb->golru_baru, 'class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Jabatan:</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="jabatan_baru" name="jabatan_baru" value="<?= ucwords_strtolower($kgb->jabatan_baru); ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">Pejabat Baru :</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="pejabat_baru" name="pejabat_baru" value="<?= @$kgb->pejabat_baru; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-5">NIP Pejabat Baru :</label>
                            <div class="col-sm-7">
                                <input class="form-control" id="nip_pejabat_baru" name="nip_pejabat_baru" value="<?= @$kgb->nip_pejabat_baru; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <input type="hidden" name="mode" value="<?= $mode; ?>"/>
                        <input type="hidden" name="id_kgb" value="<?= @$kgb->id_kgb; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>/>
                        <div class="pull-left">
                            <span style="color: red; font-size: 12px; font-weight: bold">*) silakan sempurnakan semua data di atas sebelum dicetak</span>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary" title="simpan" id="simpan"><i class="fa fa-save"></i></button>
                            <button class="btn btn-primary" id="reset">reset</button>

                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>
<script>
    $("#tgl_sk_baru").mask("9999-99-99", {placeholder: "_"});
    $("#tgl_sk_lama").mask("9999-99-99", {placeholder: "_"});
    $("#tgl_mulai_sk_baru").mask("9999-99-99", {placeholder: "_"});
    $("#tgl_mulai_sk_lama").mask("9999-99-99", {placeholder: "_"});
    $("#mkg_sk_lama").mask("99 99", {placeholder: "_"});
    $("#mkg_sk_baru").mask("99 99", {placeholder: "_"});

    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'kgb/simpan', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                $(".isi").load("<?= base_url('kgb/select/' . $this->uri->segment(3)); ?>/" + responseData);
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $(".isi").load("<?= base_url('kgb/select/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>");
    })
</script>