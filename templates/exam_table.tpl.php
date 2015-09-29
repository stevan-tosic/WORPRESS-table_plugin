<?php
global $wpdb;
global $tableprefix;
$tableprefix = $wpdb->prefix;
$exam_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "exams" );
$student_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );
echo 'Menage Exams';
?>
<h2>Exams for student: 
<select>
	<option>- - - - - - - -</option>
	<?php
		foreach ($student_results as $student) {
			echo '<option value="' .$student->id. '">'. $student->name.'</option>';
		}
	?>
</select>
</h2>
<table>
 <thead>
 <tr>
 <th>Exam name</th>
 <th>Exam date</th>
 <th>Exam mark</th>
 </tr>
 </thead>
 <tbody>
 <?php
 	foreach ($exam_results as $result) {
 		echo '
 		<tr>
			<td>'. $result->exam_name .'</td>
			<td>'. $result->date_of_exam .'</td>
			<td>'. $result->mark .'<td>
			<td>edit</td>
			<td>remove</td>
		</tr>
		';
 	}
 ?>
 </tbody>
</table>