<?php
/**
 * Plugin Name: WP User Last Login
 * Plugin URI: http://phpcodingschool.blogspot.com/
 * Description: This plugin shows user's last login time in backend.
 * Version: 2.0.0
 * Author: Monika Yadav
 * Author URI: https://about.me/monikay
 * License: GPL2
 */

class WPLastLogin
{
	public function __construct()
	{    
		//action definations
		
		add_action( 'wp_login', 'user_last_login_record', 10, 2 ); //Updates login time on user login
		add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
		add_filter( 'user_contactmethods', 'new_contact_methods', 10, 1 );
		add_filter( 'manage_users_columns', 'new_modify_user_table' );
	}
}
	
	$WPLastLogin = new WPLastLogin();

	/******************** Updates login time on user login *******************/
	function user_last_login_record( $user_login, $user ) {
	    update_user_meta( $user->ID, 'last_login', time() );
	}
	
	function new_contact_methods( $contactmethods ) {
		$contactmethods['lastlogin'] = 'Last Login';
		return $contactmethods;
	}

    /******************* Displays Column *********************/

	function new_modify_user_table( $column ) {
		$column['lastlogin'] = 'Last Login';
		return $column;
	}
	
	/******************* Displays Column value based on userid *********************/

	function new_modify_user_table_row( $val, $column_name, $user_id ) {
	if(get_the_author_meta( 'last_login', $user_id )){
		$last_login = get_the_author_meta( 'last_login', $user_id );
		$the_login_date = human_time_diff($last_login);
	}

		if(empty($the_login_date)){
			$the_login_date = "Never";
		}

		switch ($column_name) {
			case 'lastlogin' :
			return $the_login_date;
			break;
			default:
		}
		return $val;
	}

?>


