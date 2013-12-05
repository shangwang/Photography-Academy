<?php

//  Display the course home page.

    require_once('../config.php');
    require_once('lib.php');
    require_once($CFG->dirroot.'/mod/forum/lib.php');
    require_once($CFG->libdir.'/conditionlib.php');
    require_once($CFG->libdir.'/completionlib.php');

    $id          = optional_param('id', 0, PARAM_INT);
    $name        = optional_param('name', '', PARAM_RAW);
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
	<h2 >Photo of the Week</h2>
	<h1>Meadow of Yellow Flowers and Mountains</h1>

</div>
				
<div id="content_top">
  
	   
	   
    <div id="pod_right">
			<p class="publication_time">November 21, 2013</p>
			
    </div>
 
    <div class="primary_photo">
	<!--
		<a href="image/photo of the week" title="Go to the previous Photo of the Day">

    -->
	       <img src="image/photo of the week/1.jpg" width="600" height="442" alt="Landscape">	


		</a>
	</div><!-- .primary_photo-->
	<div>
	    <a href="ph_submit.php">
		  <p>Next Week</p>
		</a>
	</div>
</div>

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
?>


<head>
    <meta charset=utf-8 />

    <!-- Website Design By: www.happyworm.com -->
    <title>Demo : jPlayer as an audio playlist player</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="../js/jplayer.playlist.min.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                {
                    title:"Time for a nap",
                    mp3:"../Shang/BackgroundMusics/Time.mp3"

                },
                {
                    title:"Solitude",
                    mp3:"../Shang/BackgroundMusics/Solitude.mp3"

                },
                {
                    title:"Bicycle Tricycle",
                    mp3:"../Shang/BackgroundMusics/Bicycle Tricycle.m4a"

                },
                {
                    title:"Have You Seen My Love",
                    mp3:"../Shang/BackgroundMusics/Have You Seen My Love.m4a"
                },

                {
                    title:"Naruto's day",
                    mp3:"../Shang/BackgroundMusics/Naruto's day.mp3"

                },
                {
                    title:"Alone",
                    mp3:"../Shang/BackgroundMusics/Alone.mp3"
                }
            ], {
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
        });
        //]]>
    </script>
</head>
<body>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>

<div id="jp_container_1" class="jp-audio">
    <div class="jp-type-playlist">
        <div class="jp-gui jp-interface">
            <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
            </ul>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
            </div>
            <div class="jp-time-holder">
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>
            </div>
            <ul class="jp-toggles">
                <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
                <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
                <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
            </ul>
        </div>
        <div class="jp-playlist">
            <ul>
                <li></li>
            </ul>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
</body>