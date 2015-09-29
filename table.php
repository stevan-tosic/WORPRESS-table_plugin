<?php
/*
Plugin name: Table Plugin
Description: Exam given by Vladica Bibeskovic - Project Manager at touchmesoft.
Version: 0.1.1
Author: Stevan Tosic
Author URI: http://www.hire-me.in.rs/
*/
define('TABLE__VERSION', '0.0.1');
define('TABLE__MINIMUM_WP_VERSION', '3.2');
define('TABLE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('TABLE__PLUGIN_DIR', plugin_dir_path(__FILE__) );
/*
 *  Action taken during activation and deactivation of plugin
 *
 */
register_activation_hook(  __FILE__, array( 'Table', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Table', 'plugin_deactivation' ) );
/*
 * Writing a title if a plugin is active 
 *
 */
add_action('admin_notices', function () { 
	if (!is_plugin_active(TABLE__PLUGIN_DIR . '/table.php')) {
	    echo "<h1><b>TABLE PLUGIN</b></h1>";
	}
});
/*
 * Making a new menu page with subpages 
 *
 */
add_action( 'admin_menu', function () {
	add_menu_page('My Custom Page', 'Tables manages', 'manage_options', 'my-top-level-slug' );
	add_submenu_page( 'my-top-level-slug', 'Manage students', 'Manage students', 'manage_options',TABLE__PLUGIN_DIR . '/templates/admin_student.tpl.php' );
	add_submenu_page( 'my-top-level-slug', 'Manage exams', 'Manage exams', 'manage_options', TABLE__PLUGIN_DIR . '/templates/admin_exam.tpl.php' );
});
/*
 * Adding shortcode for diplaying student list
 *
 */
add_shortcode('my_plugin_students', function () {
	global $wpdb;
	global $tableprefix;
	$tableprefix = $wpdb->prefix;
	$results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );

	if($results) {
	 foreach($results as $r) {
	 	$rows .=  '
 		<tr>	<td>'. $r->name .'</td>
				<td>'. $r->date_of_birth .'</td> 	</tr>';
		}
	}
	$table = "<div><h2>Student list</h2>
				<table><thead><tr>
	 						<th>Student name</th>
	 						<th>Birth date</th>
 				</tr></thead><tbody>" .
 					$rows . "
 				</tbody></table></div>";
	return $table;	
});
/*
 * Adding shortcode, displaying exams for chosen students 
 *
 */
add_shortcode('my_plugin_exams', function ($atts) {
	$atts['id'] = $_POST['student'];
	$opt_text = '- - - - - - - - ';
	echo $student_id;
	echo $selected["name"];

if (!isset($atts['id'])) { $atts['id'] = '0'; $opt_text = '- - - - - - - - '; }

global $wpdb;
global $tableprefix;
$tableprefix = $wpdb->prefix;
$exam_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . 'exams' . " WHERE student_id = " . $atts['id'] );
$student_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );

$selected = $wpdb->get_results( "SELECT name FROM " . $tableprefix . 'students' . " WHERE id = " . $atts['id'] . "LIMIT 1" );


if ($exam_results || $student_results) {
	foreach ($student_results as $s) {
		$student .= '<option value="' .$s->id. '">'. $s->name.'</option>';
	}
	foreach ($exam_results as $e) {
		$exams .= '<tr>	<td>'. $e->exam_name .		'</td>
						<td>'. $e->date_of_exam .	'</td>
						<td>'. $e->mark .			'</td>	</tr>';
	}
}
$table ='<div> <form action="" method="post" id="select_student_form" > <h2>Exams for student: 
<select name="student" onchange="this.form.submit()" id="select_student">
	<option value="'. $atts['id'] . '" selected>'. $opt_text .'</option>' .
	$student. '</select>
</h2>
</form>
  <table>
    <thead>
      <tr>
        <th>Exam name</th>
		<th>Exam date</th>
		<th>Exam mark</th>
      </tr>
    </thead>
   <tbody>' . $exams . '</tbody>
  </table> ';

  return $table;
});
/*
 *   Including CLASSES 
 *
 */
require_once(TABLE__PLUGIN_DIR . 'source/class.table.php');
require_once(TABLE__PLUGIN_DIR . 'source/class.exam.php');
require_once(TABLE__PLUGIN_DIR . 'source/class.student.php');
/*
 *   Including scripts into main Worpdress document
 *
 */
add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'style', plugins_url('css/index.css', __FILE__) );
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-1.10.2.js', array( 'jquery'), '1.10.2');
	wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.11.4/jquery-ui.js', array( 'jquery', 'jquery-ui-datepicker'), '1.11.4');
	wp_enqueue_script( 'index.js', plugins_url('js/index.js', __FILE__), '', '');
});








