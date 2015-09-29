<?php

class Student {

	
	function add_to_students( $name, $date) {

	global $wpdb;
	$table_name = $wpdb->prefix . "students";
	$wpdb->insert( 
		$table_name, 
		array( 
			'name' 			=> $name, 
			'date_of_birth' => $date ) 
		);

	}

	function remove_from_students( $student_id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "students";
		$wpdb->delete(
			$table_name, 
			array( 
			'id' => $student_id
			 ) 
		);
	}

	function update_students( $student_id, $name, $date) {
		global $wpdb;
		$table_name = $wpdb->prefix . "students";
		$wpdb->update( 
		$table_name, 
		array( 
			'name' 			=> $name, 
			'date_of_birth' => $date ),
		array( 
			'id' => $student_id
			 ) 
		);
	}


}