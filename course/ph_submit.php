<?php

//  Display the course home page.

    require_once('../config.php');
    require_once('lib.php');
    require_once($CFG->dirroot.'/mod/forum/lib.php');
    require_once($CFG->libdir.'/conditionlib.php');
    require_once($CFG->libdir.'/completionlib.php');

    $id          = optional_param('id', 0, PARAM_INT);
    $name        = optional_param('name', 'photo-101', PARAM_RAW);
    $edit        = optional_param('edit', -1, PARAM_BOOL);
    $hide        = optional_param('hide', 0, PARAM_INT);
    $show        = optional_param('show', 0, PARAM_INT);
    $idnumber    = optional_param('idnumber', '', PARAM_RAW);
    $sectionid   = optional_param('sectionid', 0, PARAM_INT);
    $section     = optional_param('section', 0, PARAM_INT);
    $move        = optional_param('move', 0, PARAM_INT);
    $marker      = optional_param('marker',-1 , PARAM_INT);
    $switchrole  = optional_param('switchrole',-1, PARAM_INT); // Deprecated, use course/switchrole.php instead.
    $modchooser  = optional_param('modchooser', -1, PARAM_BOOL);
    $return      = optional_param('return', 0, PARAM_LOCALURL);

    $params = array();
	
    if (!empty($name)) {
        $params = array('shortname' => $name);
    } else if (!empty($idnumber)) {
        $params = array('idnumber' => $idnumber);
    } else if (!empty($id)) {
        $params = array('id' => $id);
    }else {
        print_error('unspecifycourseid', 'error');
    }
	

    $course = $DB->get_record('course', $params, '*', MUST_EXIST);

    $urlparams = array('id' => $course->id);

    // Sectionid should get priority over section number
    if ($sectionid) {
        $section = $DB->get_field('course_sections', 'section', array('id' => $sectionid, 'course' => $course->id), MUST_EXIST);
    }
    if ($section) {
        $urlparams['section'] = $section;
    }

    $PAGE->set_url('/course/view.php', $urlparams); // Defined here to avoid notices on errors etc

    // Prevent caching of this page to stop confusion when changing page after making AJAX changes
    $PAGE->set_cacheable(false);

    preload_course_contexts($course->id);
    $context = context_course::instance($course->id, MUST_EXIST);

    // Remove any switched roles before checking login
    if ($switchrole == 0 && confirm_sesskey()) {
        role_switch($switchrole, $context);
    }

    require_login($course);

    // Switchrole - sanity check in cost-order...
    $reset_user_allowed_editing = false;
    if ($switchrole > 0 && confirm_sesskey() &&
        has_capability('moodle/role:switchroles', $context)) {
        // is this role assignable in this context?
        // inquiring minds want to know...
        $aroles = get_switchable_roles($context);
        if (is_array($aroles) && isset($aroles[$switchrole])) {
            role_switch($switchrole, $context);
            // Double check that this role is allowed here
            require_login($course);
        }
        // reset course page state - this prevents some weird problems ;-)
        $USER->activitycopy = false;
        $USER->activitycopycourse = NULL;
        unset($USER->activitycopyname);
        unset($SESSION->modform);
        $USER->editing = 0;
        $reset_user_allowed_editing = true;
    }

    //If course is hosted on an external server, redirect to corresponding
    //url with appropriate authentication attached as parameter
    if (file_exists($CFG->dirroot .'/course/externservercourse.php')) {
        include $CFG->dirroot .'/course/externservercourse.php';
        if (function_exists('extern_server_course')) {
            if ($extern_url = extern_server_course($course)) {
                redirect($extern_url);
            }
        }
    }


    require_once($CFG->dirroot.'/calendar/lib.php');    /// This is after login because it needs $USER

    $logparam = 'id='. $course->id;
    $loglabel = 'view';
    $infoid = $course->id;
    if ($section and $section > 0) {
        $loglabel = 'view section';

        // Get section details and check it exists.
        $modinfo = get_fast_modinfo($course);
        $coursesections = $modinfo->get_section_info($section, MUST_EXIST);

        // Check user is allowed to see it.
        if (!$coursesections->uservisible) {
            // Note: We actually already know they don't have this capability
            // or uservisible would have been true; this is just to get the
            // correct error message shown.
            require_capability('moodle/course:viewhiddensections', $context);
        }
        $infoid = $coursesections->id;
        $logparam .= '&sectionid='. $infoid;
    }
    add_to_log($course->id, 'course', $loglabel, "view.php?". $logparam, $infoid);

    // Fix course format if it is no longer installed
    $course->format = course_get_format($course)->get_format();

    $PAGE->set_pagelayout('course');
    $PAGE->set_pagetype('course-view-' . $course->format);
    $PAGE->set_other_editing_capability('moodle/course:update');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_other_editing_capability('moodle/course:activityvisibility');
    if (course_format_uses_sections($course->format)) {
        $PAGE->set_other_editing_capability('moodle/course:sectionvisibility');
        $PAGE->set_other_editing_capability('moodle/course:movesections');
    }

    // Preload course format renderer before output starts.
    // This is a little hacky but necessary since
    // format.php is not included until after output starts
    if (file_exists($CFG->dirroot.'/course/format/'.$course->format.'/renderer.php')) {
        require_once($CFG->dirroot.'/course/format/'.$course->format.'/renderer.php');
        if (class_exists('format_'.$course->format.'_renderer')) {
            // call get_renderer only if renderer is defined in format plugin
            // otherwise an exception would be thrown
            $PAGE->get_renderer('format_'. $course->format);
        }
    }

    if ($reset_user_allowed_editing) {
        // ugly hack
        unset($PAGE->_user_allowed_editing);
    }

    if (!isset($USER->editing)) {
        $USER->editing = 0;
    }
    if ($PAGE->user_allowed_editing()) {
        if (($edit == 1) and confirm_sesskey()) {
            $USER->editing = 1;
            // Redirect to site root if Editing is toggled on frontpage
            if ($course->id == SITEID) {
                redirect($CFG->wwwroot .'/?redirect=0');
            } else if (!empty($return)) {
                redirect($CFG->wwwroot . $return);
            } else {
                $url = new moodle_url($PAGE->url, array('notifyeditingon' => 1));
                redirect($url);
            }
        } else if (($edit == 0) and confirm_sesskey()) {
            $USER->editing = 0;
            if(!empty($USER->activitycopy) && $USER->activitycopycourse == $course->id) {
                $USER->activitycopy       = false;
                $USER->activitycopycourse = NULL;
            }
            // Redirect to site root if Editing is toggled on frontpage
            if ($course->id == SITEID) {
                redirect($CFG->wwwroot .'/?redirect=0');
            } else if (!empty($return)) {
                redirect($CFG->wwwroot . $return);
            } else {
                redirect($PAGE->url);
            }
        }
        if (($modchooser == 1) && confirm_sesskey()) {
            set_user_preference('usemodchooser', $modchooser);
        } else if (($modchooser == 0) && confirm_sesskey()) {
            set_user_preference('usemodchooser', $modchooser);
        }

        if (has_capability('moodle/course:sectionvisibility', $context)) {
            if ($hide && confirm_sesskey()) {
                set_section_visible($course->id, $hide, '0');
                redirect($PAGE->url);
            }

            if ($show && confirm_sesskey()) {
                set_section_visible($course->id, $show, '1');
                redirect($PAGE->url);
            }
        }

        if (!empty($section) && !empty($move) &&
                has_capability('moodle/course:movesections', $context) && confirm_sesskey()) {
            $destsection = $section + $move;
            if (move_section_to($course, $section, $destsection)) {
                if ($course->id == SITEID) {
                    redirect($CFG->wwwroot . '/?redirect=0');
                } else {
                    redirect(course_get_url($course));
                }
            } else {
                echo $OUTPUT->notification('An error occurred while moving a section');
            }
        }
    } else {
        $USER->editing = 0;
    }

    $SESSION->fromdiscussion = $PAGE->url->out(false);


    if ($course->id == SITEID) {
        // This course is not a real course.
        redirect($CFG->wwwroot .'/');
    }

    $completion = new completion_info($course);
    if ($completion->is_enabled() && ajaxenabled()) {
        $PAGE->requires->string_for_js('completion-title-manual-y', 'completion');
        $PAGE->requires->string_for_js('completion-title-manual-n', 'completion');
        $PAGE->requires->string_for_js('completion-alt-manual-y', 'completion');
        $PAGE->requires->string_for_js('completion-alt-manual-n', 'completion');

        $PAGE->requires->js_init_call('M.core_completion.init');
    }

    // We are currently keeping the button here from 1.x to help new teachers figure out
    // what to do, even though the link also appears in the course admin block.  It also
    // means you can back out of a situation where you removed the admin block. :)
    if ($PAGE->user_allowed_editing()) {
        $buttons = $OUTPUT->edit_button($PAGE->url);
        $PAGE->set_button($buttons);
    }

    $PAGE->set_title(get_string('course') . ': ' . $course->fullname);
    $PAGE->set_heading($course->fullname);
    echo $OUTPUT->header();
	/*****************************************************************/
	$image = "image/1.jpg";
	/*  
$width = 500;
$height = 300;
*/
echo '
<html>
<div id="page_head" align = "middle"> 
	<h2 >Topic for next week</h2>
	<h1>Bridge</h1>

