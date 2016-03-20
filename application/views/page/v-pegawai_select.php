<?php
$list_tipe_jabatan = array(
    '' => '-',
    '3' => 'Pimpinan TInggi Pratama (Eselon II)',
    '4' => 'Administrator (Eselon III)',
    '5' => 'Pengawas (Eselon IV)',
    '6' => 'Pelaksana (JFU)',
    '7' => 'Fungsional (JFT)',
);
$list_bagian = array();
foreach ($data_bagian as $bag) {
    $list_bagian[$bag->id_bag] = $bag->induk_bag == '' ? $bag->nama_bag : '&raquo; ' . $bag->nama_bag;
}
$list_golongan = array();
foreach ($data_golongan as $gol) {
    $list_golongan[$gol->id_golongan] = $gol->golongan;
}
$list_agama = array();
foreach ($data_agama as $aga) {
    $list_agama[$aga->id_agama] = $aga->nama_agama;
}
if (!empty($data_pegawai)) {
    $mode = 'edit';

    $option = '';
    $nama = $data_pegawai->nama;
    $glrdpn = $data_pegawai->glrdpn;
    $glrblk = $data_pegawai->glrblk;
    $sex = $data_pegawai->sex;
    $status = $data_pegawai->status;
    $nip = $data_pegawai->nip;
    $niplama = $data_pegawai->niplama;
    $tpt_lahir = $data_pegawai->tpt_lahir;
    $tgl_lahir = $data_pegawai->tgl_lahir;
    $agama = $data_pegawai->agama;
    $alamat = $data_pegawai->alamat;
    $pendidikan = $data_pegawai->pendidikan;
    $nama_pendidikan = nama_pendidikan($data_pegawai->pendidikan); //not from db
    $nama_jab = $data_pegawai->nama_jab;
    $tmt_jab = $data_pegawai->tmt_jab;
    $tipe_jab = $data_pegawai->tipe_jab;
    $bagian = $data_pegawai->bagian;
    $gol_awal = $data_pegawai->gol_awal;
    $gol_akhir = $data_pegawai->gol_akhir;
    $tmt_kp = $data_pegawai->tmt_kp;
    $tmt_awal = $data_pegawai->tmt_awal;
    $pmk_thn = $data_pegawai->pmk_thn;
    $pmk_bln = $data_pegawai->pmk_bln;
    $no_sk_pmk = $data_pegawai->no_sk_pmk;
    $tgl_pmk = $data_pegawai->tgl_pmk;
    $karpeg = $data_pegawai->karpeg;
    $hp = $data_pegawai->hp;
    $email = $data_pegawai->email;
    $masa_kerja = hitung_mk($tmt_awal);
} else {
    $mode = 'tambah';
}
?>
<?php require_once ('navigator.php'); ?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('pegawai')">kembali</a>
            <a class="btn btn-default btn-xs btn-info" target="_BLANK" href="<?= base_url('report/pegawai') . '/' . safe_encode($nip); ?>"><i class="fa fa-print"></i> biodata</a>
        </div>
    </div>
    <div class="panel-body">
        <form id="formku" role="form" method="post">
            <?php if ($nip != '') { ?>
                <div class="col-md-3 col-lg-2 form-group form-group-sm">
                    <a href="#" onclick="BukaPage('pegawai/upload_foto/<?= $nip; ?>')">
                        <img src="<?= base_url($path) . '/' . ($is_file_exist ? str_replace(' ', '_', $file) . '?' . rand() : 'nofoto.jpg'); ?>" width="100%" class="img-rounded">
                    </a>
                </div>
                <?php
            } else {
                ?>
                <div class="col-md-3 col-lg-2 form-group form-group-sm">
                    <img src = "<?= base_url($path) . '/' . 'nofoto.jpg'; ?>" width = "100%" class = "img-rounded">
                </div>
                <?php
            }
            ?>
            <div class="col-md-9 col-lg-4 form-group form-group-sm">
                <label>Nama</label><input type="text" name="nama" value="<?= @$nama; ?>" id="nama" maxlength="100" autofocus="autofocus" class="form-control uppercase" required="" /> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Gelar Depan</label><input type="text" name="glrdpn" value="<?= @$glrdpn; ?>" id="glrdpn" maxlength="50" class="form-control" /> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Gelar Belakang</label><input type="text" name="glrblk" value="<?= @$glrblk; ?>" id="glrblk" maxlength="50" class="form-control" /> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Jenis Kelamin</label><br>
                <input type="radio" name="sex" id="sex" <?= @$sex == 1 ? 'checked' : ''; ?> value="1">Pria
                &nbsp;&nbsp;
                <input type="radio" name="sex" id="sex" <?= @$sex == 2 ? 'checked' : ''; ?> value="2">Wanita
            </div>
            <div class="col-md-5 col-lg-3 form-group form-group-sm">
                <label>NIP</label><input type="text" name="nip" value="<?= @$nip; ?>" id="nip" maxlength="18" <?php if ($mode == 'edit') echo 'readonly'; ?> class="form-control numeric" required="" /> 
            </div>
            <div class="col-md-4 col-lg-2 form-group form-group-sm">
                <label>NIP Lama</label><input type="text" name="niplama" value="<?= @$niplama; ?>" id="niplama" maxlength="9" class="form-control numeric" /> 
            </div>
            <div class="col-md-3 col-lg-3 form-group form-group-sm">
                <label>Tempat Lahir</label><input type="text" name="tpt_lahir" value="<?= @$tpt_lahir; ?>" id="tpt_lahir" maxlength="50" class="form-control uppercase" required="" /> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Tanggal Lahir</label><input type="text" name="tgl_lahir" value="<?= @$tgl_lahir; ?>" id="tgl_lahir" maxlength="50" class="form-control" required=""/> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Agama</label> 
                <?= form_dropdown('agama', $list_agama, @$agama, 'class="form-control"'); ?>
            </div>
            <div class="col-md-12 col-lg-8 form-group form-group-sm">
                <label>Alamat</label><input type="text" name="alamat" value="<?= @$alamat; ?>" id="alamat" class="form-control uppercase" /> 
            </div>
            <div class="col-md-6 col-lg-2 form-group form-group-sm">
                <label>Jenis jabatan</label>
                <?= form_dropdown('tipe_jab', $list_tipe_jabatan, @$tipe_jab, 'class="form-control"'); ?>
            </div>
            <div class="col-md-6 col-lg-3 form-group form-group-sm">
                <label>Jabatan</label><input type="text" name="nama_jab" value="<?= @$nama_jab; ?>" id="nama_jab" maxlength="100" class="form-control uppercase" /> 
            </div>
            <div class="col-md-6 col-lg-2 form-group form-group-sm">
                <label>TMT Jabatan</label><input type="text" name="tmt_jab" value="<?= @$tmt_jab; ?>" id="tmt_jab"  class="form-control uppercase" /> 
            </div>
            <div class="col-md-6 col-lg-3 form-group form-group-sm">
                <label>Bagian</label>
                <?= form_dropdown('bagian', $list_bagian, @$bagian, 'class="form-control"'); ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-9 col-lg-3 form-group form-group-sm">
                <label>Pendidikan</label>
                <input class="typeahead form-control" value="<?= @$nama_pendidikan; ?>" id="nama_pendidikan">
            </div>
            <div class="col-md-3 col-lg-1 form-group form-group-sm">
                <label>Kode</label>
                <input class="form-control" name="pendidikan" id="pendidikan" value="<?= @$pendidikan; ?>" required>
            </div>
            <div class="col-md-4 col-lg-3 form-group form-group-sm">
                <label>Penambahan Masa Kerja</label>
                <div class="form-group input-group">
                    <input type="text" name="pmk_thn" value="<?= @$pmk_thn; ?>" id="pmk_thn" maxlength ="2" class="form-control" />  
                    <span class="input-group-addon">tahun</span>
                    <input type="text" name="pmk_bln" value="<?= @$pmk_bln; ?>" id="pmk_bln" maxlength ="2" class="form-control" />  
                    <span class="input-group-addon">bulan</span>
                </div>
            </div>

            <div class="col-md-4 col-lg-3 form-group form-group-sm">
                <label>Masa Kerja (dari TMT Awal)</label>
                <div class="form-group input-group">
                    <input type="text" value="<?= @$masa_kerja->tahun; ?>" disabled class="form-control" />  
                    <span class="input-group-addon">tahun</span>
                    <input type="text" value="<?= @$masa_kerja->bulan; ?>" disabled class="form-control" />  
                    <span class="input-group-addon">bulan</span>
                </div>
            </div>
            <!--div class="col-md-4 col-lg-2 form-group form-group-sm">
                <label>Tanggal PMK</label><input type="text" name="tgl_pmk" value="<?= @$tgl_pmk; ?>" id="tgl_pmk" maxlength="50" class="form-control"/> 
            </div>
            <div class="col-md-4 col-lg-2 form-group form-group-sm">
                <label>No SK PMK</label><input type="text" name="no_sk_pmk" value="<?= @$no_sk_pmk; ?>" id="no_sk_pmk" maxlength="50" class="form-control uppercase" /> 
            </div-->
            <div class="clearfix"></div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Status</label><br>
                <input type="radio" name="status" id="status" <?= @$status == 'PN' ? 'checked' : ''; ?> value="PN">PNS
                &nbsp;&nbsp;
                <input type="radio" name="status" id="status" <?= @$status == 'CP' ? 'checked' : ''; ?> value="CP">CPNS
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>TMT Awal</label><input type="text" name="tmt_awal" value="<?= @$tmt_awal; ?>" id="tmt_awal" class="form-control"  disabled title="Mengikuti data pada menu KP"/> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Gol. Awal</label>
                <?= form_dropdown('gol_awal', $list_golongan, @$gol_awal, 'class="form-control" disabled title="Mengikuti data pada menu KP"'); ?>
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Gol. Akhir</label>
                <?= form_dropdown('gol_akhir', $list_golongan, @$gol_akhir, 'class="form-control" disabled title="Mengikuti data pada menu KP"'); ?>
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>TMT Golongan</label><input type="text" name="tmt_kp" value="<?= @$tmt_kp; ?>" id="tmt_kp" class="form-control"  disabled title="Mengikuti data pada menu KP"/> 
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4 col-lg-2 form-group form-group-sm">
                <label>Karpeg</label><input type="text" name="karpeg" value="<?= @$karpeg; ?>" id="karpeg" maxlength="50" class="form-control uppercase" /> 
            </div>

            <div class="col-md-4 col-lg-2 form-group form-group-sm">
                <label>Nomor HP</label><input type="text" name="hp" value="<?= @$hp; ?>" id="hp" maxlength="14" class="form-control numeric" /> 
            </div>
            <div class="col-md-4 col-lg-4 form-group form-group-sm">
                <label>Email</label><input type="email" name="email" value="<?= @$email; ?>" id="email" maxlength="50" class="form-control lowercase" /> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Next KGB</label><input type="text" value="<?= @$data_kgb->next_date_kgb; ?>"  class="form-control" disabled  title="Cek gol. awal, gol. akhir, PMK, serta TMT awal"/> 
            </div>
            <div class="col-md-3 col-lg-2 form-group form-group-sm">
                <label>Next MKG KGB</label><input type="text" value="<?= @$data_kgb->next_mkg_kgb; ?>"  class="form-control" disabled /> 
            </div>
            <div class="pull-right">
                <input value="<?= $mode; ?>" type="hidden" name="mode">
                <input type="submit" value="Simpan" class="btn btn-success btn-xs"/>
            </div>
        </form>
    </div>
