<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form id="frm_main" name="frm_main" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" data-error="<?php echo lang('lbl_field_required'); ?>" data-delete="<?php echo lang('lbl_field_check_plural'); ?>" data-delete-confirm="<?php echo lang('lbl_field_delete'); ?>"<?php if( isset( $query['edit'] ) ) { echo ' data-ptitle="#'. $query['edit']['id_vehicle'] .' - '. $query['edit']['name'] .'"'; } ?>>
    <?php if( isset( $query['edit'] ) ) { ?><input name="checkbox[]" type="hidden" value="<?php echo $query['edit']['id_vehicle']; ?>" data-id="vehicle"><?php }
          else { ?><input name="img_tmp_code" type="hidden" value="<?php echo rand(); ?>"><?php } ?>

<?php
    // Buttons
    // $this->load->view( 'admin/common/list-buttons' , array( 'view_from' => ( ! isset( $query['edit'] ) ? 'add' : 'edit' ) ) );

    // Number of buttons
    $n_btns = 0;
    $n_btns_specific = 0;

    // Si la sección es agregar, sólo queremos mostrar list, y sino...
    if( $view_from != 'agregar' )
    {
        $n_btns += in_array( $concept_singular .'.create' , $user_permissions ) ? 1 : 0;
        $n_btns_specific += 1;
        // $n_btns_specific += 1; // Imprimir

        // Si la sección es distinta a editar, lo mostramos
        if( $view_from != 'editar' )
        {
            if( in_array( $concept_singular .'.update' , $user_permissions ) )
            {
                $n_btns += 1;
            }
            else if( in_array( $concept_singular .'.view' , $user_permissions ) )
            {
                $n_btns += 1;
            }

            $n_btns += in_array( $concept_singular .'.delete' , $user_permissions ) ? 1 : 0;
        }
        else
        {
            $n_btns += in_array( $concept_singular .'.delete' , $user_permissions ) ? 1 : 0;

            if( ( isset( $query['edit'] ) && ! empty( $query['edit']['id_appraisal'] ) ) /* || $query['edit']['images'] > 0 */ )
            {
                // $n_btns += 1;

                if( isset( $query['edit'] ) && ! empty( $query['edit']['id_appraisal'] ) )
                {
                    $n_btns_specific += 1;
                }
                /* if( $query['edit']['images'] > 0 )
                {
                    $n_btns_specific += 1;
                } */
            }

            $n_btns_specific += 1;

            // Print Sticker
            $n_btns += 1;
        }
    }

    // Cases
    $nt_btns = $n_btns + $n_btns_specific;

    // Always show list
    if( $nt_btns == 0 || $nt_btns == 1 ) { $action_buttons['size'] = $action_buttons['size_d'] = $action_buttons['size_s'] = 12; }
    else if( $nt_btns == 2 ) { $action_buttons['size'] = $action_buttons['size_d'] = $action_buttons['size_s'] = 6; }
    else if( $nt_btns == 3 ) { $action_buttons['size'] = $action_buttons['size_d'] = $action_buttons['size_s'] = 4; }
    else if( $nt_btns == 4 ) { $action_buttons['size'] = $action_buttons['size_d'] = $action_buttons['size_s'] = 3; }
    else if( $nt_btns == 6 ) { $action_buttons['size'] = $action_buttons['size_d'] = $action_buttons['size_s'] = 2; }
    else if( $nt_btns == 5 )
    {
        $action_buttons['size'] = 3;
        $action_buttons['size_d'] =
        $action_buttons['size_s'] = 2;
    }
    else
    {
        $action_buttons['size'] =
        $action_buttons['size_d'] =
        $action_buttons['size_s'] = floor( 12 / ( $n_btns + $n_btns_specific > 0 ? $n_btns + $n_btns_specific : 1 ) );
    }
                                                                                                                            // echo '<b>$n_btns: </b>'. $n_btns .'<br>';
                                                                                                                            // echo '<b>$n_btns_specific: </b>'. $n_btns_specific .'<hr>';

    // View buttons
?>
    <div id="options" class="row-fluid">
        <div class="span<?php echo $action_buttons['size']; ?> btn btn-large btn-block">
            <a href="<?php echo $action_buttons['list']; ?>" title="<?php echo lang('lbl_select_register','','lbl_'. $concept_plural .'_plural'); ?>">
                <div><i class="icon-list"></i></div>
                <div><?php echo lang('lbl_select'); ?></div>
            </a>
        </div>
<?php
    if( $view_from != 'agregar' )
    {
        if( in_array( $concept_singular .'.create' , $user_permissions ) )
        {
?>
        <div class="span<?php echo $action_buttons['size']; ?> btn btn-large btn-block">
            <a href="<?php echo $action_buttons['insert']; ?>" title="<?php echo lang('lbl_insert_register','','lbl_'. $concept_plural .'_singular'); ?>">
                <div><i class="icon-pencil"></i></div>
                <div><?php echo lang('lbl_insert'); ?></div>
            </a>
        </div>
<?php
        }

        if( in_array( $concept_singular .'.update' , $user_permissions ) && $view_from != 'editar' )
        {
?>
        <div class="span<?php echo $action_buttons['size']; ?> btn btn-large btn-block">
            <a id="edit" href="<?php echo $action_buttons['update']; ?>" title="<?php echo lang('lbl_update_register','','lbl_'. $concept_plural .'_singular'); ?>">
                <div><i class="icon-edit"></i></div>
                <div><?php echo lang('lbl_update'); ?></div>
            </a>
        </div>
<?php
        }
        else if( ! in_array( $concept_singular .'.update' , $user_permissions ) && in_array( $concept_singular .'.view' , $user_permissions ) && $view_from != 'editar' )
        {
?>
        <div class="span<?php echo $action_buttons['size']; ?> btn btn-large btn-block">
            <a <?php /* id="edit" */ ?> href="<?php echo $action_buttons['update']; ?>" title="<?php echo lang('lbl_view_register','','lbl_'. $concept_plural .'_singular'); ?>">
                <div><i class="icon-search"></i></div>
                <div><?php echo lang('lbl_view'); ?></div>
            </a>
        </div>
<?php
        }

        if( in_array( $concept_singular .'.delete' , $user_permissions ) )
        {
?>
        <div class="span<?php echo $action_buttons['size_d']; ?> btn btn-large btn-block">
            <a id="delete" href="<?php echo $action_buttons['delete']; ?>" title="<?php echo lang('lbl_delete_register','','lbl_'. $concept_plural .'_plural'); ?>">
                <div><i class="icon-trash"></i></div>
                <div><?php echo lang('lbl_delete'); ?></div>
            </a>
        </div>
<?php
        }

        if( isset( $query['edit'] ) && ! empty( $query['edit']['id_appraisal'] ) )
        {
?>
        <div class="span<?php echo $action_buttons['size_s']; ?> btn btn-large btn-block">
            <a target="_blank" href="<?php echo BACKEND_PATH_APPRAISAL_UPDATE .'/'. $query['edit']['id_appraisal']; ?>" title="<?php echo lang('lbl_view') .' '. lang('lbl_appraisals_singular'); ?>">
                <div><i class="icon-share"></i></div>
                <div><?php echo lang('lbl_view') .' '. lang('lbl_appraisals_singular'); ?></div>
            </a>
        </div>
<?php
        }

        // if( $query['edit']['images'] > 0 )
        // {
?>
        <div class="span<?php echo $action_buttons['size_s']; ?> btn btn-large btn-block">
            <a href="<?php echo BACKEND_PATH_VEHICLE_DOWNLOAD .'/'. $query['edit']['id_vehicle']; ?>" title="<?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?>" class="download">
                <div><i class="icon-download"></i></div>
                <div><?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?></div>
            </a>
        </div>
        <div class="span<?php echo $action_buttons['size_s']; ?> btn btn-large btn-block btn-info">
            <a target="_blank" href="<?php echo BACKEND_PATH_VEHICLE_PRINTING .'-pegatina/'. $query['edit']['id_vehicle'] .'?ts='. time(); ?>" title="<?php echo lang('lbl_printing') .' '. lang('lbl_sticker'); ?>" data-timestamp>
                <div><i class="icon-print icon-white"></i></div>
                <div><?php echo lang('lbl_printing') .' '. lang('lbl_sticker'); ?></div>
            </a>
        </div>
<?php
        // }

        /* if( isset( $query['edit'] ) )
        {
?>
        <div class="span<?php echo $action_buttons['size_s']; ?> btn btn-large btn-block btn-info">
            <a target="_blank" href="<?php echo BACKEND_PATH_VEHICLE_PRINTING .'/'. $query['edit']['id_vehicle']; ?>" title="<?php echo lang('lbl_printing'); ?>">
                <div><i class="icon-print icon-white"></i></div>
                <div><?php echo lang('lbl_printing'); ?></div>
            </a>
        </div>
<?php
        } */
    }
