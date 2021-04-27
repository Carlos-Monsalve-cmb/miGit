<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_grupos extends Admin_Controller {


    function __construct()
    {
        parent::__construct();

        // View vars
        $this->concepts['singular']  = 'users_group';
        $this->concepts['plural']    = 'users_groups';

        $this->render['concept_singular']   = $this->param['concept_singular']  = $this->concepts['singular'];
        $this->render['concept_plural']     = $this->param['concept_plural']    = $this->concepts['plural'];

        // Check Access Permissions to controller
        $this->check_permission('ACCESS');

        // Buttons to show
        $this->render['action_buttons']['size']     = $this->param['action_buttons']['size']    = $this->set_view_buttons();
        $this->render['action_buttons']['list']     = $this->param['action_buttons']['list']    = BACKEND_PATH_USERS_GROUP;
        $this->render['action_buttons']['insert']   = $this->param['action_buttons']['insert']  = BACKEND_PATH_USERS_GROUP_INSERT;
        $this->render['action_buttons']['update']   = $this->param['action_buttons']['update']  = BACKEND_PATH_USERS_GROUP_UPDATE;
        $this->render['action_buttons']['delete']   = $this->param['action_buttons']['delete']  = BACKEND_PATH_USERS_GROUP_DELETE;

        // Models
        $this->load->model('admin/users_groups_model');
        $this->load->model('admin/layouts_model');
        $this->load->model('admin/users_model');

        // Vars
        $this->data['id_language'] = $this->session->userdata['user_data']['id_language'];

        // Query
        $this->param['query'] = array();
        $result = $this->layouts_model->select();
        if($result)
        {
            foreach($result as $row)
            {
                $this->param['query']['layouts'][] = array(
                    'id' => $row->id_layout,
                    'name' => $row->name
                );
            }
        }
    }


	public function index()
	{
    	$this->listar();
	}

	public function agregar()
	{
        // Check Access Permissions to method
        $this->check_permission('create');

        // Submit
        if( $this->input->post('submit') )
        {

            // Vars
            $users_id           = $this->input->post('users_id');
            $users_comercial_id = $this->input->post('users_comercial_id');
            $observations       = $this->input->post('observations');

            // echo (
            //     'USERS_ID = '.$users_id.'<br>'.
            //     'USERS_COMERCIAL_ID = '.$users_comercial_id.'<br>'.
            //     'OBSERVATIONS = '.$observations);

            if( !$this->validation_rules() )
            {
                // Error
                $this->session->set_flashdata('message',
                    array(
                        'content' => lang('lbl_insert_error_male','','lbl_users_plural'),
                        'type' => 'error'
                ));

                redirect(BACKEND_PATH_USERS_GROUP_INSERT , 'refresh');
            }
            else
            {
                // Function Params
                $query_params = array(
                    'users_id'           => $users_id,
                    'users_comercial_id' => $users_comercial_id,
                    'observations'       => $observations             
                );
                $result = $this->users_groups_model->insert( $query_params );

                if( $result )
                {
                    // Comment
                    $comment = substr( lang( 'lbl_insert_success_male' , '' , 'lbl_'. $this->concepts['plural'] .'_singular' ) , 0 , -1 ) . lang( 'lbl_by' , '' ) .'<b>'. $this->session->userdata['user_data']['login_name'] .'</b>.';
                    $comment = substr_replace( $comment , ' #'. $result , strrpos( $comment , '&quot;') , 0 );

                    // Compare changes
                    $comment .= $this->add_reg_changes_to_comment( FALSE , $query_params );

                    // Function Params
                    $query_params = array(
                        'users_id'      => NULL ,
                        'concept'       => $this->concepts['singular'] ,
                        'id_field'      => $result ,
                        'comment'       => $comment ,
                        'ip_address'    => $this->input->ip_address() ,
                        'action'        => 'insert'
                    );
                    $comment_result = $this->comments_model->insert( $query_params );

                    // Success
                    $this->session->set_flashdata('message',
                        array(
                            'content' => lang('lbl_insert_success_male_singular','','lbl_users_group_singular'),
                            'type' => 'success'
                    ));

                    // Redirect
                    redirect(BACKEND_PATH_USERS_GROUP, 'refresh');
                }
                else
                {
                    // Error
                    $this->session->set_flashdata('message',
                        array(
                            'content' => lang('lbl_insert_success_male_singular','','lbl_users_group_singular'),
                            'type' => 'error'
                    ));

                    // Redirect
                    redirect(BACKEND_PATH_USERS_GROUP, 'refresh');
                }
            }

        }
        // Default
        else
        {
            $roles_manager = $this->users_groups_model->search_for_roles( array('rol_id' => 5) );
            $roles_comercial = $this->users_groups_model->search_for_roles( array('rol_id' => 3) );

            $this->param['usersgroups']['manager'] = $roles_manager;
            $this->param['usersgroups']['comercial'] = $roles_comercial;

            // Page
            $this->param['page'] = 'USERS_GROUP_DETAIL';

            // Render
            $this->render['bread_active'] = lang('lbl_insert');
            $this->render['bread_history_link'] = array('/admin','/admin/usuarios_grupos');
            $this->render['bread_history_name'] = array(lang('lbl_admin'), lang( 'lbl_users_group_plural' ));
            $this->render['form'] = $this-> load -> view ('admin/users/detail_groups', $this->param, TRUE);

            // Function Params
            $query_params = array(
                'content'       => VIEW_PATH_CONTENT  ,
                'data'          => $this->render 
            );
            $this->load_view( $query_params );
            // $this->load_view(VIEW_PATH_CONTENT,$this->render);
        }

	}


  	public function editar()
	{
		// Vars
		$id_users_group = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $this->input->post('id_users_group');

        //echo ($id_users_group);

        // Section
        if( $id_users_group )
        {
            // Function Params
            $function_params = array( 'params' => array( 'id_users_group' => $id_users_group ) );
            $result = $this->users_groups_model->select( $function_params );
            //var_dump($result);
            if( $result )
            {
                foreach($result as $row)
                {
                    $this->param['query']['edit'] = array(
                        'id_users_group'    => $row->id_users_group,
                        'users_id'          => $row->users_id,
                        'users_comercial_id'=> $row->users_comercial_id,
                        'date_insert'       => $row->date_insert,
                        'date_edit'         => $row->date_edit,
                        'observations'      => $row->observations,
                        'email'             => $row->email,
                        'name'              => $row->name,
                        'comercial'         => $row->comercial
                    );
                }
            }

            // Error
            else
            {
                $this->session->set_flashdata( 'message' , array( 'type' => 'error' , 'content' => lang( 'lbl_update_warning_male' , '' , 'lbl_'. $this->concepts['plural']  .'_singular' ) ) );
                redirect( BACKEND_PATH_USERS_GROUP , 'refresh' );
            }

            // Submit
            if( $this->input->post('submit') )
            {

                $observations=$this->input->post('observations');

                if( ! $this->validation_rules() )
                {
                    // Error
                    $this->session->set_flashdata('message',
                        array(
                            'content' => lang('lbl_update_error_male','','lbl_users_group_plural'),
                            'type' => 'error'
                    ));

                    redirect(BACKEND_PATH_USERS_GROUP_UPDATE .'/'. $id_users_group, 'refresh');
                }
                else
                {
                    // Function Params
                    $function_params = array(
                        'id_users_group'        => $id_users_group,
                        'observations'          => $observations
                    );
                    $result = $this->users_groups_model->update( $function_params );

                    if( $result === TRUE )
                    {
                        // Comment
                        $gender = 'male';
                        $comment = substr( lang( 'lbl_update_success_'. $gender , '' , 'lbl_'. $this->concepts['plural'] .'_singular' ) , 0 , -1 ) . lang( 'lbl_by' , '' ) .'<b>'. $this->session->userdata['user_data']['login_name'] .'</b>.';
                        $comment = substr_replace( $comment , ' #'. $id_users_group , strrpos( $comment , '&quot;') , 0 );

                        // Compare changes
                        $comment .= $this->add_reg_changes_to_comment( $this->param['query']['edit'] , $function_params );

                        // Function Params
                        $function_params = array(
                            'id_users_group'      => NULL ,
                            'concept'       => $this->concepts['singular'] ,
                            'id_field'      => $id_users_group ,
                            'comment'       => $comment ,
                            'ip_address'    => $this->input->ip_address() ,
                            'action'        => 'update'
                        );
                        $comment_result = $this->comments_model->insert( $function_params );

                        // Check if the content has been changed
                        if( ! empty( $content_changed ) )
                        {
                            $result = $this->users_model->reset_use_terms();

                            if( $result === TRUE )
                            {
                                $msn_user_result = ' '. lang('lbl_update_success_male_p','','lbl_users_group_plural');
                            }
                            else
                            {
                                $msn_user_result = ' '. lang('lbl_update_error_male_p','','lbl_users_group_plural');
                            }
                        }
                        else
                        {
                            $msn_user_result = '';
                        }

                        // Success
                        $this->session->set_flashdata('message',
                            array(
                                'content' => lang('lbl_update_success_male','','lbl_users_group_plural') . $msn_user_result,
                                'type' => 'success'
                        ));
                    }
                    else
                    {
                        // Error
                        $this->session->set_flashdata('message',
                            array(
                                'content' => lang('lbl_update_error_male','','lbl_users_group_plural'),
                                'type' => 'error'
                        ));
                    }

                    redirect( BACKEND_PATH_USERS_GROUP_UPDATE .'/'. $id_users_group , 'refresh');
                }
            }
            // Edit
            else
            {
                // Page
                $this->param['page'] = 'USERS_GROUP_DETAIL';

                // Render
                $this->render['bread_active'] = lang('lbl_update');
                $this->render['bread_history_link'] = array('/admin','/admin/usuarios_grupos');
                $this->render['bread_history_name'] = array(lang('lbl_admin'), lang('lbl_users_group_plural'));
                $this->render['form'] = $this->load->view('admin/users/detail_groups', $this->param, TRUE);

                //var_dump($function_params);

                // Function Params
                $function_params = array(
                    'content'       => VIEW_PATH_CONTENT  ,
                    'data'          => $this->render
                );
                $this->load_view( $function_params );
                // $this->load_view(VIEW_PATH_CONTENT, $this->render);
            }
        }
        else {
            // Warning
            $this->session->set_flashdata('message',
                array(
                    'content' => lang('lbl_update_warning_male','','lbl_users_groups_singular'),
                    'type' => 'warning'
            ));

            redirect(BACKEND_PATH_USERS_GROUP, 'refresh');
        }

	}


	public function borrar()
	{
        // Check Access Permissions to method
        $this->check_permission('delete');

        // Vars
        $checkbox = $this->input->post('checkbox');

        if( $checkbox )
        {
            $result = $this->users_groups_model->delete($checkbox);
            if($result === TRUE)
            {
                // Success
                $this->session->set_flashdata('message',
                    array(
                        'content' => lang('lbl_delete_success_male','','lbl_users_groups_plural'),
                        'type' => 'success'
                ));
            }
            else
            {
                // Error
                $this->session->set_flashdata('message',
                    array(
                        'content' => lang('lbl_delete_error_male','','lbl_users_groups_plural'),
                        'type' => 'error'
                ));
            }
        }
        else
        {
            // Warning
            $this->session->set_flashdata('message',
                array(
                    'content' => lang('lbl_delete_warning_male','','lbl_users_groups_plural'),
                    'type' => 'warning'
            ));
        }

		redirect(BACKEND_PATH_USERS_GROUP, 'refresh');

	}

    private function listar()
    {
		// Ajax
		if( IS_AJAX )
		{
			// Vars
			$sEcho = $this->input->post('sEcho');
			$search = $this->input->post('sSearch');
			$filter = $this->input->post('sFilter');
	        $limit = $this->input->post('iDisplayLength');
			$offset = $this->input->post('iDisplayStart');
			$iSort = $this->input->post('iSortCol_0');
			$sSort = ( $iSort ) ? $this->input->post('sSortDir_0') : FALSE;
			$mData = ( $iSort ) ? $this->input->post('mDataProp_'. $iSort) : FALSE;

            $advanced_type = $this->input->post('advanced_type') ? $this->input->post('advanced_type') : FALSE;                                         /* print_r( $advanced_type ); */
            $advanced_filter = $this->input->post('advanced_filter') ? $this->input->post('advanced_filter') : FALSE;                                   /* print_r( $advanced_filter ); */
            $advanced_operator = $this->input->post('advanced_operator') ? $this->input->post('advanced_operator') : FALSE;                             /* print_r( $advanced_operator ); */

            // Delete Empty
            if( ! empty( $advanced_filter ) && is_array( $advanced_filter ) )
            {
                foreach( $advanced_filter as $key => $value )
                {
                    if( $value == '' )
                    {
                        unset( $advanced_type[ $key ] , $advanced_filter[ $key ] , $advanced_operator[ $key ] );
                    }
                }
            }

			// Order By
			$order_by = ( $iSort ) ? $mData .' '. $sSort : FALSE;

			// Total
			if( $search || ( $advanced_filter !== FALSE && count( $advanced_filter ) > 0 ) )
			{
				$total_all = $this->users_groups_model->count();
                $total_all = $total_all[0]->count;

                //var_dump($total_all);
                //var_dump($this->db->last_query());
			}
            else { $total_all = FALSE; }

			// Function Params
            $function_params = array(
                'advanced_type' => $advanced_type ,
                'advanced_filter' => $advanced_filter ,
                'advanced_operator' => $advanced_operator ,
                'search' => $search ,
                'filter' => $filter ,
                'return_to_select' => 'query' ,
            );

            //var_dump($function_params);

            $total = $this->users_groups_model->count( $function_params );
            // $total = $this->sections_model->count($search, $filter);

            // Return to select
            $return_to_select = str_replace( "\n" , ' ' , $total['last_query'] );
            $total = count( $total['result'] );

            // If results
            if( $total > 0 )
            {

                //var_dump($total);
                // Function Params
                $function_params = array(
                    // 'advanced_type' => $advanced_type ,
                    // 'advanced_filter' => $advanced_filter ,
                    // 'advanced_operator' => $advanced_operator ,
                    'params'        => array( 'id_users_group' => ( $total_all !== FALSE ? $return_to_select : FALSE ) ) ,
                    'order_by'      => $order_by    ,
                    'limit'         => $limit       ,
                    'offset'        => $offset      ,
                    // 'search'        => $search      ,
                    // 'filter'        => $filter      ,
                    // 'languages_id'  => $this->data['id_language']
                );


                $result = $this->users_groups_model->select( $function_params );

                //var_dump($result);

                if($result)
                {
                    foreach($result as $row)
                    {
                        $this->param['query']['list'][] = array(
                            'checkbox'			=> '<label><input class="uniform_on" name="checkbox[]" type="checkbox" value="'. $row->id_users_group .'"></label>',
                            'id_users_group' 	=> $row->id_users_group,
                            'date_insert' 		=> '<span class="label label-info">'. $row->date_insert .'</span>',
                            'date_edit' 		=> '<span class="label label-info">'. $row->date_edit .'</span>',
                            'manager'           => '<a href="'. BACKEND_PATH_USER_UPDATE .'/'. $row->users_id .'" title="'. $row->manager .'">'. $row->manager .'</a>',
                            'comercial'         => '<a href="'. BACKEND_PATH_USER_UPDATE .'/'. $row->users_comercial_id .'" title="'. $row->comercial .'">'. $row->comercial .'</a>',
                            'email'             => $row->email,
                            'users_comercial_id'=> $row->users_comercial_id ,
                            'observations' 		=> ( $row->observations ) ? character_limiter(strip_tags($row->observations), 150) : lang('lbl_empty'),
                            'rol_name'          => $row->rol_name,
                            'actions' 		    => '<a href="'. BACKEND_PATH_USERS_GROUP_UPDATE .'/'. $row->id_users_group .'" title="'. lang('lbl_users_groups_singular') .'">'
                                                        .'<div class="btn btn-mini btn-block btn-warning">'
                                                            .'<div><i class="icon-arrow-down icon-white"></i></div>'
                                                        .'</div>'
                                                    .'</a>'
                        );
                    }
                }
            }

            // No Results
            else { $result = FALSE; }

			// Get info
            $info = new stdClass();
			$info->sFilter = $filter;
			$info->iSort = $iSort;
			if( ! $result ){ $info->draw = 0; }
            else { $info->sEcho = $sEcho; }
			$info->iTotalRecords = ( $total_all !== FALSE ) ? $total_all : $total;
			$info->iTotalDisplayRecords = ( $result ) ? $total : 0;
            $info->aaData = ( $result ) ? $this->param['query']['list'] : array();

            // Info Time & Memory
            $info->call_name = 'Listado principal';
            $info->elapsed_time = $this->benchmark->elapsed_time();
            $info->memory_usage = $this->benchmark->memory_usage();

            // Return JSON data
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($info));
		}
		else
		{        
			// Query
	        $result = $this->users_groups_model->count();

            //var_dump($result);
	        if($result)
            {
	            // Render
	            $this->render['bread_history_link'] = array('/admin');
	            $this->render['bread_history_name'] = array(lang('lbl_admin'));
	            $this->render['bread_active'] = lang('lbl_users_group_plural');

                // Set Columns
                $columns = array(

                    // All Columns to view
                    'columns' => array(
                        'checkbox'                              => array( 'atts' => '' , 'text' => '<label><input class="uniform_on" name="check_toogle" id="check_toogle" type="checkbox"></label>' ) ,
                        ( 'id_'. $this->concepts['singular'] )  => array( 'atts' => '' , 'text' => lang('lbl_identifier') ) ,
                        'date_insert'                           => array( 'atts' => '' , 'text' => lang('lbl_date_insert') ) ,
                        'manager'                               => array( 'atts' => '' , 'text' => lang('lbl_commercials_manager_singular') ) ,
                        'comercial'                             => array( 'atts' => '' , 'text' => lang('lbl_commercials_singular') ) ,
                        'rol_name'                              => array( 'atts' => '' , 'text' => lang('lbl_roles_singular') ) ,
                        'observations'                          => array( 'atts' => '' , 'text' => lang('lbl_observations') ) ,
                        'actions'                               => array( 'atts' => '' , 'text' => lang('lbl_actions') ) ,
                    ) ,

                    // Classes
                    'classes' => array(
                        'checkbox'                              => 'checkbox' ,
                        ( 'id_'. $this->concepts['singular'] )  => 'identifier' ,
                        'date_insert'                           => 'date'
                    ) ,

                    // Filters
                    'filters' => array(
                        ( 'id_'. $this->concepts['singular'] ) ,
                        'date_insert' ,
                        'manager',
                        'comercial',
                        'observations' ,
                    ) ,

                    // Advanced Filters
                    'advanced' => array(
                        ( 'id_'. $this->concepts['singular'] )  => array( 'type' => 'number' ) ,
                        'date_insert'                           => array( 'type' => 'date' ) ,
                        'manager'                               => array( ),
                        'comercial'                             => array( ),
                        'rol_name'                              => array( ),
                        'observations'                          => array( )
                    ) ,

                    // Titles
                    'titles' => array()
                );
                $this->set_list_columns( $columns );

                //var_dump($columns);

                $this->render['form'] = $this->load->view('admin/common/list', $this->param, TRUE);

	            // Function Params
                $function_params = array(
                    'content'       => VIEW_PATH_CONTENT  ,
                    'data'          => $this->render        /* ,
                    'topnavbar'     => TRUE                 ,
                    'copyright'     => TRUE                 ,
                    'header'        => TRUE                 ,
                    'footer'        => TRUE                 */
                );
                $this->load_view( $function_params );
                // $this->load_view(VIEW_PATH_CONTENT, $this->render);

	        }
	        else {
	            // Warning
	            $this->session->set_flashdata('message',
	                array(
	                    'content' => lang('lbl_select_no_results','','lbl_users_groups_plural'),
	                    'type' => 'warning'
	            ));

	            redirect(BACKEND_PATH_USERS_GROUP_INSERT);
	        }
		}

    }

    private function validation_rules($translate=FALSE)
    {
        $rules = array(
            array('field'=>'observations','label'=>lang('lbl_observations'),'rules'=>'required')
        );
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }


}
/* End of file secciones.php */
/* Location: ./app/controllers/admin/secciones.php */
