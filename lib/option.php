<?php

// TODO create proper object for options
// TODO add options for slider: navigation, pagination, direction
add_action( 'admin_menu', 'upf_add_admin_menu' );
add_action( 'admin_init', 'upf_settings_init' );


function upf_add_admin_menu() {

	add_menu_page( 'Uber Post Formats', 'Uber Post Formats', 'manage_options', 'uber_post_formats', 'upf_options_page' );

}


function upf_settings_init() {

	register_setting( 'pluginPage', 'upf_settings' );

	add_settings_section(
		'upf_pluginPage_section',
		__( 'Your section description', 'upf' ),
		'upf_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'upf_select_field_0',
		__( 'Settings field description', 'upf' ),
		'upf_select_field_0_render',
		'pluginPage',
		'upf_pluginPage_section'
	);

	add_settings_field(
		'upf_checkbox_field_1',
		__( 'Settings field description', 'upf' ),
		'upf_checkbox_field_1_render',
		'pluginPage',
		'upf_pluginPage_section'
	);


}


function upf_select_field_0_render() {

	$options = get_option( 'upf_settings' );
	?>
    <select name='upf_settings[upf_select_field_0]'>
        <option value='1' <?php selected( $options['upf_select_field_0'], 1 ); ?>>Option 1</option>
        <option value='2' <?php selected( $options['upf_select_field_0'], 2 ); ?>>Option 2</option>
    </select>

	<?php

}


function upf_checkbox_field_1_render() {

	$options = get_option( 'upf_settings' );
	?>
    <input type='checkbox' name='upf_settings[upf_checkbox_field_1]' <?php checked( $options['upf_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}


function upf_settings_section_callback() {

	echo __( 'This section description', 'upf' );

}


function upf_options_page() {

	?>
    <form action='options.php' method='post'>

        <h2>Uber Post Formats</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

    </form>
	<?php

}

////////////////////////////////////////////////////////////////////

// TODO move this to main class
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
	$links[] = '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=gpaisr' ) ) . '">Settings</a>';
	$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';

	return $links;
}