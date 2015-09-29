/*
 *  Calling jQuery and preventing conflict with any other JavaScript libraries
 *
 */
jQuery(document).ready(function ($){
var student_id;
$( "#dialog-confirm" ).hide();
$("select").change(function(){
	student_id = ($( "#select_student option:selected" ).val());
});
$(function() {
	    $( "#edate" ).datepicker({
	      showOn: "button",
	      buttonImage: "http://hire-me.in.rs/WORDPRESS/wp-content/plugins/table_plugin/images/calendar.gif",
	      buttonImageOnly: true,
	      buttonText: "Select date"
	    });

	    $( "#bdate" ).datepicker({
	      showOn: "button",
	      buttonImage: "http://hire-me.in.rs/WORDPRESS/wp-content/plugins/table_plugin/images/calendar.gif",
	      buttonImageOnly: true,
	      buttonText: "Select date"
	    });
	  });


	 $(function() {
	    var dialog, form, form_s, dialog_s,
	 	  
	 	  student = $( "option:selected" ),
	      name_s = $( "#sname" ),
	      date_s = $( "#bdate" ),
	      name_e = $( "#ename" ),
	      date_e = $( "#edate" ),
	      mark = $( "#mark" ),
	      allFields = $( [] ).add( name_e ).add( date_e ).add( mark ).add( student ),
	      allFields_s = $( [] ).add( name_s ).add( date_s ),
	      tips = $( ".validateTips" );
	 
	    function updateTips( t ) {
	      tips
	        .text( t )
	        .addClass( "ui-state-highlight" );
	      setTimeout(function() {
	        tips.removeClass( "ui-state-highlight", 1500 );
	      }, 500 );
	    }
	 
	    function checkLength( o, n, min, max ) {
	      if ( o.val().length > max || o.val().length < min ) {
	        o.addClass( "ui-state-error" );
	        updateTips( "Length of " + n + " must be between " +
	          min + " and " + max + "." );
	        return false;
	      } else {
	        return true;
	      }
	    }

	    function is_selected() {
	      if ( student_id === 0 ) {
	      	alert("radi");
	        o.addClass( "ui-state-error" );
	        updateTips( "You must select student!" );
	        return false;
	      } else {
	        return true;
	      }
	    }
	 
	    function checkRegexp( o, regexp, n ) {
	      if ( !( regexp.test( o.val() ) ) ) {
	        o.addClass( "ui-state-error" );
	        updateTips( n );
	        return false;
	      } else {
	        return true;
	      }
	    }
/*
 * Logic for insert new exam
 * 
 */	 
	    function addExam() {
	      var valid_e = true;
	      allFields.removeClass( "ui-state-error" );
	      
	      valid_e = valid_e && checkLength( name_e, "exam name", 4, 15 );
	      valid_e = valid_e && checkRegexp( name_e, /^[a-zA-Z\s]*$/, "Exam name must contain only letters" );
	      valid_e = valid_e && checkLength( date_e, "date", 10, 10 );
	      valid_e = valid_e && checkLength( mark, "mark", 0, 1 );
	      valid_e = valid_e && checkRegexp( mark, /^\d+$/, "Mark can contain only grade between 0 and 5" );
	      valid_e = valid_e && is_selected();
	      
	      if ( valid_e ) {
	      	$.ajax({
	      		url: window.location.href/*'../wp-content/plugins/table_plugin/table.php'*/,
	      		type : 'POST',
	      		data: { 
	      			student_id : student_id,
	      			name: name_e.val(), 
	      			date: date_e.val(),
	      			mark: mark.val()
	      		},
	      		cache: false,
	      		success: function (results) {},
	      		error: function (results) {
	      			window.alert("Whoops. . . Something went wrong.");
	      		}
	      	});
	        $( "#exams tbody" ).append( "<tr>" +
	          "<td>" + name_e.val() + "</td>" +
	          "<td>" + date_e.val() + "</td>" +
	          "<td>" + mark.val() + "</td>" +
	        "</tr>" );

	        dialog.dialog( "close" );
	      }
	      return valid_e;
	    }
/*
 * Logic for insert new exam
 * 
 */	 
	    function updateExam() {
	      var valid_e = true;
	      allFields.removeClass( "ui-state-error" );
	      
	      valid_e = valid_e && checkLength( name_e, "exam name", 4, 15 );
	      valid_e = valid_e && checkRegexp( name_e, /^[a-zA-Z\s]*$/, "Exam name must contain only letters" );
	      valid_e = valid_e && checkLength( date_e, "date", 10, 10 );
	      valid_e = valid_e && checkLength( mark, "mark", 0, 1 );
	      valid_e = valid_e && checkRegexp( mark, /^\d+$/, "Mark can contain only grade between 0 and 5" );
	      valid_e = valid_e && is_selected();
	      
	      if ( valid_e ) {
	      	$.ajax({
	      		url: window.location.href/*'../wp-content/plugins/table_plugin/table.php'*/,
	      		type : 'POST',
	      		data: { 
	      			id : exam,
	      			student_id : student_id,
	      			name: name_e.val(), 
	      			date: date_e.val(),
	      			mark: mark.val()
	      		},
	      		cache: false,
	      		success: function (results) {
	      			location.reload();
	      		},
	      		error: function (results) {
	      			window.alert("Whoops. . . Something went wrong.");
	      		}
	      	});
	        dialog.dialog( "close" );
	      }
	      return valid_e;
	    }
/*
 * Logic for insert new student
 * 
 */
	    function addStudent() {
	      var valid_s = true;
	      allFields_s.removeClass( "ui-state-error" );
	      
	      valid_s = valid_s && checkLength( name_s, "student name", 7, 30 );
	      valid_s = valid_s && checkRegexp( name_s, /^[a-zA-Z\s]*$/, "Student name must contain only letters" );
	      valid_s = valid_s && checkLength( date_s, "date", 10, 10 );
	      
	      if ( valid_s ) {
	      	$.ajax({
	      		url: window.location.href/*'../wp-content/plugins/table_plugin/table.php'*/,
	      		type : 'POST',
	      		data: { 
	      			name: name_s.val(), 
	      			date: date_s.val() 
	      		},
	      		cache: false,
	      		success: function (results) {},
	      		error: function (results) {
	      			window.alert("Whoops. . . Something went wrong.");
	      		}
	      	});
	        $( "#students tbody" ).append( "<tr>" +
	          "<td>" + name_s.val() + "</td>" +
	          "<td>" + date_s.val() + "</td>" +
	        "</tr>" );

	        dialog_s.dialog( "close" );
	      }
	      return valid_s;
	    }
/*
 * Logic for update old student input
 * 
 */
	     function updateStudent() {
	      var valid_s = true;
	      allFields_s.removeClass( "ui-state-error" );
	      
	      valid_s = valid_s && checkLength( name_s, "student name", 7, 30 );
	      valid_s = valid_s && checkRegexp( name_s, /^[a-zA-Z\s]*$/, "Student name must contain only letters" );
	      valid_s = valid_s && checkLength( date_s, "date", 10, 10 );
	      
	      if ( valid_s ) {
	      	$.ajax({
	      		url: window.location.href/*'../wp-content/plugins/table_plugin/table.php'*/,
	      		type : 'POST',
	      		data: { 
	      			id : student,
	      			name: name_s.val(), 
	      			date: date_s.val() 
	      		},
	      		cache: false,
	      		success: function (results) {
	      			location.reload();
	      		},
	      		error: function (results) {
	      			window.alert("Whoops. . . Something went wrong.");
	      		}
	      	});
	        dialog_s_u.dialog( "close" );
	      }
	      return valid_s;
	    }
/*
 * Dialog for insert new exam
 * 
 */
	    dialog = $( "#dialog-form" ).dialog({
	      autoOpen: false,
	      height: 300,
	      width: 350,
	      modal: true,
	      buttons: {
	        "Create": addExam,
	        Cancel: function() {
	          dialog.dialog( "close" );
	        }
	      },
	      close: function() {
	        form[ 0 ].reset();
	        allFields.removeClass( "ui-state-error" );
	      }
	    });
/*
 * Dialog for insert new student
 * 
 */
	     dialog_s = $( "#dialog-form_s" ).dialog({
	      autoOpen: false,
	      height: 300,
	      width: 350,
	      modal: true,
	      buttons: {
	        "Create": addStudent,
	        Cancel: function() {
	          dialog_s.dialog( "close" );
	        }
	      },
	      close: function() {
	        form_s[ 0 ].reset();
	        allFields_s.removeClass( "ui-state-error" );
	      }
	    });
/*
 * Dialog for updating old student input
 * 
 */
	     dialog_s_u = $( "#dialog-form_s" ).dialog({
	      autoOpen: false,
	      height: 300,
	      width: 350,
	      modal: true,
	      buttons: {
	        "Create": updateStudent,
	        Cancel: function() {
	          dialog_s_u.dialog( "close" );
	        }
	      },
	      close: function() {
	        form_s[ 0 ].reset();
	        allFields_s.removeClass( "ui-state-error" );
	      }
	    });
	 
	    form = dialog.find( "form" ).on( "submit", function( event ) {
	      event.preventDefault();
	      addExam();
	    });

	    form_s = dialog_s.find( "form" ).on( "submit", function( event ) {
	      event.preventDefault();
	      addStudent();
	    });
/*
 * jQuery inicial for creating new exam dialog form
 * 
 */
	    $( ".create-user" ).button().on( "click", function() {
	      dialog.dialog( "open" );
	    });
/*
 * jQuery inicial for updating old exam input dialog form
 * 
 */
	     $( ".update-exam" ).button().on( "click", function() {
	     	var exam 	= ($( this ).data('exam_id'));
	      	dialog.dialog( "open" );
	    });
/*
 * jQuery inicial for creating new student dialog form
 * 
 */
	    $( ".create-student" ).button().on( "click", function() {
	      dialog_s.dialog( "open" );
	    });
/*
 * jQuery inicial for updating old student input dialog form
 * 
 */
	     $( ".update-student" ).button().on( "click", function() {
	     	var student = ($( this ).data('student_id'));
	    	dialog_s.dialog( "open" );
	    });
	  });
/*
 * Remove user input
 *
 */
	$( ".remove-input" ).click(function() {
		var student = ($( this ).data('student_id'));
		var exam 	= ($( this ).data('exam_id'));
    	$( "#dialog-confirm" ).dialog({
	      resizable: false,
	      height:140,
	      modal: true,
	      buttons: {
	        "Remove exam": function() {
	        	$.ajax({
	      		url: window.location.href/*'../wp-content/plugins/table_plugin/table.php'*/,
	      		type : 'POST',
	      		data: { 
	      			student_id_rem: student, 
	      			exam_id: exam 
	      		},
	      		cache: false,
	      		success: function (results) {
	      			location.reload();
	      		},
	      		error: function (results) {
	      			window.alert("Whoops. . . Something went wrong.");
	      		}
	      	});
	          $( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	  });
});