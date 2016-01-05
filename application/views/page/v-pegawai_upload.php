<?php
require_once ('navigator.php');
?>
<div class="panel panel-<?= $tema; ?>">
    <div class="panel-heading">
        <b><?= $header; ?></b>
        <div class="pull-right">
            <a class="btn btn-default btn-xs" href="#" onclick="BukaPage('pegawai/select/<?= $this->uri->segment(3); ?>')">kembali</a>
        </div>
    </div>
    <div class="panel-body">
        <div class="row input-group-sm">
            <div class="col-md-6 col-lg-4">
                <input id="input-foto" name="userfile" type="file" multiple class="file-loading">
            </div>
            <?php if ($is_file_exist) { ?>
                <div class="col-md-4 col-lg-2">
                    <img src="<?= $filepath . '?' . random_string('alnum', 16); ?>" width="100%" class="img-rounded">
                    <div class="clearfix">&nbsp;</div>
                    <button class="btn btn-danger btn-block" onclick="HapusFoto('<?= $file; ?>')">Hapus Foto</button>
                </div>
                <div class="col-md-6 col-lg-4">
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    function HapusFoto(file) //PEGAWAI_TAMPIL
    {
        var x = confirm("Foto akan dihapus?");
        if (x) {
            $.ajax({
                url: '<?php echo base_url('pegawai/hapus_foto'); ?>',
                type: 'POST',
                data: {file: file},
                success: function(result) {
                    BukaPage('pegawai/upload_foto/<?= $this->uri->segment(3); ?>');
                }
            });
        }
    }
    $("#input-foto").fileinput({
        showCaption: false,
        uploadUrl: "<?= base_url('pegawai/upload_foto/' . $this->uri->segment(3)); ?>",
        autoReplace: true,
        dropZoneTitle: "<?= $is_file_exist ? 'Ubah Foto' : 'Upload Foto'; ?>",
        maxFileCount: 1,
        allowedFileExtensions: ["jpg"],
        maxImageWidth: 400,
        resizeImage: true,
    }).on('fileuploaded', function(event, data) {
        $.notify('Foto berhasil diupload', {
            className: 'success',
        });
        BukaPage('pegawai/upload_foto/<?= $this->uri->segment(3); ?>');
    });
</script>