<?php
/*
Plugin Name: Enhanced Admin Bar with Codex Search
Plugin URI: http://dsgnwrks.pro/enhanced-admin-bar-with-codex-search/
Description: This plugin adds convenient search fields to provide easy access to the codex, wpbeginner, and common wp-admin areas via the 3.1 Admin Bar.
Author URI: http://dsgnwrks.pro
Author: DsgnWrks
Donate link: http://dsgnwrks.pro/give/
Version: 1.5.1
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
		// install_search_form2();
	    echo '
		<form method="get" action="'.admin_url('plugin-install.php').'"  class="alignright dw_search_form search_plugins" >
			<input type="hidden" name="tab" value="search"/>
			<input type="hidden" name="type" value="term"/>
			<input type="text" placeholder="Search Plugins" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
			<input type="submit" value="Go" class="button dw_search_go"  />
		</form>
		<form target="_blank" method="get" action="http://wordpress.org/search/do-search.php" class="alignright dw_search_form search_codex" >
			<input type="text" onblur="this.value=(this.value==\'\') ? \'Search the Codex\' : this.value;" onfocus="this.value=(this.value==\'Search the Codex\') ? \'\' : this.value;" value="Search the Codex" name="search" class="text dw_search_input" > 
			<input type="submit" value="Go" class="button dw_search_go"  />
		</form>
	    ';
	}
}

// Add Custom Menu Option
add_action('init', 'dsgnwrks_adminbar_nav');
function dsgnwrks_adminbar_nav() {

	register_nav_menus( array(
		'admin_bar_nav' => __( 'Admin Bar Custom Navigation Menu' ),
	) );

}

// Add Custom Menu to the Admin bar
add_action('admin_bar_init', 'dsgnwrks_adminbar_menu_init');
function dsgnwrks_adminbar_menu_init() {
	if (!is_super_admin() || !is_admin_bar_showing() )
		return;
 	add_action( 'admin_bar_menu', 'dsgnwrks_admin_bar_menu', 1000 );
}

function dsgnwrks_admin_bar_menu() {
	global $wp_admin_bar;

	// Add a custom menu option
	$menu_name = 'admin_bar_nav';
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

	    $menu_items = wp_get_nav_menu_items( $menu->term_id );
	    if ($menu_items) {
		    $wp_admin_bar->add_menu( array(
		        'id' => 'dsgnwrks-admin-menu-0',
		        'title' => 'Enhanced Admin Bar Custom Menu',
				'href' => '#' ) );
		    foreach ( $menu_items as $menu_item ) {
		        $wp_admin_bar->add_menu( array(
		            'id' => 'dsgnwrks-admin-menu-' . $menu_item->ID,
		            'parent' => 'dsgnwrks-admin-menu-' . $menu_item->menu_item_parent,
		            'title' => $menu_item->title,
		            'href' => $menu_item->url,
		            'meta' => array(
		                'title' => $menu_item->attr_title,
		                'target' => $menu_item->target,
		                'class' => implode( ' ', $menu_item->classes ),
		            ),
		        ) );
		    }
	    }
	}

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
	<strong style="display:none;">Search wpbeginner.com</strong>
	<form target="_blank" method="get" action="http://www.wpbeginner.com/" class="alignleft dw_search" >
		<input type="text" onblur="this.value=(this.value==\'\') ? \'Search wpbeginner.com\' : this.value;" onfocus="this.value=(this.value==\'Search wpbeginner.com\') ? \'\' : this.value;" value="Search wpbeginner.com" name="s" class="text dw_search_input" > 
	'.$go_button),
	'href' => '#' ) );

	if ( !is_admin() ) {

		$wp_admin_bar->add_menu( array(
		'id' => 'plugins_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( 'Plugins'),
		'href' => admin_url('plugins.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'plugins_stuff',
		'title' => __( '
		<strong style="display:none;">Search Plugins</strong>
		<form method="get" action="'.admin_url('plugin-install.php?tab=search').'"  class="alignleft dw_search" >
		<input type="hidden" name="tab" value="search"/>
		<input type="hidden" name="type" value="term"/>
		<input type="text" placeholder="Search Plugins" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="plugin-search-input">' . _e('Search Plugins') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'plugins_stuff',
		'title' => __( 'Upload Plugin' ),
		'href' => admin_url('plugin-install.php?tab=upload') ) );

		$wp_admin_bar->add_menu( array(
		'id' => 'themes_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( 'Themes'),
		'href' => admin_url('themes.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'themes_stuff',
		'title' => __( '
		<strong style="display:none;">Search Themes</strong>
		<form method="get" action="'.admin_url('theme-install.php?tab=search').'"  class="alignleft dw_search" >
		<input type="hidden" name="tab" value="search"/>
		<input type="hidden" name="type" value="term"/>
		<input type="text" placeholder="Search Themes" onblur="this.value=(this.value==\'\') ? \'Search Themes\' : this.value;" onfocus="this.value=(this.value==\'Search Themes\') ? \'\' : this.value;" value="Search Themes" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="theme-search-input">' . _e('Search Themes') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'themes_stuff',
		'title' => __( 'Upload Theme' ),
		'href' => admin_url('theme-install.php?tab=upload') ) );

		$wp_admin_bar->add_menu( array(
		'id' => 'media_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( 'Media'),
		'href' => admin_url('upload.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'media_stuff',
		'title' => __( '
		<strong style="display:none;">Search Media</strong>
		<form method="get" action="'.admin_url('upload.php?tab=search').'"  class="alignleft dw_search" >
		<input type="text" placeholder="Search Media" onblur="this.value=(this.value==\'\') ? \'Search Media\' : this.value;" onfocus="this.value=(this.value==\'Search Media\') ? \'\' : this.value;" value="Search Media" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="media-search-input">' . _e('Search Media') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'media_stuff',
		'title' => __( 'Upload Media' ),
		'href' => admin_url('media-new.php') ) );

	} else {

		$wp_admin_bar->add_menu( array(
		'id' => 'plugins_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( '
		<strong style="display:none;">Search Plugins</strong>
		<form method="get" action="'.admin_url('plugin-install.php?tab=search').'"  class="alignleft dw_search" >
		<input type="hidden" name="tab" value="search"/>
		<input type="hidden" name="type" value="term"/>
		<input type="text" placeholder="Search Plugins" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="plugin-search-input">' . _e('Search Plugins') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'plugins_stuff',
		'title' => __( 'Upload Plugin' ),
		'href' => admin_url('plugin-install.php?tab=upload') ) );

		$wp_admin_bar->add_menu( array(
		'id' => 'themes_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( '
		<strong style="display:none;">Search Themes</strong>
		<form method="get" action="'.admin_url('theme-install.php?tab=search').'"  class="alignleft dw_search" >
		<input type="hidden" name="tab" value="search"/>
		<input type="hidden" name="type" value="term"/>
		<input type="text" placeholder="Search Themes" onblur="this.value=(this.value==\'\') ? \'Search Themes\' : this.value;" onfocus="this.value=(this.value==\'Search Themes\') ? \'\' : this.value;" value="Search Themes" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="theme-search-input">' . _e('Search Themes') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'themes_stuff',
		'title' => __( 'Upload Theme' ),
		'href' => admin_url('theme-install.php?tab=upload') ) );

		$wp_admin_bar->add_menu( array(
		'id' => 'media_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( '
		<strong style="display:none;">Search Media</strong>
		<form method="get" action="'.admin_url('upload.php?tab=search').'"  class="alignleft dw_search" >
		<input type="text" placeholder="Search Media" onblur="this.value=(this.value==\'\') ? \'Search Media\' : this.value;" onfocus="this.value=(this.value==\'Search Media\') ? \'\' : this.value;" value="Search Media" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
		<label class="screen-reader-text" for="media-search-input">' . _e('Search Media') . '</label>'.$go_button),
		'href' => '#' ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'media_stuff',
		'title' => __( 'Upload Media' ),
		'href' => admin_url('media-new.php') ) );		
	}

	$actions = array();
	foreach ( (array) get_post_types( array( 'show_ui' => true ), 'objects' ) as $ptype_obj ) {
		if ( true !== $ptype_obj->show_in_menu || ! current_user_can( $ptype_obj->cap->edit_posts ) )
			continue;

		$actions[ 'post-new.php?post_type=' . $ptype_obj->name ] = array( $ptype_obj->labels->name, $ptype_obj->cap->edit_posts, 'new-' . $ptype_obj->name, $ptype_obj->labels->singular_name, $ptype_obj->name, 'edit.php?post_type=' . $ptype_obj->name );
	}

	if ( empty( $actions ) )
		return;

	foreach ( $actions as $link => $action ) {

		if ( is_admin() ) {
			$wp_admin_bar->add_menu( array( 'parent' => 'dsgnwrks_help_menu', 
			'title' => __( '
			<strong style="display:none;">Search '.$action[0].'</strong>
			<form method="get" action="'.admin_url('edit.php').'"  class="alignleft dw_search" >
			<input type="hidden" name="post_status" value="all"/>
			<input type="hidden" name="post_type" value="'.$action[4].'"/>
			<input type="text" placeholder="Search '.$action[0].'" onblur="this.value=(this.value==\'\') ? \'Search '.$action[0].'\' : this.value;" onfocus="this.value=(this.value==\'Search '.$action[0].'\') ? \'\' : this.value;" value="Search '.$action[0].'" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
			<label class="screen-reader-text" >' . _e('Search '.$action[0]) . '</label>'.$go_button),
			'href' => '#' ) );
		} else {
			$wp_admin_bar->add_menu( array( 
			'parent' => 'dsgnwrks_help_menu', 
			'id' => $action[2], 
			'title' => $action[0], 
			'href' => admin_url($action[5]) ) );


			$wp_admin_bar->add_menu( array( 'parent' => $action[2], 
			'title' => __( '
			<strong style="display:none;">Search '.$action[0].'</strong>
			<form method="get" action="'.admin_url('edit.php').'"  class="alignleft dw_search" >
			<input type="hidden" name="post_status" value="all"/>
			<input type="hidden" name="post_type" value="'.$action[4].'"/>
			<input type="text" placeholder="Search '.$action[0].'" onblur="this.value=(this.value==\'\') ? \'Search '.$action[0].'\' : this.value;" onfocus="this.value=(this.value==\'Search '.$action[0].'\') ? \'\' : this.value;" value="Search '.$action[0].'" name="s" value="' . esc_attr($term) . '" class="text dw_search_input" />
			<label class="screen-reader-text" >' . _e('Search '.$action[0]) . '</label>'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array( 
			'parent' => $action[2], 
			'title' => 'Add New '.$action[3], 
			'href' => admin_url($link) ) );
		}
	}

	// Only add remaining menu items if we're not in wp-admin.
	if ( is_admin() )
	return;		

	$wp_admin_bar->add_menu( array(
	'id' => 'settings_stuff',
	'parent' => 'dsgnwrks_help_menu',
	'title' => __( 'Settings'),
	'href' => admin_url('options-general.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Writing'),
	'href' => admin_url('options-writing.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Reading'),
	'href' => admin_url('options-reading.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Discussion'),
	'href' => admin_url('options-discussion.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Media'),
	'href' => admin_url('options-media.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Privacy'),
	'href' => admin_url('options-privacy.php') ) );

	$wp_admin_bar->add_menu( array(
	'parent' => 'settings_stuff',
	'title' => __( 'Permalinks'),
	'href' => admin_url('options-permalink.php') ) );
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