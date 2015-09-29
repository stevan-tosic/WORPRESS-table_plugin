<?php
$exam = new Exam();

$name = $_POST['name'];
$b_date = date_create($_POST['date']);
$date = date_format($b_date, "Y-m-d");
$mark = $_POST['mark'];
$student_id = $_POST['student_id'];
$exam_id = $_POST['exam_id'];
$exam_update = $_POST['id'];
/*
 * Updating exam if variable $exam_update got value or inserting a new row if is empty
 * 
 */	
if ( empty($exam_update) || is_null($exam_update) ) {
	if ( !empty($student_id) && !empty($name) && !empty($date) && !empty($mark) && !is_null($student_id) && !is_null($name) && !is_null($date) && !is_null($mark) ) {
		add_action( 'insert_exams', $exam->add_to_exams( $student_id, $name, $date, $mark) );
		unset($student_id, $name, $date, $mark);
	}
/*
 * Updating row by number of ID
 * 
 */ 
} else if (!empty($student_id) && !empty($name) && !empty($date) && !empty($mark) && !is_null($student_id) && !is_null($name) && !is_null($date) && !is_null($mark) ) {
	add_action( 'update_exam', $exam->update_exams( $exam_update, $student_id, $name, $date, $mark) );
	unset( $exam_update, $student_id, $name, $date, $mark );
}
/*
 * Deleting row by number of ID
 * 
 */	
if ( !empty($exam_id) && !is_null($exam_id) ) {
  add_action( 'remove_exam', $exam->remove_from_exams( $exam_id ) );
  unset($exam_id);
}

global $wpdb;
global $tableprefix;
$tableprefix = $wpdb->prefix;
$exam_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "exams" );
$student_results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );
echo 'Menage Exams';
?>
<div id="exams">
<div id="dialog-confirm" title="Remove this exam?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This exam will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

<div id="dialog-form" title="Create new exam">
  <p class="validateTips">All form fields are required.</p>
<form>
	Exam name: 		<input type="text" name="name" id="ename"><br>
	Exam Date:		<input type="text" name="date" id="edate" readonly><br>
	Exam Mark:		<input type="text" name="mark" id="mark"><br>
</form>
</div>

<div id="users-contain" class="ui-widget">
<form id="select_student_form">
  <h2>Exams for student: 
<select id="select_student">
	<option value="0" selected>- - - - - - - -</option>
	<?php
		foreach ($student_results as $student) {
			echo '<option value="' .$student->id. '">'. $student->name.'</option>';
		}
	?>
</select>
</h2>
</form>
  <table id="exams" class="ui-widget ui-widget-content">
    <thead>
      <tr class="ui-widget-header ">
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
			<td><button class="create-user" data-exam_id="' . $result->id. '">edit</button></td>
			<td><button class="remove-input" data-exam_id="' . $result->id. '">remove</button></td>
		</tr>
		';
 	}
 ?>
 </tbody>
  </table>
</div>
<button class="create-user">Create new exam</button>

</div>