?>
    </div>

    <?php if( isset( $query['edit'] ) ){ ?>

	<!-- START - Print -->
<?php
    // Print View
    $this->load->view( 'admin/vehicles/print' , array( 'query' => $query ) );
?>
    <!-- END - Print -->

    <div class="row-fluid no-print">
        <div class="span12 column">
            <div class="box">
                <h4 class="box-header round-top"><?php echo lang('lbl_information'); ?>
                    <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                </h4>
                <div class="box-container-toggle">
                    <div class="box-content">
                        <div class="row-fluid">
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_reference'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['id_vehicle']; ?>">
                                </div>
                            </div>

                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_auctions_plural'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['auctions']; ?>">
                                </div>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_type'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['user_type']; ?>">
                                </div>
                            </div>

                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_seller'); ?>:</label>
                                <?php if( isset( $query['edit']['user'] ) && ! empty( $query['edit']['user'] ) && $query['edit']['user'] != lang('lbl_empty') ) { ?>
                                <div class="controls input-append">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['user']; ?>">
                                    <a class="btn btn-success add-on" href="<?php echo $query['edit']['user_url']; ?>"><i class="icon-search icon-white"></i></a>
                                </div>
                                <?php } else { ?>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['user']; ?>">
                                </div>
                                <?php } ?>
                            </div>

                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_amount'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php if( isset($query['edit']['amount']) ) { echo $query['edit']['amount'] .' EUR'; } else { echo lang('lbl_empty'); } ?>">
                                </div>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_tax_name'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php if(isset($query['edit']['tax']) && $query['edit']['tax'] == 1) { echo lang('lbl_tax_yes'); } else { echo lang('lbl_tax_no'); } ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_auctions_singular'); ?>:</label>
                                <?php if( isset( $query['edit']['auction'] ) && ! empty( $query['edit']['auction'] ) && $query['edit']['auction'] != lang('lbl_empty') ) { ?>
                                <div class="controls input-append">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['auction']; ?>">
                                    <a class="btn btn-success add-on" href="<?php echo $query['edit']['auction_url']; ?>"><i class="icon-search icon-white"></i></a>
                                </div>
                                <?php } else { ?>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo lang('lbl_empty'); ?>">
                                </div>
                                <?php } ?>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_bids_plural'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['bids']; ?>">
                                </div>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_max_bid'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php if( isset($query['edit']['bid_max']) ) { echo $query['edit']['bid_max'] .' EUR'; } else { echo lang('lbl_empty'); } ?>">
                                </div>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_buyer'); ?>:</label>
                                <?php if( isset( $query['edit']['buyer'] ) && ! empty( $query['edit']['buyer'] ) && $query['edit']['buyer'] != lang('lbl_empty') ) { ?>
                                <div class="controls input-append">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['buyer']; ?>">
                                    <a class="btn btn-success add-on" href="<?php echo $query['edit']['buyer_url']; ?>"><i class="icon-search icon-white"></i></a>
                                </div>
                                <?php } else { ?>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo lang('lbl_empty'); ?>">
                                </div>
                                <?php } ?>
                            </div>

                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_amount_end'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php if( isset($query['edit']['amount_buyer']) ) { echo $query['edit']['amount_buyer'] .' EUR'; } else { echo lang('lbl_empty'); } ?>">
                                </div>
                            </div>
                            <div class="control-group span2">
                                <label class="control-label"><?php echo lang('lbl_status'); ?>:</label>
                                <div class="controls">
                                    <input disabled class="span12" type="text" value="<?php echo $query['edit']['status']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>
    <div class="row-fluid no-print">
    	<div class="span12 column" id="col0">
    		<div class="box" id="box-0">
    			<h4 class="box-header round-top"><?php echo lang('lbl_vehicles_plural'); ?>
    				<a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
    			</h4>
    			<div class="box-container-toggle">
    				<div class="box-content">
    					<div class="row-fluid">
    						<fieldset>
    							<legend><?php if(isset($query['edit'])) { echo lang('lbl_update_register','','lbl_vehicles_singular'); } else { echo lang('lbl_insert_register','','lbl_vehicles_singular'); } ?></legend>
                                <?php if(isset($query['edit'])) { ?>
                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="reference" title="<?php echo lang('lbl_reference'); ?>"><?php echo lang('lbl_reference'); ?>:</label>
                                        <div class="controls">
                                                <input disabled class="span12" name="reference" id="reference" type="text" value="<?php if(isset($query['edit']['id_vehicle'])) { echo $query['edit']['id_vehicle']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_reference'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="date_insert" title="<?php echo lang('lbl_date_insert'); ?>"><?php echo lang('lbl_date_insert'); ?>:</label>
                                        <div class="controls">
                                                <input disabled class="span12" name="date_insert" id="date_insert" type="text" value="<?php if(isset($query['edit']['date_insert'])) { echo $query['edit']['date_insert']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_date_insert'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="date_edit" title="<?php echo lang('lbl_date_edit'); ?>"><?php echo lang('lbl_date_edit'); ?>:</label>
                                        <div class="controls">
                                                <input disabled class="span12" name="date_edit" id="date_edit" type="text" value="<?php if(isset($query['edit']['date_edit'])) { echo $query['edit']['date_edit']; } ?>" placeholder="<?php echo lang('lbl_empty'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr style="margin-top: 10px;">

                                <?php } ?>

