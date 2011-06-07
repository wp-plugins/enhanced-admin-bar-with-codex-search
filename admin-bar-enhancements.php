<?php
/*
Plugin Name: Enhanced Admin Bar with Codex Search
Plugin URI: http://dsgnwrks.pro/enhanced-admin-bar-with-codex-search/
Description: This plugin provided easy access to the codex, plugins repository and common wp-admin areas via the 3.1 Admin Bar.
Author URI: http://dsgnwrks.pro
Author: DsgnWrks
Donate link: http://dsgnwrks.pro/give/
Version: 1.0
*/


// Enqueue Styles
add_action('wp_print_styles', 'dsgnwrks_adminbar_search_css');
add_action('admin_print_styles', 'dsgnwrks_adminbar_search_css');
function dsgnwrks_adminbar_search_css() { 
	wp_enqueue_style('adminbar_search_css', plugins_url('css/adminbar_search.css', __FILE__));
}

// add search forms to 3.2+ wp-admin header
add_filter( 'in_admin_header', 'dsgnwrks_3_2_search_formS', 11 );
function dsgnwrks_3_2_search_formS() {
	if ( get_bloginfo('version') >= 3.2 ) {
	    echo '
		<form target="_blank" method="get" action="http://wordpress.org/extend/plugins/search.php" class="alignright dw_search_form search_plugins" >
			<input type="text" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="search" class="text dw_search_input" > 
			<input type="submit" value="Go" class="button dw_search_go"  />
		</form>
		<form target="_blank" method="get" action="http://wordpress.org/search/do-search.php" class="alignright dw_search_form search_codex" >
			<input type="text" onblur="this.value=(this.value==\'\') ? \'Search the Codex\' : this.value;" onfocus="this.value=(this.value==\'Search the Codex\') ? \'\' : this.value;" value="Search the Codex" name="search" class="text dw_search_input" > 
			<input type="submit" value="Go" class="button dw_search_go"  />
		</form>
	    ';
	}
}

// Add Custom Menu to the Admin bar
add_action('admin_bar_init', 'dsgnwrks_adminbar_menu_init');
function dsgnwrks_adminbar_menu_init() {
	if (!is_super_admin() || !is_admin_bar_showing() )
		return;
 	add_action( 'admin_bar_menu', 'dsgnwrks_admin_bar_menu', 500 );
}

function dsgnwrks_admin_bar_menu() {
	global $wp_admin_bar;

	$go_button = '<input type="submit" value="Go" class="button dw_search_go"  /></form>';
	$admin_url = get_admin_url();

	// Add codex and plugin search menu items
	$wp_admin_bar->add_menu( array(
	'id' => 'dsgnwrks_help_menu',
	'title' => __( '
	<strong style="display:none;">Search the Codex</strong>
	<form target="_blank" method="get" action="http://wordpress.org/search/do-search.php" class="alignleft dw_search" >
		<input type="text" onblur="this.value=(this.value==\'\') ? \'Search the Codex\' : this.value;" onfocus="this.value=(this.value==\'Search the Codex\') ? \'\' : this.value;" value="Search the Codex" name="search" class="text dw_search_input" > 
	'.$go_button),
	'href' => '#' ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( '
	<strong style="display:none;">Search Plugins</strong>
	<form target="_blank" method="get" action="http://wordpress.org/extend/plugins/search.php" class="alignleft dw_search">
		<input type="text" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="search" class="text dw_search_input" > 
	'.$go_button),
	'href' => '#' ) );

	// Only add remaining menu items if we're not in wp-admin.
	if ( is_admin() )
	return;		

	$wp_admin_bar->add_menu( array(
	'id' => 'posts_stuff',
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Posts'),
	'href' => $admin_url.'edit.php' ) );

	$wp_admin_bar->add_menu( array(
	'id' => 'page_stuff',
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Pages'),
	'href' => $admin_url.'edit.php?post_type=page' ) );

	$wp_admin_bar->add_menu( array(
	'id' => 'plugins_stuff',
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Plugins'),
	'href' => $admin_url.'plugins.php' ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'plugins_stuff',
	'title' => __( 'Add New Plugin' ),
	'href' => $admin_url.'plugin-install.php' ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Media'),
	'href' => $admin_url.'upload.php' ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Settings'),
	'href' => $admin_url.'options-general.php' ) );
}

// add theme info dashboard widget
add_action('wp_dashboard_setup', 'dsgnwrks_themeinfo_dash_widget');
function dsgnwrks_themeinfo_dash_widget() {
	global $wp_meta_boxes;
	$dw_theme_name = get_current_theme();
	$dw_theme_data = get_theme($dw_theme_name);
	wp_add_dashboard_widget("dw_themeinfo_widget", "<div class='theme_info'>{$dw_theme_data["Name"]} by {$dw_theme_data["Author"]}</div>", "dsgnwrks_themeinfo_widget");
}

function dsgnwrks_themeinfo_widget() {
$theme_name = get_current_theme();
	global $wp_meta_boxes;
	$dw_theme_name = get_current_theme();
	$dw_theme_data = get_theme($dw_theme_name);
	?>
	<div class='theme_info'>
	<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/screenshot.png" alt="<?php _e('Current theme preview'); ?>" />
	<?php
	echo "<p>{$dw_theme_data["Description"]}</p>";
	if ($dw_theme_data["Version"]){ 
		echo "<p>Version: {$dw_theme_data["Version"]}</p>";
	}
	if ($dw_theme_data["Tags"]){ 
		echo "<p>Tags: " . join(', ', $dw_theme_data['Tags'])."</p>";
	}
	
	echo "<p>For support, please contact {$dw_theme_data["Author"]}.</p></div>";
}
?>