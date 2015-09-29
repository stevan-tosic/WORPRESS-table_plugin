<?php
 
class Table {

	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation() {
	global $table_plugin_db_version;
			$table_plugin_db_version = "1.0.0";
	global $wpdb;
    global $table_plugin_db_version;
    global $tableprefix;
    $installed_version = get_option('table_plugin_db_version');

    $tableprefix = $wpdb->prefix;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    if ( $installed_version !== $table_plugin_db_version ) {
        // Create table for students 
        $packagetable = $tableprefix . 'students';
        $sql = "CREATE TABLE " . $packagetable . " (
            id INT NOT NULL AUTO_INCREMENT, 
            name VARCHAR(32) NOT NULL, 
            date_of_birth DATE NOT NULL,
            PRIMARY KEY  (id)
        ) ". $charset_collate .";";
        dbDelta($sql);

        // Create table for exams 
        $hoteltable = $tableprefix . 'exams';
        $sql = "CREATE TABLE " . $hoteltable . " (
            id INT NOT NULL AUTO_INCREMENT, 
            student_id INT NOT NULL, 
            exam_name VARCHAR(32) NOT NULL, 
            date_of_exam DATE NOT NULL,
            mark INT NOT NULL,
            PRIMARY KEY  (id)
        ) ". $charset_collate .";";
        dbDelta($sql);

        update_option('table_plugin_db_version', $table_plugin_db_version);
    }
}

	/**
	 * Removes all connection options
	 * @static
	 */
	public static function plugin_deactivation( ) {
	global $wpdb;
    global $tableprefix;

    $tableprefix = $wpdb->prefix;

        // Drop table students 
        $students = $tableprefix . 'students';
        $sql = "DROP TABLE " . $students .";";
        $wpdb->query($sql);

        // Drop table exams 
        $exams = $tableprefix . 'exams';
        $sql = "DROP TABLE " . $exams . ";";
        $wpdb->query($sql);

        delete_option('table_plugin_db_version');
    
	}

}	
    