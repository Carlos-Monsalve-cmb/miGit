<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
//var_dump ($this->param['usersgroups'] );


?>

<form id="frm_main" name="frm_main" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" data-error="<?php echo lang('lbl_field_required'); ?>" data-delete="<?php echo lang('lbl_field_check_plural'); ?>" data-delete-confirm="<?php echo lang('lbl_field_delete'); ?>">
    <?php if (isset($query['edit'])) { ?><input name="checkbox[]" type="hidden" value="<?php echo $query['edit']['id_users_group']; ?>"><?php } ?>
    <?php
    // Buttons
    $this->load->view('admin/common/list-buttons', array('view_from' => (!isset($query['edit']) ? 'add' : 'edit')));
    ?>

    <div class="row-fluid">
        <div class="span12 column" id="col0">
            <div class="box" id="box-0">
                <h4 class="box-header round-top"><?php echo lang('lbl_users_group_singular'); ?>
                    <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                </h4>
                <div class="box-container-toggle">
                    <div class="box-content">
                        <div class="row-fluid">
                            <fieldset>
                                <legend><?php
                                $disabled='';
                                if (isset($query['edit'])) {
                                    $disabled='disabled';
                                    echo lang('lbl_update_register', '', 'lbl_users_group_singular');
                                } else {
                                    echo lang('lbl_insert_register', '', 'lbl_users_group_singular');
                                } ?></legend>

                                <?php 
                                if (isset($query['edit'])) {  
                                ?>
                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="id_users_group" title="ID de Grupo de Usuarios">ID <?php echo lang('lbl_users_group_plural'); ?></label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="id_users_group" id="id_users_group" type="text" value="<?php if (isset($query['edit']['id_users_group'])) {
                                                                                                                                    echo $query['edit']['id_users_group'];
                                                                                                                                } ?>" placeholder="<?php echo lang('lbl_input_male', '', 'ID de Grupo de Usuarios'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="date_insert" title="<?php echo lang('lbl_date_insert'); ?>"><?php echo lang('lbl_date_insert'); ?>:</label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="date_insert" id="date_insert" type="text" value="<?php if (isset($query['edit']['date_insert'])) {
                                                                                                                                        echo $query['edit']['date_insert'];
                                                                                                                                    } ?>" placeholder="<?php echo lang('lbl_input_female', '', 'lbl_date_insert'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="date_edit" title="<?php echo lang('lbl_date_edit'); ?>"><?php echo lang('lbl_date_edit'); ?>:</label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="date_edit" id="date_edit" type="text" value="<?php if (isset($query['edit']['date_edit'])) {
                                                                                                                                    echo $query['edit']['date_edit'];
                                                                                                                                } ?>" placeholder="<?php echo lang('lbl_empty'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="users_id" title="ID <?php echo lang('lbl_commercials_managers_singular'); ?>">ID <?php echo lang('lbl_commercials_managers_singular'); ?></label>
                                        <div class="controls">
                                        <input <?php echo $disabled; ?> class="span12" name="users_id" id="users_id" type="text" value="<?php if (isset($query['edit']['users_id'])) {
                                                                                                                                echo $query['edit']['users_id'];
                                                                                                                            } ?>" placeholder="<?php echo lang('lbl_input_male', '', 'ID Gerente Comercial'); ?>">
                                    
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="name" title="<?php echo lang('lbl_commercials_managers_singular'); ?>"><?php echo lang('lbl_commercials_managers_singular'); ?></label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="name" id="name" type="text" value="<?php if (isset($query['edit']['name'])) {
                                                                                                                                    echo $query['edit']['name'];
                                                                                                                                } ?>" placeholder="<?php echo lang('lbl_input_male', '', 'lbl_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="email" title="<?php echo lang('lbl_email'); ?> del <?php echo lang('lbl_commercials_managers_singular'); ?>"><?php echo lang('lbl_email'); ?> del <?php echo lang('lbl_commercials_managers_singular'); ?></label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="email" id="email" type="text" value="<?php if (isset($query['edit']['email'])) {
                                                                                                                                    echo $query['edit']['email'];
                                                                                                                                } ?>" placeholder="<?php echo lang('lbl_input_male', '', 'lbl_email'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="users_comercial_id" title="ID <?php echo lang('lbl_commercials_singular'); ?>">ID <?php echo lang('lbl_commercials_singular'); ?></label>
                                        <div class="controls">
                                            <input <?php echo $disabled; ?> class="span12" name="users_comercial_id" id="users_comercial_id" type="text" value="<?php if (isset($query['edit']['users_comercial_id'])) {
                                                                                                                                    echo $query['edit']['users_comercial_id'];
                                                                                                                                } ?>" placeholder="<?php echo lang('lbl_input_male', '', 'ID Comercial'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php } else {?>
                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="users_id" title="<?php echo lang('lbl_commercials_managers_singular'); ?>"><?php echo lang('lbl_commercials_managers_singular'); ?>:</label>
                                        <div class="rechargeHTML layouts-dependent controls">
                                            <select class="span12 chzn-select required" id="users_id" name="users_id" data-placeholder="<?php echo lang('lbl_select_ale','','lbl_commercials_managers_singular'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_commercials_managers_singular'); ?></option>
                                                <?php
                                                foreach ($usersgroups['manager'] as $row) { ?>
                                                    <option value="<?php echo $row->id_user ?>"> <?php echo $row->id_user.' - '.$row->name;
                                                    ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="users_comercial_id" title="<?php echo lang('lbl_commercials_singular'); ?>"><?php echo lang('lbl_commercials_singular'); ?>:</label>
                                        <div class="rechargeHTML layouts-dependent controls">
                                            <select class="span12 chzn-select required" id="users_comercial_id" name="users_comercial_id" data-placeholder="<?php echo lang('lbl_select_ale','','lbl_commercials_singular'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_commercials_singular'); ?></option>
                                                <?php
                                                foreach ($usersgroups['comercial'] as $row) { ?>
                                                    <option value="<?php echo $row->id_user ?>"> <?php echo $row->id_user.' - '.$row->name;
                                                    ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row-fluid">
                                    <div class="control-group span12">
                                        <label class="control-label" for="observations" title="<?php echo lang('lbl_observations'); ?>"><?php echo lang('lbl_observations'); ?>:</label>
                                        <div class="controls">
                                            <textarea class="span12 html_editor_on_simple required" id="observations" name="observations" rows="3" placeholder="<?php echo lang('lbl_input_female','','lbl_observations'); ?>"><?php if(isset($query['edit']['observations'])) 
                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                echo $query['edit']['observations']; 
                                                                                                                                                                                                                            } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions ">
                                    <button   type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button   type="submit" id="submit" name="submit" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>