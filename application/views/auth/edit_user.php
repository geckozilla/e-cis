
<div class="panel panel-primary">
    <div class="panel-heading">
        <?php echo lang('edit_user_heading'); ?>
    </div>
    <div class="panel-body">

        <form id="formku" role="form" method="post">

            <p>
                <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br />
                <?php echo form_input($first_name); ?>
            </p>

            <p>
                <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br />
                <?php echo form_input($last_name); ?>
            </p>

            <p>
                <?php echo lang('edit_user_validation_email_label', 'email'); ?> <br />
                <?php echo form_input($email); ?>
            </p>

            <p>
                <?php echo lang('edit_user_company_label', 'company'); ?> <br />
                <?php echo form_input($company); ?>
            </p>

            <p>
                <?php echo lang('edit_user_phone_label', 'phone'); ?> <br />
                <?php echo form_input($phone); ?>
            </p>

            <p>
                <?php echo lang('edit_user_password_label', 'password'); ?> <br />
                <?php echo form_input($password); ?>
            </p>

            <p>
                <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br />
                <?php echo form_input($password_confirm); ?>
            </p>                    
            <p><?php echo lang('edit_user_groups_heading', 'group'); ?></p>
            <div class="form-group">
                <?php if ($this->ion_auth->is_admin()): ?>
                    <?php foreach ($groups as $group): ?>
                        <label class="checkbox">
                            <?php
                            $gID = $group['id'];
                            $checked = null;
                            $item = null;
                            foreach ($currentGroups as $grp) {
                                if ($gID == $grp->id) {
                                    $checked = ' checked="checked"';
                                    break;
                                }
                            }
                            ?>
                        </label>

                        <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                    <?php endforeach ?>

                <?php endif ?>
            </div>

            <?php echo form_hidden('id', $user->id); ?>
            <?php echo form_hidden($csrf); ?>

            <p><?php echo form_submit('submit', lang('edit_user_submit_btn')); ?></p>
            <p>
                <a href="#" onclick="BukaPage('auth')">Kembali</a>
            </p>


        </form>
    </div>
    <div class="panel-footer">
        Page rendered in <strong>{elapsed_time}</strong> seconds.
        &nbsp;
    </div>
</div>

<script>
    $('#formku').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            dataType: 'html',
            type: 'post',
            url: '<?php echo base_url('auth/edit_user/' . $this->uri->segment(3)); ?>', data: $('#formku').serialize(),
            //beforeSubmit: validator,
            success: function(result) {
                if (result === 'success') {
                    $.notify(result, {
                        className: 'success',
                    });
                    BukaPage('auth');
                } else {
                    $.notify(result, {
                        className: 'error',
                    });
                    BukaPage('auth/edit_user/<?= $this->uri->segment(3); ?>');
                }
            },
            error: function(responseData) {
                window.location.replace('');
            }
        });
    })
</script>