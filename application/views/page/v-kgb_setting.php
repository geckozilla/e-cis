<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('kgb')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        if (!empty($data_kgb)) {
            $kgb = $data_kgb;
            ?>

            <form id="formku" role="form" action="#" method="post" autocomplete="off" >
                <div class="row">
                    <div class="col-lg-6 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Nama Pejabat :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_nama_pejabat" name="kgb_nama_pejabat" value="<?= @$kgb->kgb_nama_pejabat; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">NIP Pejabat :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_nip_pejabat" name="kgb_nip_pejabat" value="<?= @$kgb->kgb_nip_pejabat; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Jabatan Pejabat :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="kgb_jabatan_pejabat" name="kgb_jabatan_pejabat" style = 'resize:none;height: 70px',><?= @$kgb->kgb_jabatan_pejabat; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Counter Nomor SK :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_counter" name="kgb_counter" value="<?= @$kgb->kgb_counter; ?>">
                                <span style="color: red; font-size: 12px;">*) nomor SK selanjutnya bernilai counter+1</span>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Dasar Hukum :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_dasar_hukum" name="kgb_dasar_hukum" value="<?= @$kgb->kgb_dasar_hukum; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Kota :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_kota" name="kgb_kota" value="<?= @$kgb->kgb_kota; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Unit Kerja :</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="kgb_unit_kerja" name="kgb_unit_kerja" value="<?= @$kgb->kgb_unit_kerja; ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4">Kepada :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="kgb_kepada" name="kgb_kepada" style = 'resize:none;height: 85px',><?= @$kgb->kgb_kepada; ?></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12">
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
    $('#simpan').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: 'kgb/setting_simpan', data: $('#formku').serialize(),
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                $(".isi").load("<?= base_url('kgb/setting/'); ?>/");
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