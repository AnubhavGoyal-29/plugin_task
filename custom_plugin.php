<?php
/*
Plugin Name: List All PLugin
 */
/*
Name => List All PLugin
PluginURI =>
Version =>
Description =>
Author =>
AuthorURI =>
TextDomain => custom_plugin
DomainPath =>
Network =>
RequiresWP =>
RequiresPHP =>
UpdateURI =>
Title => List All PLugin
AuthorName =>
Status: true
 */
include_once( 'wp-admin/includes/plugin.php' );
function list_all_plugins() {
	if (isset($_GET['deactivate'])) {
		echo $_GET['key'];
		deactivate_plugin_via_php($_GET['key']);
		echo "Successfully deactivated  ". $_GET['key'];
	}
	if (isset($_GET['activate'])) {
		echo $_GET['key'];
		activate_plugin_via_php($_GET['key']);
		echo "Successfully activated  ". $_GET['key'];
	}
echo '<table margin="10px" border="1px" cellpadding="4" cellspacing="5" padding="5">';
	$all_plugins = get_plugins();
	echo '<tr>';
	echo ' <th>No</th>';
	echo ' <th>Name</th>';
	echo ' <th>Version</th>';
	echo ' <th>Slug</th>';
	echo ' <th>Status</th>';
	echo '</tr>';
	if(isset($_POST['deactivate'])){
		echo "deactivate";
		myFunction(); //here goes the function call
	 }	 
	$num = 1;
	foreach ( $all_plugins as $key => $value ) {
		echo '<tr>';
		$status = is_plugin_active( $key ) ? "ACTIVE" : "INACTIVE" ;
		
		$plugins[ $key ] = array(
			'name'    => $value['Name'],
			'version' => $value['Version'],
			'slug'    => $key,
			'status'  => $status,
		);
		
		echo '<td>'. $num . '</td>';
		echo '<td>'. $plugins[$key]['name'] . '</td>';
		echo '<td>'. $plugins[$key]['version'] . '</td>';
		echo '<td>'. $plugins[$key]['slug'] . '</td>';
		echo '<td>'. $plugins[$key]['status'] . '</td>';
		
		if ( $key != "custom_plugin/custom_plugin.php"){
			if ($plugins[$key]['status'] == "ACTIVE")
				echo '<td><a href="/wp-admin/admin.php?page=installed-plugin-list&deactivate=true&key='.$key.'">deactivate</a></td>';
			else echo '<td><a href="/wp-admin/admin.php?page=installed-plugin-list&activate=true&key='.$key.'">activate</a></td>';
		}
		$num = $num + 1 ;
		echo '</tr>';

	}
	echo '</table>';

}
function deactivate_plugin_via_php($location) {
	deactivate_plugins($location);   
}
function activate_plugin_via_php($location) {
	activate_plugins($location);   
}
function custom_menu(){
	add_menu_page('Installed Plugins','Plugin List','manage_options','installed-plugin-list','list_all_plugins','',1);

}
add_action('admin_menu','custom_menu');

?>
