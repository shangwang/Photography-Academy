<!-- Javascript goes in the document HEAD -->
<script type="text/javascript">
function altRows(id){
	if(document.getElementsByTagName){  
		
		var table = document.getElementById(id);  
		var rows = table.getElementsByTagName("tr"); 
		 
		for(i = 0; i < rows.length; i++){          
			if(i % 2 == 0){
				rows[i].className = "evenrowcolor";
			}else{
				rows[i].className = "oddrowcolor";
			}      
		}
	}
}
window.onload=function(){
	altRows('alternatecolor');
}
</script>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.altrowstable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #a9c6c9;
	border-collapse: collapse;
}
table.altrowstable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.altrowstable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
.oddrowcolor{
	background-color:#d4e3e5;
}
.evenrowcolor{
	background-color:#c3dde0;
}
</style>

<?php 

?>
<html dir="ltr" lang="en" xml:lang="en" class="yui3-js-enabled">
<div id="yui3-css-stamp" style="position: absolute !important; visibility: hidden !important" class></div>
<head>
    <title>PHC100: Photo compare</title>
    <link rel="shortcut icon" href="../../theme/image.php/anomaly/theme/1385025328/favicon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="moodle, PHC100: Photo compare">
<link rel="stylesheet" type="text/css" href="../../theme/yui_combo.php?3.9.1/build/cssreset/cssreset-min.css&amp;3.9.1/build/cssfonts/cssfonts-min.css&amp;3.9.1/build/cssgrids/cssgrids-min.css&amp;3.9.1/build/cssbase/cssbase-min.css">
<script type="text/javascript" src="../../theme/yui_combo.php?3.9.1/build/simpleyui/simpleyui-min.js&amp;3.9.1/build/loader/loader-min.js"></script>
<script type="text/javascript" src="../../theme/jquery.php/core/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery.exif.js"></script>
<script charset="utf-8" id="yui_3_9_1_2_1386055242465_5" src="../../lib/javascript.php/1385025328/blocks/dock.js" async=""></script>
<link charset="utf-8" rel="stylesheet" id="yui_3_9_1_2_1386055242465_227" href="../../theme/yui_combo.php?3.9.1/build/widget-base/assets/skins/sam/widget-base.css&amp;3.9.1/build/cssbutton/cssbutton-min.css&amp;3.9.1/build/widget-modality/assets/skins/sam/widget-modality.css&amp;3.9.1/build/widget-stack/assets/skins/sam/widget-stack.css&amp;3.9.1/build/panel/assets/skins/sam/panel.css">
<script charset="utf-8" id="yui_3_9_1_2_1386055242465_229" src="../../theme/yui_combo.php?3.9.1/build/panel/panel-min.js&amp;3.9.1/build/yui-throttle/yui-throttle-min.js&amp;3.9.1/build/dd-ddm-base/dd-ddm-base-min.js&amp;3.9.1/build/dd-drag/dd-drag-min.js&amp;3.9.1/build/dd-plugin/dd-plugin-min.js&amp;moodle/1385025328/core/notification/notification-min.js&amp;3.9.1/build/cache-base/cache-base-min.js&amp;3.9.1/build/json-stringify/json-stringify-min.js&amp;3.9.1/build/cache-offline/cache-offline-min.js&amp;3.9.1/build/plugin/plugin-min.js&amp;3.9.1/build/cache-plugin/cache-plugin-min.js&amp;moodle/1385025328/core/tooltip/tooltip-min.js&amp;moodle/1385025328/core/popuphelp/popuphelp-min.js" async=""></script>
<script charset="utf-8" id="yui_3_9_1_2_1386055242465_275" src="../../theme/yui_combo.php?moodle/1385025328/core/formautosubmit/formautosubmit-min.js" async=""></script><script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script>
<link rel="stylesheet" type="text/css" href="../../theme/styles.php/anomaly/1385025328/all">
<script type="text/javascript" src="../../lib/javascript.php/1385025328/lib/javascript-static.js"></script>
<style type="text/css"></style>
</head>
<div id='page'>
<div id="page-header">
        <div class="rounded-corner top-left"></div>
        <div class="rounded-corner top-right"></div>
                <h1 class="headermain">Photograph Community - Photo Compare</h1>
        <div class="headermenu"><div class="logininfo">You are logged in as <a href="../../user/profile.php?id=2" title="View profile">Paul Xiao</a> (<a href="../../login/logout.php?sesskey=GXBUnvJHCi">Logout</a>)</div></div>
