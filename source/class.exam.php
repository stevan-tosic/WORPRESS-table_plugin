<?php

class Exam {
	

	function add_to_exams( $student_id, $name, $date, $mark) {
	global $wpdb;
	$table_name = $wpdb->prefix . "exams";

	$wpdb->insert( 
		$table_name, 
		array( 
			'student_id'	=> $student_id,
			'exam_name' 	=> $name, 
			'date_of_exam' 	=> $date,
			'mark'			=> $mark ) 
		);

	}

	function remove_from_exams( $exam_id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "exams";

		$wpdb->delete(
			$table_name, 
			array( 
			'id' => $exam_id
			 ) 
		);
	}

	function update_exams( $exam_id, $student_id, $name, $date, $mark) {
		global $wpdb;
		$table_name = $wpdb->prefix . "exams";

		$wpdb->update( 
		$table_name, 
		array( 
			'student_id'	=> $student_id,
			'exam_name' 	=> $name, 
			'date_of_exam' 	=> $date,
			'mark'			=> $mark ),
		array( 
			'id' => $exam_id
			 ) 
		);
	}
}