<?php

/*
 * Plugin Name: Hide Jetpack
 * Description: Hide the Jetpack modules given in $this->modules_to_hide.
 * Author: Daryl L. L. Houston
 * Version: 0.1
 * Author URI: http://daryl.learnhouston.com/
 * License: GPL2+
 * Based on code originally courtesy of https://gist.github.com/georgestephanis/6105877
 */

class GSA_Hide_Jetpack {

        
	/**
	 * Singleton
	 */
        
	static function &init() {
		static $instance = false;
                
		if ( $instance )
			return $instance;
                
		$instance = new GSA_Hide_Jetpack;
		return $instance;
	}

	public function __construct() {

		$this->modules_to_hide = array( 'notes', 'publicize', 'comments' );

		add_action( 'option_jetpack_active_modules', array( $this, 'deactivate_modules' ) );
		add_action( 'admin_head', array( $this, 'add_css' ) );
	}

	function deactivate_modules( $active_modules ) {
		return array_diff( $active_modules, $this->modules_to_hide );	
	}

	function add_css() {
		?>
			<style type="text/css">
		<?php
			foreach ( $this->modules_to_hide as $module ) {
				printf( "#%s.jetpack-module { display:none; }\n", esc_html( $module ) );
			}
		?>
			</style>
		<?php	
	}

}

add_action( 'admin_init', array( 'GSA_Hide_Jetpack', 'init' ) );