</div>
				

<!----------------------------------part1 begin--------------------------------------->
<div id="step1">

  <h3 id="steptitle1" class="steptitle">
   
Description:
   </h3>
   
  <div id="stepcontent1" class="stepcontent">
  
     
   
     




<div class="field">
  <div style="color:#000000">  
  "In photography there is no real representation, as the mechanics of the camera lens differ greatly from the human eye. Therefore there is no true color, context, angle, field of vision, focus, scale, etc. in a photograph.
This allows a photograph to be taken in such a way as to encourage an alternate perception of its commonly accepted reality; to question and evaluate how and why we insist on constraining our perception to one reality when there are infinite possibilities and when, in some way, reality either ceases to exist or never existed to begin with."
  </div>
    <span class="fieldErrorText"></span>
  
</div>


<li>
<div class="label">
          Instructions
    </div>

<div class="field">
  <div class="vtbegenerated"><p>Submit your deliverable as a zip file here. Make sure you have all the submission materials inside the zip file. One submission per group is sufficient.</p>
<p>Submission materials are:</p>
<ol>
<li>A photo.</li>
<li>A paragraph explaining.</li>

</ol>

    <span class="fieldErrorText"></span>
  
</div>
</li> 

<li>
<div class="label">
          Due Date
    </div>

<div class="field">
    <input type="hidden" name="dueDate" id="dueDate" value="Thursday, November 21, 2013 11:59:00 PM MST">
  A week after the start date.

    <span class="fieldErrorText"></span>
  
