<?php
global $wpdb;
global $tableprefix;
$tableprefix = $wpdb->prefix;
$results = $wpdb->get_results( "SELECT * FROM " . $tableprefix . "students" );
echo 'Menage Students';
?>
<div>
<h2>Student list</h2>
<table>
 <thead>
 <tr>
 <th>Student name</th>
 <th>Birth date</th>
 </tr>
 </thead>
 <tbody>
 <?php
 	foreach ($results as $result) {
 		echo '
 		<tr>
			<td>'. $result->name .'</td>
			<td>'. $result->date_of_birth .'</td>
			<td>edit</td>
			<td>remove</td>
		</tr>
		';
 	}
 ?>
 </tbody>
</table>
</div>