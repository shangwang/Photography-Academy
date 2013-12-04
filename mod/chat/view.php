<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/// This page prints a particular instance of chat

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/mod/chat/lib.php');
require_once($CFG->libdir . '/completionlib.php');

$id   = optional_param('id', 0, PARAM_INT);
$c    = optional_param('c', 0, PARAM_INT);
$edit = optional_param('edit', -1, PARAM_BOOL);

if ($id) {
    if (! $cm = get_coursemodule_from_id('chat', $id)) {
        print_error('invalidcoursemodule');
    }

    if (! $course = $DB->get_record('course', array('id'=>$cm->course))) {
        print_error('coursemisconf');
    }

    chat_update_chat_times($cm->instance);

    if (! $chat = $DB->get_record('chat', array('id'=>$cm->instance))) {
        print_error('invalidid', 'chat');
    }

} else {
    chat_update_chat_times($c);

    if (! $chat = $DB->get_record('chat', array('id'=>$c))) {
        print_error('coursemisconf');
    }
    if (! $course = $DB->get_record('course', array('id'=>$chat->course))) {
        print_error('coursemisconf');
    }
    if (! $cm = get_coursemodule_from_instance('chat', $chat->id, $course->id)) {
        print_error('invalidcoursemodule');
    }
}

require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
$PAGE->set_context($context);

// show some info for guests
if (isguestuser()) {
    $PAGE->set_title(format_string($chat->name));
    echo $OUTPUT->header();
    echo $OUTPUT->confirm('<p>'.get_string('noguests', 'chat').'</p>'.get_string('liketologin'),
            get_login_url(), $CFG->wwwroot.'/course/view.php?id='.$course->id);

    echo $OUTPUT->footer();
    exit;
}

add_to_log($course->id, 'chat', 'view', "view.php?id=$cm->id", $chat->id, $cm->id);

$strenterchat    = get_string('enterchat', 'chat');
$stridle         = get_string('idle', 'chat');
$strcurrentusers = get_string('currentusers', 'chat');
$strnextsession  = get_string('nextsession', 'chat');

$courseshortname = format_string($course->shortname, true, array('context' => context_course::instance($course->id)));
$title = $courseshortname . ': ' . format_string($chat->name);

// Mark viewed by user (if required)
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

// Initialize $PAGE
$PAGE->set_url('/mod/chat/view.php', array('id' => $cm->id));
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);

/// Print the page header
echo $OUTPUT->header();

/// Check to see if groups are being used here
$groupmode = groups_get_activity_groupmode($cm);
$currentgroup = groups_get_activity_group($cm, true);
groups_print_activity_menu($cm, $CFG->wwwroot . "/mod/chat/view.php?id=$cm->id");

// url parameters
$params = array();
if ($currentgroup) {
    $groupselect = " AND groupid = '$currentgroup'";
    $groupparam = "&amp;groupid=$currentgroup";
    $params['groupid'] = $currentgroup;
} else {
    $groupselect = "";
    $groupparam = "";
}

echo $OUTPUT->heading(format_string($chat->name));

if ($chat->intro) {
    echo $OUTPUT->box(format_module_intro('chat', $chat, $cm->id), 'generalbox', 'intro');
}

if (has_capability('mod/chat:chat', $context)) {
    /// Print the main part of the page
    echo $OUTPUT->box_start('generalbox', 'enterlink');

    $now = time();
    $span = $chat->chattime - $now;
    if ($chat->chattime and $chat->schedule and ($span>0)) {  // A chat is scheduled
        echo '<p>';
        echo get_string('sessionstart', 'chat', format_time($span));
        echo '</p>';
    }

    $params['id'] = $chat->id;
    $chattarget = new moodle_url("/mod/chat/gui_$CFG->chat_method/index.php", $params);
    echo '<p>';
    echo $OUTPUT->action_link($chattarget, $strenterchat, new popup_action('click', $chattarget, "chat$course->id$chat->id$groupparam", array('height' => 500, 'width' => 700)));
    echo '</p>';

    $params['id'] = $chat->id;
    $link = new moodle_url('/mod/chat/gui_basic/index.php', $params);
    $action = new popup_action('click', $link, "chat{$course->id}{$chat->id}{$groupparam}", array('height' => 500, 'width' => 700));
    echo '<p>';
    echo $OUTPUT->action_link($link, get_string('noframesjs', 'message'), $action, array('title'=>get_string('modulename', 'chat')));
    echo '</p>';

    if ($chat->studentlogs or has_capability('mod/chat:readlog', $context)) {
        if ($msg = $DB->get_records_select('chat_messages', "chatid = ? $groupselect", array($chat->id))) {
            echo '<p>';
            echo html_writer::link(new moodle_url('/mod/chat/report.php', array('id'=>$cm->id)), get_string('viewreport', 'chat'));
            echo '</p>';
        }
    }


    echo $OUTPUT->box_end();

} else {
    echo $OUTPUT->box_start('generalbox', 'notallowenter');
    echo '<p>'.get_string('notallowenter', 'chat').'</p>';
    echo $OUTPUT->box_end();
}

