<?php
/**
 * Plugin Name: Database Models
 * Plugin URI: https://github.com/jellingsen/db-models
 * Author: J&oslash;rgen Ellingsen
 * Description: Database Model Implementation
 * Author URI: https://github.com/jellingsen
 * Version: 0.0.2a
 * License: GPLv2
 */
define( 'DB_MODELS_DEBUG', true );

define( 'MODELS_PATH', plugin_dir_path( __FILE__ ).'/models/' );

if(DB_MODELS_DEBUG) {
	$GLOBALS['DB_MODELS_DEBUG'] = [];
	function db_models_add_debug_panel()
	{
		echo '<div style="background: #FFFFFF; margin: 20px; padding: 10px;">';
		echo '<h2>DB-Models Debug:</h2>';
		if(!empty($GLOBALS['DB_MODELS_DEBUG']))
		{
			echo '<table cellspacing="0"><thead><tr><th>Query</th><th>Time</th><th>Cached</th></tr></thead><tbody>';

			foreach($GLOBALS['DB_MODELS_DEBUG'] as $debug)
			{
				if($debug[2] == true) $cached = 'yes';
				else $cached = 'no';
				echo '<tr><td>'.$debug[0].'</td><td>'.round($debug[1],5).'s</td><td>'.$cached.'</td></tr>';
			}
			echo '</tbody></table>';
		}
		else echo "No queries";
		echo '</div>';
	}
	function db_models_plugin_init() {
		wp_register_style( 'dbModels', plugins_url( 'stylesheet.css', __FILE__ ) );
		wp_enqueue_style( 'dbModels' );
	}

	add_action( 'init', 'db_models_plugin_init' );
	add_action('wp_footer', 'db_models_add_debug_panel');
}