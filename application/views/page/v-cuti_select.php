<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <?= $header; ?>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('cuti/view/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body"><?php
        $list_jenis = array(
            '' => '-',
            '1' => 'Sisa Tahun Lalu',
            '2' => 'Jatah Tahun Ini',
            '4' => 'Cuti',
            '5' => 'Ijin',
        );
        $select_jenis = array(
            '4' => 'Cuti',
            '5' => 'Ijin',
        );
        if (!empty($data)) {
            $cuti = $data;
            $nip = $cuti->nip;
            $jenis = $cuti->jenis;
        } else {
            $jenis = $this->uri->segment(4) == 'ijin' ? 5 : 4;
            $nip = $this->uri->segment(3);
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
                            <?php
                            if ($jenis == 4 || $jenis == 5) {
                                echo form_dropdown('jenis', $select_jenis, $jenis, 'class="form-control"');
                            } else {
                                ?>
                                <input class="form-control" value="<?= $list_jenis[$jenis]; ?>" readonly="">
                                <input type="hidden" id="jenis" name="jenis" value="<?= $jenis; ?>">
                            <?php }
                            ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Tanggal :</label>
                        <div class="col-sm-7">
                            <div class='input-group date' >    
                                <input type='text' class="form-control" id="date_awal" class="form-control" name="date_awal" value="<?= @$cuti->date_awal; ?>" />
                                <span class="input-group-addon input-sm">
                                    -
                                </span> 
                                <input type='text' class="form-control" id="date_akhir" class="form-control" name="date_akhir" value="<?= @$cuti->date_akhir; ?>" />
                                <span class="input-group-addon input-sm">
                                    <span class="glyphicon glyphicon-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label class="control-label col-sm-5">Jumlah (hari) :</label>
                        <div class="col-sm-7">
                            <input class="form-control" id="kuantitas" name="kuantitas" value="<?= @abs($cuti->kuantitas); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="hidden" name="mode" value="<?= $mode; ?>"/>
                    <input type="hidden" name="id_cuti" value="<?= @$cuti->id_cuti; ?>" <?= $mode == 'tambah' ? 'disabled' : ''; ?>/>
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
            url: 'cuti/simpan', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify('Data telah disimpan', {
                    className: 'success',
                });
                BukaPage('cuti/view/' + $('#nip').val());
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $(".isi").load("<?= base_url('cuti/select/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>");
    })
</script>