chat_delete_old_users();

if ($chatusers = chat_get_users($chat->id, $currentgroup, $cm->groupingid)) {
    $timenow = time();
    echo $OUTPUT->box_start('generalbox', 'chatcurrentusers');
    echo $OUTPUT->heading($strcurrentusers, 4);
    echo '<table>';
    foreach ($chatusers as $chatuser) {
        $lastping = $timenow - $chatuser->lastmessageping;
        echo '<tr><td class="chatuserimage">';
        $url = new moodle_url('/user/view.php', array('id'=>$chatuser->id, 'course'=>$chat->course));
        echo html_writer::link($url, $OUTPUT->user_picture($chatuser));
        echo '</td><td class="chatuserdetails">';
        echo '<p>'.fullname($chatuser).'</p>';
        echo '<span class="idletime">'.$stridle.': '.format_time($lastping).'</span>';
        echo '</td></tr>';
    }
    echo '</table>';
    echo $OUTPUT->box_end();
}

echo $OUTPUT->footer();
?>


<head>
    <meta charset=utf-8 />

    <!-- Website Design By: www.happyworm.com -->
    <title>Demo : jPlayer as an audio playlist player</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">	</script>
    <script type="text/javascript" src="../../js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="../../js/jplayer.playlist.min.js"></script>
    <script type="text/javascript">
	var assgnId = <?= $id; ?> ; //getting the assignment id.
	
	if (2==assgnId){
		
		 //<![CDATA[
        $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                {
                    title:"Good night",
                    mp3:"../../Shang/BackgroundMusics/Silent Night.mp3"

                },
                {
                    title:"Canon in D",
                    mp3:"../../Shang/BackgroundMusics/Canon.mp3"

                },
                {
                    title:"Bicycle Tricycle",
                    mp3:"../../Shang/BackgroundMusics/Bicycle Tricycle.m4a"

                },
                {
                    title:"Have You Seen My Love",
                    mp3:"../../Shang/BackgroundMusics/Have You Seen My Love.m4a"
                }
            ], {
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
			$(document).jPlayer("play");
        });
	}
	
	else if (5==assgnId){
		
		 //<![CDATA[
        $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                {
                    title:"Kiss the Rain",
                    mp3:"../../Shang/BackgroundMusics/kiss the rain.mp3"

                },
                {
                    title:"River Flows In You",
                    mp3:"../../Shang/BackgroundMusics/River Flows In You.mp3"

                },
                {
                    title:"Have You Seen My Love",
                    mp3:"../../Shang/BackgroundMusics/Have You Seen My Love.m4a"

                }
            ], {
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
			$(document).jPlayer("play");
        });
	}
	else if (3==assgnId){
		
		 //<![CDATA[
        $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                {
                    title:"Wake Up!",
                    mp3:"../../Shang/BackgroundMusics/Waker Up.mp3"

                },
                {
                    title:"Hello",
                    mp3:"../../Shang/BackgroundMusics/Hello.mp3"

                },
                {
                    title:"Flow",
                    mp3:"../../Shang/BackgroundMusics/FLOW.mp3"

                }
            ], {
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
			
        }).jPlayer("play");
	}
	
	else {
		
		
		 //<![CDATA[
        $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                {
                    title:"Wake Up",
                    mp3:"../../Shang/BackgroundMusics/Waker Up.mp3"

                },
                {
                    title:"Hello",
                    mp3:"../../Shang/BackgroundMusics/Hello.mp3"

                },
                {
                    title:"Flows",
                    mp3:"../../Shang/BackgroundMusics/FLOW.mp3"

                }
            ], {
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
			$(document).jPlayer("play");
        });
	}
	
   
        //]]>
    </script>
</head>
<body>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>

<div id="jp_container_1" class="jp-audio" >
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