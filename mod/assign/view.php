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

/**
 * This file is the entry point to the assign module. All pages are rendered from here
 *
 * @package   mod_assign
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

$id = required_param('id', PARAM_INT);

$urlparams = array('id' => $id,
                  'action' => optional_param('action', '', PARAM_TEXT),
                  'rownum' => optional_param('rownum', 0, PARAM_INT),
                  'useridlistid' => optional_param('action', 0, PARAM_INT));

$url = new moodle_url('/mod/assign/view.php', $urlparams);
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, true, $cm);
$PAGE->set_url($url);

$context = context_module::instance($cm->id);

require_capability('mod/assign:view', $context);

$assign = new assign($context, $cm, $course);

$completion=new completion_info($course);
$completion->set_module_viewed($cm);

// Get the assign class to
// render the page.
echo $assign->view(optional_param('action', '', PARAM_TEXT));



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
				playlistOptions: {
    			autoPlay: true
  				},
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
				playlistOptions: {
    			autoPlay: true
  				},
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
                    title:"Wake Up",
                    mp3:"../../Shang/BackgroundMusics/Waker Up.mp3"

                },
                {
                    title:"Hello",
                    mp3:"../../Shang/BackgroundMusics/Hello.mp3"

                },
                {
                    title:"Flow",
                    mp3:"../../Shang/BackgroundMusics/Flow.m4a"

                }
            ], {
				playlistOptions: {
    			autoPlay: true
  				},
                swfPath: "js",
                supplied: "oga, mp3",
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true
            });
			$(document).jPlayer("play");
        });
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
                    title:"Flow",
                    mp3:"../../Shang/BackgroundMusics/Flow.m4a"

                }
            ], {
				playlistOptions: {
    			autoPlay: true
  				},
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