<div class="navbar clearfix">
	<div class="navbutton">
		<div class="forumsearch">
		<form action="../../mod/forum/search.php" style="display:inline">
		<fieldset class="invisiblefieldset">
		<span class="helptooltip">
		<a href="../../help.php?component=moodle&amp;identifier=search&amp;lang=en" title="Help with Search" aria-haspopup="true" target="_blank">
		<img src="../../theme/image.php/anomaly/core/1385025328/help" alt="Help with Search" class="iconhelp">
		</a>
		</span>
		<label class="accesshide" for="search">Search</label>
		<input id="search" name="search" type="text" size="18" value="" alt="search">
		<label class="accesshide" for="searchforums">Search forums</label>
		<input id="searchforums" value="Search forums" type="submit">
		<input name="id" type="hidden" value="2"></fieldset></form>
		</div>
	</div>
</div>
</div>
<div id="page-content">
     <div id="region-main-box">
     <div id="region-post-box">
     <div id="region-main-wrap">
     <div id="region-main">
          <div class="region-content">
		  
               <!--
			   <p><img id="image1" ></p>
               <p></p>
               <p><img id="image1" ></p>
               <p></p>
               <p><img id="image3" ></p>
               <p></p>               
			   -->
			   <table class="altrowstable" id="alternatecolor">
			   <tr>
			   <th>Parameter</th>
			   <td >
			   <img id="image1" >
			   </td>
			   <td ><img id="image2" ></td>
			   <td ><img id="image3" ></td>			   
			   </tr>  
			   <tr>
			   <th>Make</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr>  
			   <tr>
			   <th>Model</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr>
			   <tr>
			   <th>Exposure Time</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr>  
			   <tr>
			   <th>F-Number</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr>    
			   <tr>
			   <th>ISO</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>Focal Length</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>ExposureBias</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>WhiteBalance</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>Saturation</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>Sharpness</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>Software</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>DPI</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   <tr>
			   <th>Date</th>
			   <td align="center">info1</td>
			   <td align="center">info2</td>
			   <td align="center">info3</td>
			   </tr> 
			   
		    </table>  
         </div>
     </div>                    
</div>                
      <div id="region-pre" class="block-region">
           <div class="region-content">
                        <a href="#sb-1" class="skip-block">Skip Navigation</a><div id="inst4" class="block_navigation  block hidden" role="navigation"><div class="corner-box"><div class="rounded-corner top-left"></div><div class="rounded-corner top-right"></div><div class="header"><div class="title" id="yui_3_9_1_2_1386056697464_243"><div class="block_action"><img class="block-hider-hide" tabindex="0" alt="Hide Navigation block" title="Hide Navigation block" src="../../theme/image.php/anomaly/core/1385025328/t/switch_minus"><img class="block-hider-show" tabindex="0" alt="Show Navigation block" title="Show Navigation block" src="../../theme/image.php/anomaly/core/1385025328/t/switch_plus"><input type="image" class="moveto customcommand requiresjs" alt="Move this to the dock" title="Dock Navigation block" src="../../theme/image.php/anomaly/core/1385025328/t/block_to_dock"></div><h2>Navigation</h2><div class="commands"></div></div></div><div class="content"><ul class="block_tree list"><li class="type_unknown depth_1 contains_branch" aria-expanded="true"><p class="tree_item branch canexpand navigation_node"><a href="../../">Home</a></p><ul><li class="type_setting depth_2 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../my/"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">My home</a></p></li>
