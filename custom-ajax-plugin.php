<?php
/**
 * Plugin Name: Custom AJAX Plugin
 */

// Step 2: Add Custom Menu and Store Name

function custom_ajax_plugin_menu() {
	add_menu_page(
		'Custom AJAX Plugin Settings',
		'Custom AJAX Plugin',
		'manage_options',
		'custom-ajax-plugin-settings',
		'custom_ajax_plugin_settings_page'
	);
}

function custom_ajax_plugin_settings_page() {
	?>
	<div class="wrap">
		<h2>Custom AJAX Plugin Settings</h2>
		<form id="store-name-form">
		<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
			<label for="store-name">Store Name:</label>
			<input type="text" id="store-name" name="store_name" value="<?php echo esc_attr( get_option( 'store_name' ) ); ?>">
			<input type="submit" value="Save">
		</form>
		<div id="store-name-result"></div>
	</div>
	<?php
}

add_action( 'admin_menu', 'custom_ajax_plugin_menu' );

// Step 3: Implement AJAX for Dynamic Content

function custom_ajax_plugin_ajax_handler() {
	if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
		$store_name = sanitize_text_field( $_POST['store_name'] );
		update_option( 'store_name', $store_name );
		echo 'Store name updated successfully!';
	}
	wp_die();
}

add_action( 'wp_ajax_custom_ajax_plugin_update_store_name', 'custom_ajax_plugin_ajax_handler' );

// Enqueue JavaScript for AJAX

function custom_ajax_plugin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_custom-ajax-plugin-settings' !== $hook ) {
		return;
	}
	wp_enqueue_script( 'custom-ajax-plugin-script', plugins_url( '/js/custom-ajax-plugin-script.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_localize_script(
		'custom-ajax-plugin-script',
		'custom_ajax_plugin_ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	);
}

add_action( 'admin_enqueue_scripts', 'custom_ajax_plugin_enqueue_scripts' );
