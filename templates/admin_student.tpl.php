<?php
$student = new Student();

$s_name = $_POST['name'];
$date = date_create($_POST['date']);
$s_date = date_format($date, "Y-m-d");
$student_id = $_POST['student_id_rem'];
$student_update = $_POST['id'];
/*
 * Updating exam if variable $student_update got value or inserting a new row if is empty
 * 
 */ 
if ( empty($student_update) || is_null($student_update) ) {
  if ( !empty($s_name) && !empty($s_date) && !is_null($s_name) && !is_null($s_date) ) {
    add_action( 'insert_students', $student->add_to_students($s_name, $s_date) );
    unset($e_name, $e_date);
  }
/*
 * Updating row by number of ID
 * 
 */ 
} else if ( !empty($s_name) && !empty($s_date) && !is_null($s_name) && !is_null($s_date) ) {
  add_action( 'update_student', $student->update_students($student_id, $s_name, $s_date) );
    unset($e_name, $e_date);
}
/*
 * Deleting row by number of ID
 * 
 */ 
if ( !empty($student_id) && !is_null($student_id) ) {
  add_action( 'remove_student', $student->remove_from_students( $student_id ) );
  unset($student_id);
}

global $wpdb;
global $tableprefix;
$tableprefix = $wpdb->prefix;
$results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );

echo "($obj)";
echo 'Menage Students';
?>
<div id="students">

<div id="dialog-confirm" title="Remove this student?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This student will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

<div id="dialog-form_s" title="Create new student">
  <p class="validateTips">All form fields are required.</p>
<form action="../table.php" method="post">
	Student name: 	<input type="text" name="name" id="sname"><br>
	Birth Date:		  <input type="text" name="date" id="bdate" readonly><br>
</form>
</div>

<div id="users-contain" class="ui-widget">
  <h2>Students list</h2>
  <table id="students" class="ui-widget ui-widget-content">
    <thead>
      <tr class="ui-widget-header ">
        <th>Student name</th>
		<th>Birth Date</th>
      </tr>
    </thead>
   <tbody>
 <?php
 	foreach ($results as $result) {
 		echo '
 		<tr>
			<td>'. $result->name .'</td>
			<td>'. $result->date_of_birth .'</td>
			<td><button class="update-student" data-student_id="' . $result->id. '">edit</button></td>
			<td><button class="remove-input" data-student_id="' . $result->id. '">remove</button></td>
		</tr>
		';
 	}
 ?>
  </tbody>
  </table>
</div>
<button class="create-student">Create new student</button>

</div>