<?php /*   N E W   E S T R U C T U R E   */

    // Data to JS
    $data_to_icos = ' data-ccontact=""'
                   .' data-cs="'. $concept_singular .'"'
                   .' data-cp="'. $concept_plural .'"'
                   .' data-id="'. ( isset( $query['edit'] ) ? $query['edit']['id_'. $concept_singular ] : '' ) .'"';

    if( isset( $query['edit'] ) && ! empty( $query['edit']['contacts_id'] ) )
    {
        $data_to_icos .= ' data-url="'. BACKEND_PATH_CONTACT_UPDATE .'/'. $query['edit']['contacts_id'] .'"';
        $class_to_ico = ' icon-white';
        $class_to_span = ' btn-success';
        $attrs_to_input = ' readonly';
    }
    else
    {
        $data_to_icos .= ' data-url="'. BACKEND_PATH_CONTACT_INSERT .'"';
        $class_to_ico = '';
        $class_to_span = '';
        $attrs_to_input = '';
    }

    if( $ACCESS['contact'] )
    {
        $attrs_2_input = ' required';
    }
    else
    {
        $attrs_2_input = '';
    }
?>
                                <input type="hidden" id="contacts_id" name="contacts_id" value="<?php if( isset( $query['edit'] ) && ! empty( $query['edit']['contacts_id'] ) ){ echo $query['edit']['contacts_id']; }?>">
                                <input type="hidden" id="email" name="email" value="<?php if( isset( $query['edit'] ) && ! empty( $query['edit']['email'] ) ){ echo $query['edit']['email']; }?>">
                                <input type="hidden" id="phone" name="phone" value="<?php if( isset( $query['edit'] ) && ! empty( $query['edit']['phone'] ) ){ echo $query['edit']['phone']; }?>">

                                <div class="row-fluid">
                                    <div class="control-group span2">
                                        <label class="control-label" for="contact" title="<?php echo lang('lbl_contacts_singular'); ?>"><?php echo lang('lbl_contacts_singular'); ?>: <?php if( $ACCESS['contact'] ) { ?><i class="icon-asterisk"></i><?php } ?></label>
                                        <div class="controls<?php if( $ACCESS['contact'] ) { echo ' input-append'; } ?>">
                                            <input readonly class="span12<?php echo $attrs_2_input; ?>" name="contact" id="contact" type="text" value="<?php if( isset( $query['edit']['contact'] ) ) { echo $query['edit']['contact']; } /* style="padding-right:25px;" */ ?>" data-placeholder="<?php echo lang('lbl_contacts_singular'); ?>">