<li class="type_course depth_2 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span title="Photography Community" tabindex="0">Site pages</span></p><ul><li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../user/index.php?id=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Participants</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../blog/index.php?courseid=0"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Site blogs</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../badges/view.php?type=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Site badges</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../notes/index.php?filtertype=course&amp;filterselect=0"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Notes</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../tag/search.php"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Tags</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../calendar/view.php?view=month"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Calendar</a></p></li></ul></li>
<li class="type_user depth_2 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span tabindex="0">My profile</span></p><ul><li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../user/profile.php?id=2"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">View profile</a></p></li>
<li class="type_custom depth_3 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span tabindex="0">Forum posts</span></p><ul><li class="type_custom depth_4 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../mod/forum/user.php?id=2"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Posts</a></p></li>
<li class="type_custom depth_4 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../mod/forum/user.php?id=2&amp;mode=discussions"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Discussions</a></p></li></ul></li>
<li class="type_unknown depth_3 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span tabindex="0">Blogs</span></p><ul><li class="type_custom depth_4 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../blog/index.php?userid=2"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">View all of my entries</a></p></li>
<li class="type_custom depth_4 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../blog/edit.php?action=add"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Add a new entry</a></p></li></ul></li>
<li class="type_setting depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../message/index.php"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Messages</a></p></li>
<li class="type_setting depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../user/files.php"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">My private files</a></p></li>
<li class="type_setting depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../badges/mybadges.php"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">My badges</a></p></li>
<li class="type_custom depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../notes/index.php?user=2&amp;course=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Notes</a></p></li></ul></li>
<li class="type_system depth_2 contains_branch" aria-expanded="true"><p class="tree_item branch"><span tabindex="0">Current course</span></p><ul><li class="type_course depth_3 contains_branch" aria-expanded="true"><p class="tree_item branch canexpand"><a title="Photograph Community" href="../../course/view.php?id=2">PHC100</a></p><ul><li class="type_unknown depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><a href="../../user/index.php?id=2">Participants</a></p><ul><li class="type_custom depth_5 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../blog/index.php?courseid=2"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Course blogs</a></p></li>
<li class="type_custom depth_5 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../notes/index.php?filtertype=course&amp;filterselect=2"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Notes</a></p></li></ul></li>
<li class="type_unknown depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span tabindex="0">Badges</span></p><ul><li class="type_setting depth_5 item_with_icon"><p class="tree_item leaf hasicon"><a href="../../badges/view.php?type=2&amp;id=2"><img alt="Course badges" class="smallicon navicon" title="Course badges" src="../../theme/image.php/anomaly/core/1385025328/i/badge">Course badges</a></p></li></ul></li>
<li class="type_structure depth_4 contains_branch" aria-expanded="true"><p class="tree_item branch"><span tabindex="0">General</span></p><ul><li class="type_activity depth_5 item_with_icon current_branch"><p class="tree_item leaf hasicon active_tree_node"><a title="Forum" href="../../mod/forum/view.php?id=1"><img alt="Forum" class="smallicon navicon" title="Forum" src="../../theme/image.php/anomaly/forum/1385025328/icon">News forum</a></p></li></ul></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_2" data-expandable="1" data-loaded="0"><span tabindex="0">22 November - 28 November</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_3" data-expandable="1" data-loaded="0"><span tabindex="0">29 November - 5 December</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_4" data-expandable="1" data-loaded="0"><span tabindex="0">6 December - 12 December</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_5" data-expandable="1" data-loaded="0"><span tabindex="0">13 December - 19 December</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_6" data-expandable="1" data-loaded="0"><span tabindex="0">20 December - 26 December</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_7" data-expandable="1" data-loaded="0"><span tabindex="0">27 December - 2 January</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_8" data-expandable="1" data-loaded="0"><span tabindex="0">3 January - 9 January</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_9" data-expandable="1" data-loaded="0"><span tabindex="0">10 January - 16 January</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_10" data-expandable="1" data-loaded="0"><span tabindex="0">17 January - 23 January</span></p></li>
<li class="type_structure depth_4 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_30_11" data-expandable="1" data-loaded="0"><span tabindex="0">24 January - 30 January</span></p></li></ul></li></ul></li>
<li class="type_system depth_2 collapsed contains_branch" aria-expanded="false"><p class="tree_item branch" id="expandable_branch_0_mycourses" data-expandable="1" data-loaded="0"><a href="../../my/">My courses</a></p></li></ul></li></ul></div><div class="rounded-corner bottom-left"></div><div class="rounded-corner bottom-right"></div></div></div><span id="sb-1" class="skip-block-to"></span><a href="#sb-2" class="skip-block">Skip Administration</a><div id="inst5" class="block_settings  block" role="navigation"><div class="corner-box"><div class="rounded-corner top-left"></div><div class="rounded-corner top-right"></div><div class="header"><div class="title" id="yui_3_9_1_2_1386056697464_261"><div class="block_action"><img class="block-hider-hide" tabindex="0" alt="Hide Administration block" title="Hide Administration block" src="../../theme/image.php/anomaly/core/1385025328/t/switch_minus"><img class="block-hider-show" tabindex="0" alt="Show Administration block" title="Show Administration block" src="../../theme/image.php/anomaly/core/1385025328/t/switch_plus"><input type="image" class="moveto customcommand requiresjs" alt="Move this to the dock" title="Dock Administration block" src="../../theme/image.php/anomaly/core/1385025328/t/block_to_dock"></div><h2>Administration</h2><div class="commands"></div></div></div><div class="content"><div id="settingsnav" class="box block_tree_box"><ul class="block_tree list"><li class="type_setting contains_branch" aria-expanded="true"><p class="tree_item branch root_node"><span tabindex="0">Forum administration</span></p><ul><li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../course/modedit.php?update=1&amp;return=1&amp;sesskey=GXBUnvJHCi"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Edit settings</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../admin/roles/assign.php?contextid=20"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Locally assigned roles</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../admin/roles/permissions.php?contextid=20"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Permissions</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../admin/roles/check.php?contextid=20"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Check permissions</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../filter/manage.php?contextid=20"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Filters</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../report/log/index.php?chooselog=1&amp;id=2&amp;modid=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Logs</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../backup/backup.php?id=2&amp;cm=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Backup</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../backup/restorefile.php?contextid=20"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Restore</a></p></li>
<li class="type_unknown collapsed contains_branch" aria-expanded="false"><p class="tree_item branch"><span tabindex="0">Subscription mode</span></p><ul><li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../mod/forum/subscribe.php?id=1&amp;mode=0&amp;sesskey=GXBUnvJHCi"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Optional subscription</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf activesetting"><span tabindex="0"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Forced subscription</span></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../mod/forum/subscribe.php?id=1&amp;mode=2&amp;sesskey=GXBUnvJHCi"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Auto subscription</a></p></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../mod/forum/subscribe.php?id=1&amp;mode=3&amp;sesskey=GXBUnvJHCi"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Subscription disabled</a></p></li></ul></li>
<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="../../mod/forum/subscribers.php?id=1"><img alt="" class="smallicon navicon" title="" src="../../theme/image.php/anomaly/core/1385025328/i/navigationitem">Show/edit current subscribers</a></p></li></ul></li>
<li class="type_course collapsed contains_branch" aria-expanded="false"><hr><p class="tree_item branch root_node"><span tabindex="0">Course administration</span></p></li>
<li class="type_unknown collapsed contains_branch" aria-expanded="false"><hr><p class="tree_item branch root_node"><span tabindex="0">Switch role to...</span></p></li>
<li class="type_unknown collapsed contains_branch" aria-expanded="false"><hr><p class="tree_item branch root_node" id="usersettings"><span tabindex="0">My profile settings</span></p></li>
<li class="type_setting collapsed contains_branch" aria-expanded="false"><hr><p class="tree_item branch root_node"><span tabindex="0">Site administration</span></p></li></ul></div><div class="footer"><form class="adminsearchform" method="get" action="../../admin/search.php" role="search"><div><label for="adminsearchquery" class="accesshide">Search in settings</label><input id="adminsearchquery" type="text" name="query" value=""><input type="submit" value="Search"></div></form></div></div><div class="rounded-corner bottom-left"></div><div class="rounded-corner bottom-right"></div></div></div><span id="sb-2" class="skip-block-to"></span>   
           </div>
      </div>                                
      </div>
      </div>