</div>
</li> 


   </ol>
  </div>
  
 </div>
<!-------------------------part1 end------------------------------>
<!------------------------------part2--------------------------->
<div id="step2">
  <h3 id="steptitle2" class="steptitle">
  
Submission
   </h3>
   
  <div id="stepcontent2" class="stepcontent">
   
     
   
    
 
 <div class="field">
      <div class="fileInputWrapper">
   <label for="newFile_chooseLocalFile" class="hideoff">Attach Local File</label>
   <input class="hiddenInput" type="file" id="newFile_chooseLocalFile" title="Browse My Computer">
   
  </div>
           </div> 

  <li id="newFile_listHtmlDiv" style="display:none;">
  <div class="label">
   Attached files
  </div>
  <div class="noLabelField">
   <table class="attachments" id="newFile_table" summary="This is a table showing the attributes of a collection of items.">
 <thead>
  
                        
    
  <tr>
     <th scope="col" class="" align="LEFT">File Name</th>
   <th scope="col" class="" align="LEFT">Link Title</th>
   <th scope="col" class="" align="LEFT"></th>
   </tr>
 </thead>
 <tbody id="newFile_table_body"> 
  </tbody>
</table>

     </div>

 






<!-- End textbox -->
     
  
    <span class="fieldErrorText"></span>
  


  
  </div>
  
 </div>
 <!-------------------------------part2 end------------------------------->
 <!------------------------------part3 begin-------------------------------->
 <div id="step3">
  <h3 id="steptitle3" class="steptitle">
  
Add Comments
   </h3>
   
  <div id="stepcontent3" class="stepcontent">

<div class="label label-stack">
        <label for="student_commentstext">
      Comments
    </label>
    </div>

<div class="noLabelField">
  
   <textarea rows="10" cols="100">
 
</textarea>



<!-- End textbox -->
     
  
   
  
</div>

  </div>
  
 </div>
 <!------------------------------part3 end-------------------------------------->
 <!--------------------------------top 3 ---------------------->
<h3>Top 3 photos</h3>
<table border="0">
<tr>
<td><img src="image/photo of the week/1.1.jpg" width="250" height="200" alt="3">	</td>
<td><img src="image/photo of the week/2.1.jpg" width="250" height="200" alt="4">	</td>
<td><img src="image/photo of the week/3.1.jpg" width="250" height="200" alt="5">	</td>
</tr>

</table>
<div>
	    <a href="ph_showAll.php">
		  <p>Show All</p>
		</a>
	</div>
<!-------------------------------top 3 end---------------------------->
</html>
';
    /*****************************************************************/
    if ($completion->is_enabled() && ajaxenabled()) {
        // This value tracks whether there has been a dynamic change to the page.
        // It is used so that if a user does this - (a) set some tickmarks, (b)
        // go to another page, (c) clicks Back button - the page will
        // automatically reload. Otherwise it would start with the wrong tick
        // values.
        echo html_writer::start_tag('form', array('action'=>'.', 'method'=>'get'));
        echo html_writer::start_tag('div');
        echo html_writer::empty_tag('input', array('type'=>'hidden', 'id'=>'completion_dynamic_change', 'name'=>'completion_dynamic_change', 'value'=>'0'));
        echo html_writer::end_tag('div');
        echo html_writer::end_tag('form');
    }

    // Course wrapper start.
    echo html_writer::start_tag('div', array('class'=>'course-content'));

    // make sure that section 0 exists (this function will create one if it is missing)
    course_create_sections_if_missing($course, 0);

    // get information about course modules and existing module types
    // format.php in course formats may rely on presence of these variables
    $modinfo = get_fast_modinfo($course);
    $modnames = get_module_types_names();
    $modnamesplural = get_module_types_names(true);
    $modnamesused = $modinfo->get_used_module_names();
    $mods = $modinfo->get_cms();
    $sections = $modinfo->get_section_info_all();

    // CAUTION, hacky fundamental variable defintion to follow!
    // Note that because of the way course fromats are constructed though
    // inclusion we pass parameters around this way..
    $displaysection = $section;

    // Include the actual course format.
    require($CFG->dirroot .'/course/format/'. $course->format .'/format.php');
    // Content wrapper end.

    echo html_writer::end_tag('div');

    // Include course AJAX
    include_course_ajax($course, $modnamesused);

    echo $OUTPUT->footer();