<?php if( $ACCESS['contact'] ) { ?>
                                            <span class="add-on btn<?php echo $class_to_span; ?>"><i class="icon-user<?php echo $class_to_ico; ?>"<?php echo $data_to_icos; ?>></i></span>
<?php } ?>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="status_id" title="<?php echo lang('lbl_status'); ?>"><?php echo lang('lbl_status'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="status_id" name="status_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_status'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_status'); ?></option>
                                                <?php if( isset( $query['status'] ) ) { foreach( $query['status'] as $row ) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['status_id'] ) && $query['edit']['status_id'] == $row['id'] )
                                                                                                 || ( isset( $defaults['status_id'] ) && $defaults['status_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="out_use" title="<?php echo lang('lbl_out_use'); ?>"><?php echo lang('lbl_out_use'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="out_use" name="out_use" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['out_use'] ) && $query['edit']['out_use'] == 1 )
                                                                            || ( isset( $defaults['out_use'] ) && $defaults['out_use'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['out_use'] ) && $query['edit']['out_use'] == 0 )
                                                                            || ( isset( $defaults['out_use'] ) && $defaults['out_use'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="typologies_id" title="<?php echo lang('lbl_typologies_singular'); ?>"><?php echo lang('lbl_typologies_singular'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="rechargeHTML typologies-dependent controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="typologies_id" name="typologies_id" data-placeholder="<?php echo lang('lbl_select_female','','lbl_typologies_singular'); ?>"<?php if( isset( $defaults ) ) { echo ' data-default-dependent'; }?>>
                                                    <option value=""><?php echo lang('lbl_select_female','','lbl_typologies_singular'); ?></option>
                                                    <?php if(isset($query['typologies'])) { foreach($query['typologies'] as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['typologies_id'] ) && $query['edit']['typologies_id'] == $row['id'] )
                                                                                                     || ( isset( $defaults['typologies_id'] ) && $defaults['typologies_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                    <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="makers_id" title="<?php echo lang('lbl_makers_singular'); ?>"><?php echo lang('lbl_makers_singular'); ?>: <i class="icon-asterisk"></i></label>

<?php /*** CONTENido DEPENDiente de TIPOLOGIES :: START ***/ ?>
                                        <div id="container_select-maker" class="controls">
<?php $this->load->view('admin/vehicles/vehicles/select-maker', $this->param); ?>
                                        </div>
<?php /*** CONTENido DEPENDiente de TIPOLOGIES :: END ***/ ?>

                                    </div>
                                    <div class="control-group span2 last">
                                        <label class="control-label" for="chassis_number" title="<?php echo lang('lbl_chassis_number'); ?>"><?php echo lang('lbl_chassis_number'); ?>:</label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12" name="chassis_number" id="chassis_number" type="text" value="<?php if(isset($query['edit']['chassis_number'])) { echo $query['edit']['chassis_number']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_chassis_number'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="control-group span<?php echo $this->session->userdata['user_data']['user_rol'] == FRONTEND_ADMIN_NAME ? '2' : '4'; ?>">
                                        <label class="control-label" for="model" title="<?php echo lang('lbl_model'); ?>"><?php echo lang('lbl_model'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required required-in-skip" name="model" id="model" type="text" value="<?php if(isset($query['edit']['model'])) { echo $query['edit']['model']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_model'); ?>">
                                        </div>
                                    </div>

<?php if( $this->session->userdata['user_data']['user_rol'] == FRONTEND_ADMIN_NAME ) { ?>

                                    <div class="control-group span2">
                                        <label class="control-label" for="auctions_pseudotypes_id" title="<?php echo lang('lbl_pseudotype'); ?>"><?php echo lang('lbl_pseudotype'); ?>: </label>
                                        <div class="controls">
                                            <select<?php // echo $inputs_attrs; ?> disabled="disabled" class="span12 chzn-select" id="auctions_pseudotypes_id" name="auctions_pseudotypes_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_pseudotype'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_pseudotype'); ?></option>
                                                <?php if( isset( $query['pseudotypes'] ) ) { foreach( $query['pseudotypes'] as $row ) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['auctions_pseudotypes_id'] ) && $query['edit']['auctions_pseudotypes_id'] == $row['id'] )
                                                                                                 || ( isset( $defaults['auctions_pseudotypes_id'] ) && $defaults['auctions_pseudotypes_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
<?php } ?>
                                    <div class="control-group span2">
                                        <label class="control-label" for="registration_number" title="<?php echo lang('lbl_registration_number'); ?>"><?php echo lang('lbl_registration_number'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
<?php $data_reg_num_org = isset( $query['edit']['registration_number'] ) && ! empty( $query['edit']['registration_number'] ) ? ' data-reg-num-org="'. $query['edit']['registration_number'] .'"': ''; ?>
                                                <input<?php echo $inputs_attrs . $data_reg_num_org; ?> class="span12 required" name="registration_number" id="registration_number" type="text" value="<?php if(isset($query['edit']['registration_number'])) { echo $query['edit']['registration_number']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_registration_number'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="kilometers" title="<?php echo lang('lbl_kilometers'); ?>"><?php echo lang('lbl_kilometers'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required" name="kilometers" id="kilometers" type="text" value="<?php if(isset($query['edit']['kilometers'])) { echo $query['edit']['kilometers']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_kilometers'); ?>" data-validation="number">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="tax" title="<?php echo lang('lbl_tax'); ?>"><?php echo lang('lbl_tax'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="tax" name="tax" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['tax'] ) && $query['edit']['tax'] == 1 )
                                                                            || ( isset( $defaults['tax'] ) && $defaults['tax'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['tax'] ) && $query['edit']['tax'] == 0 )
                                                                            || ( isset( $defaults['tax'] ) && $defaults['tax'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2 last">
                                        <label class="control-label" for="marketable" title="<?php echo lang('lbl_marketable'); ?>"><?php echo lang('lbl_marketable'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="marketable" name="marketable" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['marketable'] ) && $query['edit']['marketable'] == 1 )
                                                                            || ( isset( $defaults['marketable'] ) && $defaults['marketable'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['marketable'] ) && $query['edit']['marketable'] == 0 )
                                                                            || ( isset( $defaults['marketable'] ) && $defaults['marketable'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <?php /*

                                <div class="row-fluid">
                                    <div class="control-group span4">
                                        <label class="control-label" for="auctions_pseudotypes_id" title="<?php echo lang('lbl_auctions_pseudotype'); ?>"><?php echo lang('lbl_auctions_pseudotype'); ?>: </label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select" id="auctions_auctions_pseudotypes_id" name="auctions_auctions_pseudotypes_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_auctions_pseudotype'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_auctions_pseudotype'); ?></option>
                                                <?php if(isset($query['pseudotypes'])) { foreach($query['pseudotypes'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( isset( $query['edit']['auctions_auctions_pseudotypes_id']) && $query['edit']['auctions_auctions_pseudotypes_id'] == $row['id'] ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="recommendations" title="<?php echo lang('lbl_status_recommendation'); ?>"><?php echo lang('lbl_status_recommendation'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <input<?php echo $inputs_attrs; ?> class="span12" name="recommendations" id="recommendations" type="text" value="<?php if(isset($query['edit']['recommendations'])) { echo $query['edit']['recommendations']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_status_recommendation'); ?>">
                                        </div>
                                    </div>
                                </div>

                                */ ?>

                                <div class="row-fluid">
                                    <div class="control-group span2">
                                        <label class="control-label" for="date_registration" title="<?php echo lang('lbl_date_registration'); ?>"><?php echo lang('lbl_date_registration'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls input-append datetimepicker">
                                            <input<?php echo $inputs_attrs; ?> readonly class="span12 required" name="date_registration" id="date_registration" type="text" value="<?php if(isset($query['edit']['date_registration'])) { echo $query['edit']['date_registration']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_date_registration'); ?>">
                                            <span class="add-on">
                                              <i class="icon-calendar" data-format="dd/MM/yyyy" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="renumbered" title="<?php echo lang('lbl_renumbered'); ?>"><?php echo lang('lbl_renumbered'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="renumbered" name="renumbered" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['renumbered'] ) && $query['edit']['renumbered'] == 1 )
                                                                            || ( isset( $defaults['renumbered'] ) && $defaults['renumbered'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['renumbered'] ) && $query['edit']['renumbered'] == 0 )
                                                                            || ( isset( $defaults['renumbered'] ) && $defaults['renumbered'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="colors_outside_id" title="<?php echo lang('lbl_color_outside'); ?>"><?php echo lang('lbl_color_outside'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="colors_outside_id" name="colors_outside_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_color_outside'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_color_outside'); ?></option>
                                                <?php if(isset($query['colors'])) { foreach($query['colors'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if(isset($query['edit']['colors_outside_id']) && $query['edit']['colors_outside_id'] == $row['id']) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="colors_inside_id" title="<?php echo lang('lbl_color_inside'); ?>"><?php echo lang('lbl_color_inside'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="colors_inside_id" name="colors_inside_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_color_inside'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_color_inside'); ?></option>
                                                <?php if(isset($query['colors'])) { foreach($query['colors_inside'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if(isset($query['edit']['colors_inside_id']) && $query['edit']['colors_inside_id'] == $row['id']) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="fuels_id" title="<?php echo lang('lbl_fuels_singular'); ?>"><?php echo lang('lbl_fuels_singular'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="fuels_id" name="fuels_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_users_singular'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_fuels_singular'); ?></option>
                                                <?php if(isset($query['fuels'])) { foreach($query['fuels'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if(isset($query['edit']['fuels_id']) && $query['edit']['fuels_id'] == $row['id']) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2 last">
                                        <label class="control-label" for="itv_ko" title="<?php echo lang('lbl_itv_ko_alt'); ?>"><?php echo lang('lbl_itv_ko_alt'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="itv_ko" name="itv_ko" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['itv_ko'] ) && $query['edit']['itv_ko'] == 1 )
                                                                            || ( isset( $defaults['itv_ko'] ) && $defaults['itv_ko'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['itv_ko'] ) && $query['edit']['itv_ko'] == 0 )
                                                                            || ( isset( $defaults['itv_ko'] ) && $defaults['itv_ko'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row-fluid">
                                    <div class="control-group span2">
                                        <label class="control-label" for="countries_id" title="<?php echo lang('lbl_countries_singular'); ?>"><?php echo lang('lbl_countries_singular'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="rechargeHTML countries-dependent controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="countries_id" name="countries_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_countries_singular'); ?>"<?php if( isset( $defaults ) ) { echo ' data-default-dependent'; }?>>
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_countries_singular'); ?></option>
                                                <?php if(isset($query['countries'])) { foreach($query['countries'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset($query['edit']['countries_id']) && $query['edit']['countries_id'] == $row['id'] )
                                                                                                || ( isset( $defaults['countries_id'] ) && $defaults['countries_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="locations_id" title="<?php echo lang('lbl_locations_singular'); ?>"><?php echo lang('lbl_locations_singular'); ?>: <i class="icon-asterisk"></i></label>
<?php /*** CONTENido DEPENDiente de COUNTRIES :: START ***/ ?>
                                        <div id="container_select-location" class="controls">
<?php $this->load->view('admin/vehicles/vehicles/select-location', $this->param); ?>
                                        </div>
<?php /*** CONTENido DEPENDiente de COUNTRIES :: END ***/ ?>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="locality" title="<?php echo lang('lbl_locality'); ?>"><?php echo lang('lbl_locality'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required" name="locality" id="locality" type="text" value="<?php if(isset($query['edit']['locality'])) { echo $query['edit']['locality']; } ?>" placeholder="<?php echo lang('lbl_input_female','','lbl_locality'); ?>">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="amount" title="<?php echo lang('lbl_amount'); ?>"><?php echo lang('lbl_amount'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required" name="amount" id="amount" type="text" value="<?php if(isset($query['edit']['amount'])) { echo $query['edit']['amount']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_amount'); ?>" data-validation="number">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="amount_start" title="<?php echo lang('lbl_amount_start'); ?>"><?php echo lang('lbl_amount_start'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required" name="amount_start" id="amount_start" type="text" value="<?php if(isset($query['edit']['amount_start'])) { echo $query['edit']['amount_start']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_amount'); ?>" data-validation="number">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="market_price" title="<?php echo lang('lbl_market_price'); ?>"><?php echo lang('lbl_market_price'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12 required" name="market_price" id="market_price" type="text" value="<?php if(isset($query['edit']['market_price'])) { echo $query['edit']['market_price']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_amount'); ?>" data-validation="number">
                                        </div>
                                    </div>
                                </div>

                                <hr style="margin-top: 10px;">

                                <div class="row-fluid">

                                    <div class="control-group span2">
                                        <label class="control-label" for="sources_id" title="<?php echo lang('lbl_sources_singular'); ?>"><?php echo lang('lbl_sources_singular'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="sources_id" name="sources_id" data-placeholder="<?php echo lang('lbl_select_female','','lbl_sources_singular'); ?>"<?php if( isset( $defaults ) ) { echo ' data-default-dependent'; }?> data-display-disabled>
                                                <option value=""><?php echo lang('lbl_select_female','','lbl_sources_singular'); ?></option>
<?php
    if( isset( $query['sources'] ) )
    {
        $i = 0;
        $source_ant = '';
        foreach( $query['sources'] as $row )
        {
            if( $source_ant != $row['source'] )
            {
                $source_ant = $row['source'];
                if( $i > 0 ) echo '</optgroup>';
                echo '<optgroup label="'. $row['source'] .'">';
            }

            // Option Status                             disabled
            $opt_disabled = empty( $row['visible'] ) ? ' class="opt-disabled"' : '';
?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['sources_id'] ) && $query['edit']['sources_id'] == $row['id'] )
                                                                                                 || ( isset( $defaults['sources_id'] ) && $defaults['sources_id'] == $row['id'] ) ) { echo ' selected'; } echo $opt_disabled; ?>><?php echo $row['name']; ?></option>
<?php
        } echo '</optgroup>';
    }
?>
                                            </select>
                                        </div>
                                    </div>

<?php if( $role_name != 'Comercial' ) { ?>

                                    <div class="control-group span2">
                                        <label class="control-label" for="users_id" title="<?php echo lang('lbl_users_singular'); ?>"><?php echo lang('lbl_seller'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="users_id" name="users_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_users_singular'); ?>" data-prediction="<?php echo BACKEND_PATH_USER_SEARCH; ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_users_singular'); ?></option>
                                                <optgroup label="Opciones encontradas">
                                                <?php if(isset($query['users'])) { foreach($query['users'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['users_id'] ) && $query['edit']['users_id'] == $row['id'] )
                                                                                                    || ( isset( $defaults['users_id'] ) && $defaults['users_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="users_buyer_id" title="<?php echo lang('lbl_users_singular'); ?>"><?php echo lang('lbl_buyer'); ?>:</label>
                                        <div class="rechargeHTML buyers-dependent controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select" id="users_buyer_id" name="users_buyer_id" data-placeholder="<?php echo lang('lbl_select_male','','lbl_users_singular'); ?>" data-prediction="<?php echo BACKEND_PATH_USER_SEARCH; ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_users_singular'); ?></option>
                                                <optgroup label="Opciones encontradas">
                                                <?php if(isset($query['users'])) { foreach($query['users'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if(isset($query['edit']['users_buyer_id']) && $query['edit']['users_buyer_id'] == $row['id']) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="amount_buyer" title="<?php echo lang('lbl_amount_end'); ?>"><?php echo lang('lbl_amount_end'); ?>:</label>
                                        <div class="controls">
                                                <input<?php echo $inputs_attrs; ?> class="span12" name="amount_buyer" id="amount_buyer" type="text" value="<?php if(isset($query['edit']['amount_buyer'])) { echo $query['edit']['amount_buyer']; } ?>" placeholder="<?php echo lang('lbl_input_male','','lbl_amount'); ?>" data-validation="number">
                                        </div>
                                    </div>
                                    <div class="control-group span2">
                                        <label class="control-label" for="users_comercial_id" title="<?php echo lang('lbl_commercial'); ?>"><?php echo lang('lbl_commercial'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="users_comercial_id" name="users_comercial_id" data-placeholder="<?php echo lang('lbl_commercial'); ?>">
                                                <option value=""><?php echo lang('lbl_select_male','','lbl_users_singular'); ?></option>
                                                <?php if(isset($query['comercial_users'])) { foreach($query['comercial_users'] as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if( ( isset( $query['edit']['users_comercial_id'] ) && $query['edit']['users_comercial_id'] == $row['id'] )
                                                                                                    || ( isset( $defaults['users_comercial_id'] ) && $defaults['users_comercial_id'] == $row['id'] ) ) { echo ' selected'; } ?>><?php echo $row['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group span2 last">
                                        <label class="control-label" for="visible" title="<?php echo lang('lbl_visible'); ?>"><?php echo lang('lbl_visible'); ?>: <i class="icon-asterisk"></i></label>
                                        <div class="controls">
                                            <select<?php echo $inputs_attrs; ?> class="span12 chzn-select required" id="visible" name="visible" data-placeholder="<?php echo lang('lbl_select_default'); ?>">
                                                <option value=""><?php echo lang('lbl_select_default'); ?></option>
                                                <option value="1"<?php if( ( isset( $query['edit']['visible'] ) && $query['edit']['visible'] == 1 )
                                                                            || ( isset( $defaults['visible'] ) && $defaults['visible'] == 1 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_yes'); ?></option>
                                                <option value="0"<?php if( ( isset( $query['edit']['visible'] ) && $query['edit']['visible'] == 0 )
                                                                            || ( isset( $defaults['visible'] ) && $defaults['visible'] == 0 ) ) { echo ' selected'; } ?>><?php echo lang('lbl_no'); ?></option>
                                            </select>
                                        </div>
                                    </div> 
<?php } else { ?>
                                    <?php /* <input type="hidden" id="sources_id" name="sources_id" value="<?php if( isset( $query['edit'] ) ) { echo $query['edit']['sources_id']; }
                                                                                                        else if( isset( $defaults['sources_id'] ) ) { echo $defaults['sources_id']; } ?>" /> */ ?>

                                    <input type="hidden" id="users_id" name="users_id" value="<?php if( isset( $query['edit'] ) ) { echo $query['edit']['users_id']; }
                                                                                                    else if( isset( $defaults['users_id'] ) ) { echo $defaults['users_id']; }
                                                                                                    else { echo $this->session->userdata['user_data']['user_id']; } ?>" />

                                    <input type="hidden" id="users_comercial_id" name="users_comercial_id" value="<?php if( isset( $query['edit'] ) ) { echo $query['edit']['users_comercial_id']; }
                                                                                                                        else { echo $this->session->userdata['user_data']['user_id']; } ?>" />

                                    <input type="hidden" id="visible" name="visible" value="<?php if( isset( $query['edit']['visible'] ) ){ echo $query['edit']['visible']; }
                                                                                                                        else{ echo '0'; } ?>" />
<?php } ?>
                                </div>

<?php /*   E N D   */ ?>
                                <div class="form-actions part-comments<?php echo $inputs_attrs; ?>">
                                    <textarea<?php echo $inputs_attrs; ?> class="span12 no_editor" name="part_comments[default][value]" id="part_comments_default_value" rows="1" placeholder="<?php echo lang('lbl_input_male','','lbl_comment'); ?>"></textarea>
                                    <input type="hidden" name="part_comments[default][name]" id="part_comments_default_name" value="" />
                                </div>

    							<div class="form-actions<?php echo $inputs_attrs; ?>" style="margin-top:0;">
    								<button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
    								<button<?php echo $inputs_attrs; ?> type="submit" id="submit" name="submit" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
<?php /* if( isset( $query['edit'] ) && ! empty( $query['edit']['id_appraisal'] ) ) { ?>
                                    <a href="<?php echo BACKEND_PATH_APPRAISAL_UPDATE .'/'. $query['edit']['id_appraisal']; ?>" class="btn-warning"> <button<?php echo $inputs_attrs; ?> type="button" class="btn btn-warning" style="display: block; margin: 0 auto;" title="<?php echo lang('lbl_view') .' '. lang('lbl_appraisals_singular'); ?>"><?php echo lang('lbl_view') .' '. lang('lbl_appraisals_singular'); ?> <i class="icon-share"></i></button> </a>
<?php } */ ?>
<?php
    // To Select which fields will update
    if( isset( $query['edit'] ) && isset( $query['edit']['id_vehicle'] ) )
    {
        $this->load->view( 'admin/common/select_fields_to_update_switch' , $this->param );
    }
?>
    			                </div>
    						</fieldset>
          				</div>
      				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <?php /*** CONTENido DEPENDiente de TIPOLOGIES :: START ***/ ?>
    <div id="container_typologies-dependent-s" class="controls no-print">
<?php
        $this->param['data']['view_only_specific'] = array( 'Cuestionario Interno' );
        $this->load->view('admin/vehicles/vehicles/typologies-dependent', $this->param);
        unset( $this->param['data']['view_only_specific'] );
?>
    </div>
	<?php /*** CONTENido DEPENDiente de TIPOLOGIES :: END ***/ ?>

    <div id="container_comments" class="controls no-print<?php if( $role_name != FRONTEND_ADMIN_NAME ) { echo ' hidden'; }?>">
        <div class="row-fluid">
            <div class="span12 column" id="col-comments">
                <div class="box" id="box-comments">
                    <h4 class="box-header round-top"><?php echo lang('lbl_label') .' '. strtolower( lang('lbl_buyer') ); ?>
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
                                <fieldset>
                                    <div class="row-fluid">
                                        <div class="control-group span12">
                                            <label class="control-label" for="label" title="<?php echo lang('lbl_label'); ?>"><?php echo lang('lbl_label') .' '. strtolower( lang('lbl_buyer') ); ?>:</label>
<?php /*** CONTENido DEPENDiente de BUYER :: START ***/ ?>
                                            <div id="container_textarea-label" class="controls">
<?php $this->load->view('admin/vehicles/vehicles/textarea-label', $this->param); ?>
                                            </div>
<?php /*** CONTENido DEPENDiente de BUYER :: END ***/ ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions<?php echo $inputs_attrs; ?>">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if( isset( $query['edit'] ) ) { ?>

    <div id="container_comments_list" class="controls no-print">
        <div class="row-fluid"> 
            <div class="span12 column" id="col-comments">
                <div class="box" id="box-comments">
                    <h4 class="box-header round-top"><?php echo lang('lbl_comment_plural'); ?>
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
<?php if( isset( $query['c_list'] ) ) { ?>
                                <div id="c_list">
<?php   foreach( $query['c_list'] as $list_row ) { ?>
                                    <div>
                                        <span class="label label-info"><?php echo $list_row->date_insert_format; ?></span> <b><?php echo $list_row->user_name; ?></b> <em><?php echo $list_row->address; ?></em>
                                        <div>
                                            <p><?php echo $list_row->comment; ?></p>
                                        </div>
                                    </div>
<?php   } ?>
                                </div>
<?php } ?>
                                <div class="form-actions<?php echo $inputs_attrs; ?>">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php /*<div id="container_claims_list" class="controls no-print">
        <div class="row-fluid">
            <div class="span12 column" id="col-claims">
                <div class="box" id="box-claims">
                    <h4 class="box-header round-top"><?php echo lang('lbl_claim_plural'); ?>
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
<?php if( isset( $query['claims_list'] ) ) { ?>
                                <div id="claims_list" class="c_list">
<?php   foreach( $query['claims_list'] as $list_row ) { ?>
                                    <div>
                                        <span class="label label-<?php echo $list_row->status_class; ?>"><?php echo $list_row->date_insert_format; ?></span> <a target="_blank" href="<?php echo BACKEND_PATH_USER_UPDATE .'/'. $list_row->users_id; ?>" title="Ir a #<?php echo $list_row->user; ?>"> <i class="icon-share"></i> #<?php echo $list_row->user; ?></a>
                                        <div>
                                            <p><?php echo $list_row->observations; ?></p>
                                        </div>
                                    </div>
<?php   } ?>
                                </div>
<?php } ?>
                                <div class="form-actions<?php echo $inputs_attrs; ?>">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> */ ?>

<?php } ?>

<?php /*

    <div id="container_comments" class="controls no-print">
        <div class="row-fluid">
            <div class="span12 column" id="col-comments">
                <div class="box" id="box-comments">
                    <h4 class="box-header round-top"><?php echo lang('lbl_comments_plural'); ?>
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
                                <fieldset>
                                    <div class="row-fluid">
                                        <div class="control-group span<?php echo $role_name != 'Comercial' ? '6' : '12'; ?>">
                                            <label class="control-label" for="label" title="<?php echo lang('lbl_label'); ?>"><?php echo lang('lbl_comments_plural'); ?>:</label>
                                            <div class="controls">
                                                <div class="row-fluid">
                                                	<textarea<?php echo $inputs_attrs; ?> class="span12 html_editor_on_simple" name="observations" id="observations" rows="3" placeholder="<?php echo lang('lbl_input_male','','lbl_observations'); ?>"><?php if(isset($query['edit']['observations'])) { echo $query['edit']['observations']; } ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group span6<?php if( $role_name != FRONTEND_ADMIN_NAME ) { echo ' hidden'; }?>">
                                            <label class="control-label" for="label" title="<?php echo lang('lbl_label'); ?>"><?php echo lang('lbl_label') .' '. strtolower( lang('lbl_buyer') ); ?>:</label>
<?php / *** CONTENido DEPENDiente de BUYER :: START *** / ?>
                                            <div id="container_textarea-label" class="controls">
<?php $this->load->view('admin/vehicles/vehicles/textarea-label', $this->param); ?>
                                            </div>
<?php / *** CONTENido DEPENDiente de BUYER :: END *** / ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions<?php echo $inputs_attrs; ?>">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 */ ?>

    <div id="container_originals_org" class="controls no-print">
        <div class="row-fluid">
            <div class="span12 column" id="col-images-org">
                <div class="box" id="box-images-org">
                    <h4 class="box-header round-top"><?php echo lang('lbl_photos'); ?> originales
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
                                <fieldset id="upload-img-org">
                                    <div class="row-fluid">
                                        <div class="control-group span12">
                                            <div class="controls">
                                                <div class="row-fluid fileupload-buttonbar">
                                                    <div class="span7">
                                                        <span class="btn btn-success fileinput-button<?php echo $inputs_attrs; ?>" data-type="img-org">
                                                            <span><i class="icon-plus icon-white"></i> Examinar&hellip;</span>
                                                            <input<?php echo $inputs_attrs; ?> id="file_upload_img_org" type="file" name="file_upload_img" multiple>
                                                            <input<?php echo $inputs_attrs; ?> id="order_upload_img_org" type="hidden" name="order_upload_img">
                                                        </span>
    <?php if( empty( $inputs_attrs ) ) { ?>
                                                        <button<?php echo $inputs_attrs; ?> type="select" class="btn btn-danger choose">
                                                            <i class="icon-list icon-white"></i>
                                                        </button>
                                                        <button<?php echo $inputs_attrs; ?> type="button" class="btn btn-danger delete">
                                                            <i class="icon-trash icon-white"></i> <?php echo lang('lbl_delete'); ?>
                                                        </button>
    <?php } ?>
    <?php if( isset( $query['edit'] ) /* && $query['edit']['images'] > 0 */ ) { ?>
                                                        <a href="<?php echo BACKEND_PATH_VEHICLE_DOWNLOAD .'/'. $query['edit']['id_vehicle'] .'?type=org'; ?>" title="<?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?>" class="btn btn-info download">
                                                            <i class="icon-download icon-white"></i> <?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?>
                                                        </a>
    <?php } ?>
                                                        <button<?php echo $inputs_attrs; ?> type="button" class="btn btn-warning regenerate">
                                                            <i class="icon-refresh icon-white"></i> <?php echo lang('lbl_regenerate_thumbs'); ?>
                                                        </button>
                                                    </div>
                                                    <div class="span5">
                                                        <div id="progress_img_org" class="progress progress-success progress-striped progress-lg active fade">
                                                            <div class="bar bar-lg" style="width:0%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fileupload-loading"></div>
                                                <legend><?php echo $this->lang->line('lbl_fotografia_vehic'); ?></legend>
                                                <div class="row-fluid">
    <?php if( empty( $inputs_attrs ) ) { ?>
                                                    <div class="dropzone" class="fade well">Para subir las fotografías, arrástralas y suéltalas aquí&hellip;</div>
    <?php } ?>
                                                    <div class="files<?php echo $inputs_attrs; ?>" data-toggle="modal-gallery" data-target="#modal-gallery_org"></div>
                                                </div>
                                                <div id="modal-gallery_org" class="modal modal-gallery hide fade">
                                                    <div class="modal-header">
                                                        <a class="close" data-dismiss="modal">&times;</a>
                                                        <h3 class="modal-title"></h3>
                                                    </div>
                                                    <div class="modal-body"><div class="modal-image"></div>
                                                </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Anterior</a>
                                                        <a class="btn btn-primary modal-next">Siguiente <i class="icon-arrow-right icon-white"></i></a>
                                                        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Presentación</a>
                                                        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Descargar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-actions part-comments<?php echo $inputs_attrs; ?>">
                                    <textarea<?php echo $inputs_attrs; ?> class="span12 no_editor" name="part_comments[images][value]" id="part_comments_images_value_org" rows="1" placeholder="<?php echo lang('lbl_input_male','','lbl_comment'); ?>"></textarea>
                                    <input type="hidden" name="part_comments[images][name]" id="part_comments_images_name_org" value="Imágenes" />
                                </div>

                                <div class="form-actions<?php echo $inputs_attrs; ?>" style="margin-top:0;">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" id="submit-images-org" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if( $role_name == FRONTEND_ADMIN_NAME || $role_name == FRONTEND_SUPPORT_NAME ) { ?>

    <div id="container_images" class="controls no-print<?php if( $role_name != FRONTEND_ADMIN_NAME && $role_name != FRONTEND_SUPPORT_NAME ) { echo ' hidden'; } ?>">
        <div class="row-fluid">
            <div class="span12 column" id="col-images">
                <div class="box" id="box-images">
                    <h4 class="box-header round-top"><?php echo lang('lbl_photos'); ?> web
                        <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                    </h4>
                    <div class="box-container-toggle">
                        <div class="box-content">
                            <div class="row-fluid">
                                <fieldset id="upload-img">
                                    <div class="row-fluid">
                                        <div class="control-group span12">
                                            <div class="controls">
                                                <div class="row-fluid fileupload-buttonbar">
                                                    <div class="span7">
                                                        <span class="btn btn-success fileinput-button<?php echo $inputs_attrs; ?>" data-type="img">
                                                            <span><i class="icon-plus icon-white"></i> Examinar&hellip;</span>
                                                            <input<?php echo $inputs_attrs; ?> id="file_upload_img" type="file" name="file_upload_img" multiple>
                                                            <input<?php echo $inputs_attrs; ?> id="order_upload_img" type="hidden" name="order_upload_img">
                                                        </span>
    <?php if( empty( $inputs_attrs ) ) { ?>
                                                        <button<?php echo $inputs_attrs; ?> type="select" class="btn btn-danger choose">
                                                            <i class="icon-list icon-white"></i>
                                                        </button>
                                                        <button<?php echo $inputs_attrs; ?> type="button" class="btn btn-danger delete">
                                                            <i class="icon-trash icon-white"></i> <?php echo lang('lbl_delete'); ?>
                                                        </button>
    <?php } ?>
    <?php if( isset( $query['edit'] ) /* && $query['edit']['images'] > 0 */ ) { ?>

                                                        <a href="<?php echo BACKEND_PATH_VEHICLE_DOWNLOAD .'/'. $query['edit']['id_vehicle']; ?>" title="<?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?>" class="btn btn-info download">
                                                            <i class="icon-download icon-white"></i> <?php echo lang('lbl_download') .' '. mb_strtolower( lang('lbl_images') ); ?>
                                                        </a>
    <?php } ?>
                                                        <button<?php echo $inputs_attrs; ?> type="button" class="btn btn-warning regenerate">
                                                            <i class="icon-refresh icon-white"></i> <?php echo lang('lbl_regenerate_thumbs'); ?>
                                                        </button>
                                                    </div>
                                                    <div class="span5">
                                                        <div id="progress_img" class="progress progress-success progress-striped progress-lg active fade">
                                                            <div class="bar bar-lg" style="width:0%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fileupload-loading"></div>
                                                <legend><?php echo $this->lang->line('lbl_fotografia_vehic'); ?></legend>
                                                <div class="row-fluid">
    <?php if( empty( $inputs_attrs ) ) { ?>
                                                	<div class="dropzone" class="fade well">Para subir las fotografías, arrástralas y suéltalas aquí&hellip;</div>
    <?php } ?>
                                                    <div class="files<?php echo $inputs_attrs; ?>" data-toggle="modal-gallery" data-target="#modal-gallery"></div>
                                                </div>
                                                <div id="modal-gallery" class="modal modal-gallery hide fade">
                                                    <div class="modal-header">
                                                        <a class="close" data-dismiss="modal">&times;</a>
                                                        <h3 class="modal-title"></h3>
                                                    </div>
                                                    <div class="modal-body"><div class="modal-image"></div>
                                                </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Anterior</a>
                                                        <a class="btn btn-primary modal-next">Siguiente <i class="icon-arrow-right icon-white"></i></a>
                                                        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Presentación</a>
                                                        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Descargar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-actions part-comments<?php echo $inputs_attrs; ?>">
                                    <textarea<?php echo $inputs_attrs; ?> class="span12 no_editor" name="part_comments[images][value]" id="part_comments_images_value" rows="1" placeholder="<?php echo lang('lbl_input_male','','lbl_comment'); ?>"></textarea>
                                    <input type="hidden" name="part_comments[images][name]" id="part_comments_images_name" value="Imágenes" />
                                </div>

                                <div class="form-actions<?php echo $inputs_attrs; ?>" style="margin-top:0;">
                                    <button<?php echo $inputs_attrs; ?> type="reset" class="btn pull-left" title="<?php echo lang('lbl_cancel'); ?>"><?php echo lang('lbl_cancel'); ?></button>
                                    <button<?php echo $inputs_attrs; ?> type="submit" id="submit-images" name="submit[]" value="1" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

    <?php /*** CONTENido DEPENDiente de TIPOLOGIES :: START ***/ ?>
    <div id="container_typologies-dependent" class="controls no-print">
<?php $this->load->view( 'admin/vehicles/vehicles/typologies-dependent', $this->param ); ?>
    </div>
	<?php /*** CONTENido DEPENDiente de TIPOLOGIES :: END ***/ ?>

   
</form>

<?php if( isset( $query['edit'] ) ) { ?>

<form id="frm_main_prints" name="frm_main" action="<?php echo BACKEND_PATH_VEHICLE_PRINTS .'/'. $query['edit']['id_vehicle']; ?>" method="post" enctype="multipart/form-data">
    <div class="row-fluid">
		<div class="span12 column">
			<div class="box">
				<h4 class="box-header round-top"><?php echo lang('lbl_prints_plural'); ?>
                    <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                </h4>
				<div class="box-container-toggle">
					<div class="box-content">
                        <fieldset id="prints">
                            <table class="table table-striped table-bordered table-condensed datatable">
	                          <thead data-filter="<?php echo lang('lbl_field_filter'); ?>">
	                              <tr>
									  <th rel="filter" id="id_print" class="identifier"><?php echo lang('lbl_identifier'); ?></th>
									  <th rel="filter" id="date_insert" class="date"><?php echo lang('lbl_date_insert'); ?></th>
									  <th rel="filter" id="reference"><?php echo lang('lbl_reference'); ?></th>
									  <th rel="filter" id="vehicle"><?php echo lang('lbl_vehicles_singular'); ?></th>
									  <th rel="filter" id="seller"><?php echo lang('lbl_seller'); ?></th>
                                      <th rel="filter" id="buyer"><?php echo lang('lbl_buyer'); ?></th>
                                      <th rel="filter" id="type"><?php echo lang('lbl_types_singular'); ?></th>
                                      <th rel="filter" id="status"><?php echo lang('lbl_status_singular'); ?></th>
	                                  <th id="actions"><?php echo lang('lbl_actions'); ?></th>
	                              </tr>
	                          </thead>
	                          <tbody>

	                          </tbody>
	                        </table>
                        </fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php       if( isset( $total_claims ) && $total_claims > 0 ) { ?>

<form id="frm_main_claims" name="frm_main" action="<?php echo BACKEND_PATH_VEHICLE_CLAIMS .'/'. $query['edit']['id_vehicle']; ?>" method="post" enctype="multipart/form-data">
    <div class="row-fluid">
		<div class="span12 column">
			<div class="box">
				<h4 class="box-header round-top"><?php echo lang('lbl_claims_plural'); ?>
                    <a class="box-btn" title="toggle"><i class="icon-minus"></i></a>
                </h4>
				<div class="box-container-toggle">
					<div class="box-content">
                        <fieldset id="claims">
                            <table class="table table-striped table-bordered table-condensed datatable">
	                          <thead data-filter="<?php echo lang('lbl_field_filter'); ?>">
	                              <tr>
									  <th rel="filter" id="id_claim" class="identifier"><?php echo lang('lbl_identifier'); ?></th>
									  <th rel="filter" id="observations"><?php echo lang('lbl_observations'); ?></th>
									  <th rel="filter" id="date_insert" class="date"><?php echo lang('lbl_date_insert'); ?></th>
									  <th rel="filter" id="user"><?php echo lang('lbl_users_singular'); ?></th>
                                      <th rel="filter" id="status"><?php echo lang('lbl_status_singular'); ?></th>
	                                  <th id="actions"><?php echo lang('lbl_actions'); ?></th>
	                              </tr>
	                          </thead>
	                          <tbody>

	                          </tbody>
	                        </table>
                        </fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php       } ?>

<?php } ?>

<?php if( isset( $defaults ) ) { ?>
<script>
    /* Global vars */
    var get_defaults = true;
</script>
<?php } ?>

<?php if( isset( $skip_required_on_save ) && $skip_required_on_save == TRUE ) { ?>
<script>
    /* Global vars */
    var skip_required_on_save = true;
</script>
<?php } ?>

<?php if( isset( $disable_status_if_emtpy_fields ) && $disable_status_if_emtpy_fields == TRUE && isset( $query['edit'] ) ) { ?>
<script>
    /* Global vars */
    var disable_status_if_emtpy_fields = true;
</script>
<?php } ?>

<!-- Add contact -->
<div id="container_add-contact" class="controls">

    <!-- Modal Add Vehicle -->
    <div id="add-contact" class="modal hide fade" style="width: 98%; top: 60px; left: 0; margin: auto 1%;" tabindex="-1" role="dialog" aria-labelledby="add-contactLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="add-vehicleLabel">
                <span data-action="insert"<?php if( isset( $query['edit'] ) && ! empty( $query['edit']['contacts_id'] ) ){ echo ' class="hide"'; } ?>><?php echo lang( 'lbl_insert_register' , '' , 'lbl_contacts_singular' ); ?></span>
                <span data-action="update"<?php if( ! isset( $query['edit'] ) || empty( $query['edit']['contacts_id'] ) ){ echo ' class="hide"'; } ?>><?php echo lang( 'lbl_update_register' , '' , 'lbl_contacts_singular' ); ?></span>
                <?php echo lang( 'lbl_to_the_male' , '' , 'lbl_vehicles_singular' ); ?>
            </h3>
        </div>
        <div class="modal-body" data-url-insert="<?php echo BACKEND_PATH_CONTACT_INSERT; ?>" data-url-update="<?php echo BACKEND_PATH_CONTACT_UPDATE; ?>">

        </div>
        <div class="modal-footer">
            <button class="btn pull-left" data-dismiss="modal" aria-hidden="true" title="<?php echo lang('lbl_close'); ?>"><?php echo lang('lbl_close'); ?></button>
            <button type="button" class="btn btn-primary pull-right" title="<?php echo lang('lbl_save'); ?>"><?php echo lang('lbl_save'); ?></button>
            <button type="button" class="btn btn-danger<?php if( ! isset( $query['edit'] ) || empty( $query['edit']['contacts_id'] ) ){ echo ' disabled'; } ?>" title="<?php echo lang('lbl_quit'); ?>" style="display: block; margin: 0 auto;"><?php echo lang('lbl_quit'); ?></button>
        </div>
    </div>
</div>


<!-- Change status -->
<div id="html_change_status" class="hidden">
    <div class="row-fluid">
        <div class="control-group">

            <label class="control-label" for="status_id" title="<?php echo lang('lbl_status'); ?>"><?php echo lang('lbl_status'); ?>: <i class="icon-asterisk"></i></label>

            <?php if( isset( $prints['status'] ) ) { foreach( $prints['status'] as $row ) { ?>

            <div class="row-fluid">
                <div class="control-group span12" style="margin-bottom: 0;">
                    <label class="control-label" title="<?php echo lang('lbl_status'); ?>">
                        <input type="radio" name="status" value="<?php echo isset( $row['id'] ) ? $row['id'] : ''; ?>" class="pull-left">&nbsp;
                        <span class="label label-<?php echo $row['class']; ?>" style="display: inline-block; margin-left: 5px; padding: 2px 5px; font-size: 80%;"><?php echo $row['name']; ?></span>
                    </label>
                </div>
            </div>

            <?php } } ?>

        </div>
    </div>
</div>