</div>
<div id="page-footer" class="clearfix">
        <p class="helplink"><a href="http://docs.moodle.org/25/en/mod/forum/view"><img class="iconhelp icon-pre" alt="Moodle Docs for this page" title="Moodle Docs for this page" src="../../theme/image.php/anomaly/core/1385025328/docs">Moodle Docs for this page</a></p>
        <div class="logininfo">You are logged in as <a href="../../user/profile.php?id=2" title="View profile">Paul Xiao</a> (<a href="../../login/logout.php?sesskey=GXBUnvJHCi">Logout</a>)</div><div class="homelink"><a href="../../course/view.php?id=2">PHC100</a></div>        <div class="rounded-corner bottom-left"></div>
        <div class="rounded-corner bottom-right"></div>
</div>
</html>

<script>

	var url = new Array();
	var n=0;
	url = document.cookie.split(";"); //get cookies
	
// find the pictures in this page.
	var image1 = document.getElementById('image1');
	var image2 = document.getElementById('image2');
	var image3 = document.getElementById('image3');

// set src to each image 
	for (i=0; i<url.length;i++)
	{	 
		m=i+1;
		imgSrc=url[i].split("=");
		if (imgSrc[0]==image1.id || imgSrc[0]==' '+image1.id)
			{
			n++;
			image1.src=imgSrc[1];
			image1.width=300; image1.height=250;
			}
		else if (imgSrc[0]==image2.id || imgSrc[0]==' '+image2.id){
			n++;		
			image2.src=imgSrc[1];
			image2.width=300; image2.height=250;
			}
		else if (imgSrc[0]==image3.id || imgSrc[0]==' '+image3.id){
			n++;		
			image3.src=imgSrc[1];
			image3.width=300; image3.height=250;
			}
	}


	$(window).load(function(e){
		// Read the exif information for image1
		if (n>=1){
		 var imData1 = $("#image1").exifLoad(function (){
			    //alert('image1');  
			    var make1 = imData1.exif("Make"); 
			    var model1 = imData1.exif( "Model");  
			    var t1 = imData1.exif("ExposureTime"); 
			    var fNumber1 = imData1.exif ("FNumber") ;   
			    var focalLength1 = imData1.exif("FocalLength") ; 
			    var iso1 = imData1.exif("ISOSpeedRatings") ;
			    var ev1 = imData1.exif("ExposureBias") ;   
			    var soft1 = imData1.exif("Software");   
			    var date1 = imData1.exif("DateTime");  
			    var dpi1 = imData1.exif("XResolution");   
			    var sa1 = imData1.exif("Saturation");  
			    var sha1 = imData1.exif("Sharpness");   
			    var wb1 = imData1.exif("WhiteBalance");
			    var artist1 = imData1.exif("Artist");
			    var showExif = "Make: " + make1 + "<br>" + "Model: " + model1 + "<br>" + "Exposure Time: " + t1 +"sec <br>" + "F-Number: F" + fNumber1 + "<br>" + "ISO: " + iso1 + "<br>" + "Focal Length: " + focalLength1 + "mm<br>" + "ExposureBias: " + ev1 + "<br>" + "WhiteBalance: " + wb1 + "<br>" + "Saturation: " + sa1 + "<br>" + "Sharpness: " + sha1 + " <br>" + "Software: " + soft1 + "<br>" + "DPI: " + dpi1 + "DPI<br>" + "Date: " + date1 ;
	                document.getElementsByTagName('p').item(1).innerHTML = showExif;
		 });
	 }
		// Read the exif information for image2
		 if (n>=2){
		 var imData2 = $("#image2").exifLoad(function (){
			    //alert('image2')  ;
			    var make2 = imData2.exif("Make"); 
			    var model2 = imData2.exif( "Model");   
			    var t2 = imData2.exif("ExposureTime");   
			    var fNumber2 = imData2.exif ("FNumber") ;   
			    var focalLength2 = imData2.exif("FocalLength") ;  
			    var iso2 = imData2.exif("ISOSpeedRatings") ; 
			    var ev2 = imData2.exif("ExposureBias") ;   
			    var soft2 = imData2.exif("Software");  
			    var date2 = imData2.exif("DateTime"); 
			    var dpi2 = imData2.exif("XResolution");  
			    var sa2 = imData2.exif("Saturation");   
			    var sha2 = imData2.exif("Sharpness");   
			    var wb2 = imData2.exif("WhiteBalance");	
			    var artist2 = imData2.exif("Artist");
			    var showExif2 = "Make: " + make2 + "<br>" + "Model: " + model2 + "<br>" + "Exposure Time: " + t2 +"sec <br>" + "F-Number: F" + fNumber2 + "<br>" + "ISO: " + iso2 + "<br>" + "Focal Length: " + focalLength2 + "mm<br>" + "ExposureBias: " + ev2 + "<br>" + "WhiteBalance: " + wb2 + "<br>" + "Saturation: " + sa2 + "<br>" + "Sharpness: " + sha2 + " <br>" + "Software: " + soft2 + "<br>" + "DPI: " + dpi2 + "DPI<br>" + "Date: " + date2 ;
	                document.getElementsByTagName('p').item(3).innerHTML = showExif2;
			 });
		 }
		// Read the exif information for image3
		 if (n>=3){
		 var imData3 = $("#image3").exifLoad(function (){ 
				//alert('image3'); 
			    var make3 = imData3.exif("Make"); 
			    var model3 = imData3.exif( "Model");   
			    var t3 = imData3.exif("ExposureTime");   
			    var fNumber3 = imData3.exif ("FNumber") ;   
			    var focalLength3 = imData3.exif("FocalLength") ;  
			    var iso3 = imData3.exif("ISOSpeedRatings") ;
			    var ev3 = imData3.exif("ExposureBias") ;   
			    var soft3 = imData3.exif("Software");  
			    var date3 = imData3.exif("DateTime");  
			    var dpi3 = imData3.exif("XResolution"); 
			    var sa3 = imData3.exif("Saturation");   
			    var sha3 = imData3.exif("Sharpness");   
			    var wb3 = imData3.exif("WhiteBalance");
			    var artist3 = imData3.exif("Artist");
			    var showExif3 = "Make: " + make3 + "<br>" + "Model: " + model3 + "<br>" + "Exposure Time: " + t3 +"sec <br>" + "F-Number: F" + fNumber3 + "<br>" + "ISO: " + iso3 + "<br>" + "Focal Length: " + focalLength3 + "mm<br>" + "ExposureBias: " + ev3 + "<br>" + "WhiteBalance: " + wb3 + "<br>" + "Saturation: " + sa3 + "<br>" + "Sharpness: " + sha3 + " <br>" + "Software: " + soft3 + "<br>" + "DPI: " + dpi3 + "DPI<br>" + "Date: " + date3 ;
	                document.getElementsByTagName('p').item(5).innerHTML = showExif3;	
			 });
		 }
	 });
</script>