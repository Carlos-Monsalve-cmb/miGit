<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_groups_model extends MY_Model {

    public function __construct()
    {
        parent:: __construct();

        // To debug
        $this->ADMIN_DEV = isset( $this->session->userdata['user_data'] )
                            && isset( $this->session->userdata['user_data']['login_name'] )
                            && $this->session->userdata['user_data']['login_name'] == 'admindevel' ? TRUE : FALSE;
        $this->SHOW_QUERYS = FALSE;

        // Gender
        $this->pg = 'male';

        // Principal Table Alias & ID Field

        $this->pt = 'USERS_GROUPS';
        $this->pta = 'US_G';
        $this->pidf = 'id_users_group';

        // IDs Not deleteables
        // $this->sids = array();
        // Default Values
        $this->dof = 'id_users_group ASC';    // Default Order
 
        //Custom Atts for Filter & Search
        $this->alias = array(
            $this->pidf         => $this->pta .'.'. $this->pidf ,
            'date_insert'       => $this->pta .'.date_insert' ,
            'manager'           => 'users_id  IN ( SELECT id_user FROM USERS WHERE ( id_user $search' 
                                                                                  . 'OR name $search'
                                                                                  . 'OR email $search ) )' ,

            'comercial'         => 'users_comercial_id  IN ( SELECT id_user FROM USERS WHERE ( id_user $search' 
                                                                                  . 'OR name $search'
                                                                                  . 'OR email $search ) )' ,
            'observations'      => ($this->pta .'.observations' ),
        );

        // Querys
        $this->ct = strtolower( $this->pt );
        $this->qs[ $this->ct ] = array();

    }

    public function select( $function_params = array() )
    {

        $this->db->select('US.name, 
                           US.email,
                           US2.name,
                           US2.email,
                         ( UR.name ) AS rol_name');
        $this->db->select( "CONCAT ( US_G.users_id, ' - ', US.name, ' - ', US.email ) AS manager", FALSE );
        $this->db->select( "CONCAT ( US_G.users_comercial_id, ' - ', US2.name, ' - ', US2.email ) AS comercial", FALSE );
        $this->db->join( 'USERS US', 'US.id_user = US_G.users_id', 'LEFT' );
        $this->db->join( 'USERS US2', 'US2.id_user = US_G.users_comercial_id', 'LEFT' );
        $this->db->join( 'USERS_ROLES UR', 'US2.roles_id = UR.id_role', 'LEFT' );


        //$query = $this->db->get();    
        //echo ("AKI");
        //var_dump($function_params);

        $result = parent::select( $function_params );  
        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; }

        // var_dump($query);

        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; 
        }

        return $result;
        //return $query->result();
    }

	public function count( $function_params = array() )
	{
        // Result to Debug
        $result = parent::count( $function_params );                            
        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; 
        }

        // Return
        return $result;
	}

    public function insert( $function_params = array() )
    {
        // Result to Debug
        $result = parent::insert( $function_params );    
        
        //var_dump($result);

        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; 
        }

        // Return
        return $result;
    }

    public function update( $function_params = array() )
    {
        // Result to Debug
        $result = parent::update( $function_params );  
        
        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; 
        }

        // Return
        return $result;
    }

    public function delete( $ids )
    {
        // Result to Debug
        $result = parent::delete( $ids );                                       
        if( $this->ADMIN_DEV && $this->SHOW_QUERYS )
        { 
            echo '<pre>'; 
            print_r( $this->qs[ $this->ct ][ __FUNCTION__ ] ); 
            echo '</pre>'; 
        }

        // Return
        return $result;
    }


    public function search_for_roles( $function_params = array() )
    {
        $this->db->select  ( 'US.id_user,
                              US.name' );
        $this->db->from    ( 'USERS US' );
        $this->db->where   ( 'US.roles_id ',$function_params['rol_id'] );
        $this->db->order_by( 'name','ASC' );

        $result = $this->db->get();  

        return $result->result();

    }
}
/* End of file users_groups_model.php */
/* Location: ./app/models/admin/users_groups_model.php */
