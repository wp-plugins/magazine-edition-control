<?php
/*
Copyright (C) 2010 Micro Formatica

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

?>
<div class="wrap">
<?php
global $wpdb;
$wpdb->show_errors();

if (isset($_POST['createuitgave'])) {

	if(trim($_POST["datecreate"]) != "" ) {
		$wpdb->query("INSERT INTO " . $wpdb->prefix . "magazinedition_uitgaven VALUES (NULL, '" . $_POST["datecreate"] . "', '', '', '" . magazinedition_uuid() . "', 0, '' )");	
        } else {		
		echo "<div style=\"background-color: red; color: white; margin-left: 10px; font-weight: bold;\">Invalid entry. Please use the calendar next to the entry field.</div>";
	}
}

if (isset($_POST['uitgave'])) {
       $sql = "UPDATE " . $wpdb->prefix . "magazinedition_uitgaven SET cat_date='" . $_POST['date']  . "', cat_front='" . $_POST['front'] . "', cat_name='" . $_POST['title']  . "', uitgave_desc='" . base64_encode(replacebr($_POST['desc']))  . "' WHERE id='" . $_POST['uitgaveid'] . "'";
       set_comma_posts($_POST['guid'], $_POST['posts']);
       $wpdb->query($sql); 
}

if (isset($_GET['deleteme'])) {
	if(trim($_GET["deleteme"]) != "" ) {
		$sql = "DELETE FROM " . $wpdb->prefix . "magazinedition_uitgaven WHERE id='" . $_GET["deleteme"] . "'" ;
		$wpdb->query($sql);
	}
}
$year = 0;

if (isset($_GET['year'])) {
       $year = $_GET['year'];
} else {
       $year = date("Y");
}

?>

<!-- jQuery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<!-- required plugins -->
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.js"></script><![endif]-->
<!-- jquery.datePicker.js -->



<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/jquery-ui-1.7.2.custom.min.js"></script>

<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/jquery.datePicker.js"></script>

<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/date.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/jquery.tools.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/date.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/jquery-ui-1.7.2.custom.css" />

<div style="background-image: url('<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/sep2.png'); margin-left: 10px;">

<div style="margin-left: auto; margin-right: auto; position: absolute; width: 356px; height: 179px;"><img style="margin-left: auto; margin-right: auto; " src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazinedition/cat.png"></div>
<div style="background-image: url('<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/magazine-edition-control/sep3.png'); height: 127px; width: 100%;">
</div>

<h2 style="margin-left: 500px; margin-top: -5px; color: white;">Magazine Edition Control</h2>

</div>
<a href="http://www.microformatica.com/internet-services/buy-support" style="z-index: 400; position: absolute; margin-top: -170px; margin-left: 10px;"><img src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins//magazine-edition-control/logo.gif.png"></a>

<br />
<div id="tooltip">&nbsp;</div>

<div style="margin-left: 10px; margin-top: -25px;">
<h2>Create edition</h2>
<div id="createedition">
<form action="<?php echo $PHP_SELF; ?>" method="post">
<label for="date1" title="Choose date by clicking the calendar next to this field.">Date</label><br />
<input type="text" readonly="readonly" name="datecreate" id="date1" class="date-pick" title="Use the button next to this field to pick a date.">
<input type="submit" value="Create" name="createuitgave">
</form>
</div>

<h2>Existing editions</h2>
<?php
$results = $wpdb->get_results("SELECT DISTINCT YEAR(cat_date) AS years FROM " . $wpdb->prefix . "magazinedition_uitgaven ORDER BY cat_date ASC");

foreach($results as $result) {
echo "<a href=\"" .  $PHP_SELF . "?page=magazinedition&year="  . $result->years . "\">" . $result->years . "</a> ";
}
?>
<br />
<div id="accordion">
<?php

$results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "magazinedition_uitgaven WHERE cat_date >= '" . $year ."-01-01' AND cat_date <= '" . $year ."-12-31'  ORDER BY cat_date");

foreach($results as $result)

{
   $thisid = $result->id;
   echo "<h3><a href=\"#\">Edition of " . $result->cat_date . " " . $result->cat_name . "</a></h3>\n<div>\n";
   echo "<form action=\"". $PHP_SELF . "\" method=\"post\">";

   echo "<input type=\"hidden\" name=\"uitgaveid\" value=\"" . $thisid . "\">";
   echo "<input type=\"hidden\" name=\"guid\" value=\"" . $result->cat_guid . "\">";

   echo "<label title=\"Please specify the title of this edition.\">Title of edition:</label><br />";
   echo "<input type=\"text\" name=\"title\" id=\"title" . $thisid . "\" value=\"" . $result->cat_name . "\"><br />";
   echo "<br />";

   echo "<label title=\"Choose date by clicking the calendar next to this field.\">Date:</label><br />";
   echo "<input type=\"text\" readonly=\"readonly\" name=\"date\" id=\"date-" . $thisid . "\" value=\"" . $result->cat_date  . "\" class=\"date-pick\"><br />";
   echo "<br />";

   echo "<span style=\"position: absolute; margin-left: 230px; margin-top: -120px;\">";
   echo "<label title=\"This list must be seperated by comma's. Please avoid whitepaces.\">Edition article ID's:</label><br />";
   echo "<input type=\"text\" name=\"posts\" id=\"posts" . $thisid . "\" value=\"" . get_comma_posts($result->cat_guid) . "\" style=\"width: 300px;\"><br />";
   echo "<br />";

   echo "<label title=\"Please specify the URL of the image.\">URL of edition front:</label><br />";
   echo "<input type=\"text\" name=\"front\" id=\"front" . $thisid . "\" value=\"" . $result->cat_front . "\"  style=\"width: 300px;\"><br />";
   echo "<br />";

   echo "</span>";

   echo "<div id=\"editorcontainer\"><textarea name=\"desc\" rows=\"5\" class=\"theEditor\" id=\"content\"  cols=\"40\">" . resetencap(base64_decode($result->uitgave_desc)) . "</textarea></div><br /><br />";

if ( current_user_can('manage_options') ) {
   echo "<input type=\"submit\" name=\"uitgave\" value=\"Edit edition\"> <span style=\"float: right;\"><a href=\"" . $PHP_SELF . "?page=magazinedition&deleteme=" . $thisid . "\" style=\"align: right; color: red;\" title=\"Are you sure? You cannot undo this action.\">Delete this edition</a></span>";
}

   echo "</form>";
   echo "</div>";
}
?>
</div>
</div> 
</div>


<script type="text/javascript">
Date.format = 'yyyy-mm-dd';
$(function()
{
	$('.date-pick').datePicker({startDate:'1990-01-01'});
});
$("#accordion").accordion();

<?php if (get_option('magazinedition-tooltip') == "on") : ?>
jQuery(document).ready(function(){
	$('.accordion .head').click(function() {
		$(this).next().toggle('slow');
		return false;
	}).next().hide();

        $("form a").tooltip({tip: '#tooltip', effect: 'bouncy'});
        $("form label").tooltip({tip: '#tooltip', effect: 'bouncy'});
});
<?php endif;?>
</script>

<script type="text/javascript">
/* <![CDATA[ */
var lang = 'en';
tinyMCEPreInit = {
	base : "<?php echo get_bloginfo('siteurl'); ?>/wp-includes/js/tinymce",
	suffix : "",
	query : "ver=327-1235",
	mceInit : {mode:"specific_textareas", editor_selector:"theEditor", width:"100%", theme:"advanced",skin:"wp_theme", theme_advanced_buttons1:"bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,wp_more,|,spellchecker,fullscreen,wp_adv", theme_advanced_buttons2:"formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help", theme_advanced_buttons3:"", theme_advanced_buttons4:"", language:"en", spellchecker_languages:"+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv", theme_advanced_toolbar_location:"top", theme_advanced_toolbar_align:"left", theme_advanced_statusbar_location:"bottom", theme_advanced_resizing:"1", theme_advanced_resize_horizontal:"", dialog_type:"modal", relative_urls:"", remove_script_host:"", convert_urls:"", apply_source_formatting:"", remove_linebreaks:"1", gecko_spellcheck:"1", entities:"38,amp,60,lt,62,gt", accessibility_focus:"1", tabfocus_elements:"major-publishing-actions", media_strict:"", paste_remove_styles:"1", paste_remove_spans:"1", paste_strip_class_attributes:"all", wpeditimage_disable_captions:"", plugins:"safari,inlinepopups,spellchecker,paste,wordpress,media,fullscreen,wpeditimage,wpgallery,tabfocus"},
	load_ext : function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');}
};
/* ]]> */
</script>

<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-includes/js/tinymce/wp-tinymce.js"></script>
<script type="text/javascript">
<?php 

global $language;
$language = "en";
include (ABSPATH . WPINC . "/js/tinymce/langs/wp-langs.php"); 

echo $lang;

?>
</script>

<script type="text/javascript">
/* <![CDATA[ */
tinyMCEPreInit.go();
tinyMCE.init(tinyMCEPreInit.mceInit);
/* ]]> */
</script>

<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>

