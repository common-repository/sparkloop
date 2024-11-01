<?php
/*
Plugin Name: SparkLoop - the referral platform for newsletter growth
Description: A simple plugin to add the SparkLoop script to your website!
Version: 1.0.1
Author: sparkloop
Author URI: https://sparkloop.app
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: sparkloop
*/

add_action( 'admin_menu', 'sparloop_register_my_custom_menu_page' );

function sparloop_register_my_custom_menu_page() {
	add_menu_page( 'SparkLoop', 'SparkLoop', 'manage_options', 'sparkloop', 'sparloop_backend', 'dashicons-admin-generic', 90 );
}

add_action('admin_head', 'sparloop_custom_css');

function sparloop_custom_css() {
  echo '<style>
    #api_key, #cache_time {
		width: 100%;
		max-width: 320px;
		margin-bottom: 15px;
	}
  </style>';
}

function sparloop_backend(){
	if(isset($_POST['uuid'])) {
		update_option('sparkloop_uuid', sanitize_text_field($_POST['uuid']));

		echo '
			<div class="notice notice-success is-dismissible">
        <p>Changes saved!</p>
    	</div>
		';
	}

  echo '<h1>SparkLoop - the referral platform for newsletter growth</h1>';

	echo '
		<form action="" method="post">
			<label><strong>SparkLoop Campaign UUID</strong></label><br/>
			<input id="uuid" name="uuid" type="text" value=' . esc_attr(get_option('sparkloop_uuid')) . '>
			<input type="submit" class="button button-primary" value="Save">
			<p><small><a href="https://help.sparkloop.app/en/articles/5855767" target="_blank">Read more</a> about SparkLoop\'s Wordpress plugin</small></p>
		</form>
	';
}

/* Output our script if there's an ID */
add_action('wp_head', 'sparkloop_add_script');

function sparkloop_add_script(){
	if(get_option('sparkloop_uuid') != false && get_option('sparkloop_uuid') != '') {
		wp_print_script_tag(
			array(
				'src' => esc_url( 'https://dash.sparkloop.app/widget/' . get_option('sparkloop_uuid') . '/embed.js' ),
				'async' => true,
				'data-sparkloop' => true,
			)
		);
	}
};