</div>
<script>
    jQuery(function($) {
        $("#nip").mask("999999999999999999", {placeholder: "_"});
        $("#niplama").mask("999999999", {placeholder: "_"});
        $("#tgl_lahir").mask("9999-99-99", {placeholder: "_"});
        $("#tmt_awal").mask("9999-99-99", {placeholder: "_"});
        $("#tmt_kp").mask("9999-99-99", {placeholder: "_"});
        $("#tmt_jab").mask("9999-99-99", {placeholder: "_"});
    });
    $("#pendidikan").keydown(function(e) {
        e.preventDefault();
    });
    $('#formku').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: '<?php echo base_url('pegawai/simpan'); ?>', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(responseData) {
                $.notify(responseData, {
                    className: 'success',
                });
                BukaPage('pegawai/select/' + $('#nip').val());
            },
            error: function(responseData) {
                console.log('Ajax request not recieved!');
            }
        });
    })
    var vpendidikan = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= base_url('json/pendidikan'); ?>?q=y',
        remote: {
            url: '<?= base_url('json/pendidikan'); ?>?q=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#nama_pendidikan').typeahead(null, {
        name: 'pendidikan',
        display: 'nama_dik',
        limit: 15,
        source: vpendidikan,
        templates: {
            empty: [
                '<div class="empty-message">',
                'pendidikan tidak ditemukan',
                '</div>'
            ].join('\n'),
            suggestion: function(data) {
                return '<p><strong>' + data.kode_dik + '</strong> – ' + data.nama_dik + '</p>';
            }
        }

    }).on('typeahead:selected', function(event, data) {
        $('#pendidikan').val(data.kode_dik);
    });


    $("#nama_pendidikan").click(function(event_details) {
        $(this).select();
        $('#pendidikan').val('');
    });

</script>