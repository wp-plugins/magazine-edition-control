<?php
/*
Plugin Name: Magazine Edition Control
Plugin URI: http://www.microformatica.com/internet-services/wordpress-addin-magazine-edition-control
Description: Magazine Edition Control
Author: Micro Formatica
Version: 1
Author URI: http://www.microformatica.com
*/

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
add_action('activated_plugin', 'magazinedition_install');
add_action('admin_menu', 'magazinedition_admin_actions');


function magazinedition_install()
{
    global $wpdb;
    $table = $wpdb->prefix."magazinedition_uitgaven";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        cat_date DATE NOT NULL,
        cat_name VARCHAR (255) NOT NULL,
	cat_front VARCHAR (255) NOT NULL,
        cat_guid VARCHAR(255) NOT NULL,
        cat_visible INT(1) NOT NULL DEFAULT '0',
        uitgave_desc text NOT NULL,
        PRIMARY KEY (cat_date),
	UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
    
    $wpdb->query("ALTER TABLE " . $wpdb->prefix  . "magazinedition_uitgaven ADD PRIMARY KEY ( cat_date ) ");
}


function magazinedition_menu()
{
    global $wpdb;
 include 'magazinedition-admin.php';
     
}
 
function magazinedition_admin_actions()
{
    add_menu_page("Magazine Edtion Control", "Magazine Edtion Control", 1,"magazinedition", "magazinedition_menu");
}
 
function magazinedition_uuid () {
 return sprintf('%04x%04x%04x',
       mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
       mt_rand(0, 65535), // 16 bits for "time_mid"
       mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
       bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
           // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
           // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
           // 8 bits for "clk_seq_low"
       mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
   ); 

}

function get_comma_posts ( $guid ) {

$result = "";

$lastposts = get_posts('numberposts=-1');
foreach($lastposts as $post) {
	setup_postdata($post);

	if (get_post_meta( $post->ID, 'magazineditionuitgave', true) == $guid) {
        	$result .= $post->ID . ",";
	}
}

$result = substr($result, 0, -1);
return $result;
}


function set_comma_posts ( $guid, $postids ) { 

$postarr = explode (",", $postids);

$lastposts = get_posts('numberposts=-1');
foreach($lastposts as $post) {
        setup_postdata($post);

        if (get_post_meta( $post->ID, 'magazineditionuitgave', true) == $guid) {
		update_post_meta( $post->ID, 'magazineditionuitgave', '' );
        }
}


foreach ($postarr as $value) {
 add_post_meta($value, 'magazineditionuitgave', $guid, true) or update_post_meta($value, 'magazineditionuitgave', $guid);
}
}


function magazineditions_picturebook() {
global $wpdb;		
$output = "";

$results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "magazinedition_uitgaven ORDER BY cat_date DESC LIMIT 0, 3");

$output .= "<ul class='magazineditionspicturebook'>";

foreach($results as $result) {
$output .= "<li><a href=\"" . get_bloginfo('siteurl') . "/edition?uitid=" . $result->cat_guid . "\"><img src=\"" . $result->cat_front . "\"></a></li>\n";
}
$output .= "</ul>";

echo $output;
}


function replacebr ( $string ) {
$return = "";

$return = $string;
//$return = str_replace("\r", "\n", $return);

$return = nl2br ($return);

$return = str_replace("</li><br />", "</li>", $return);
$return = str_replace("</ul><br />", "</ul>", $return);
$return = str_replace("<ul><br />", "<ul>", $return);
return $return;
}

function resetencap ( $string ) { 
$return = $string;

$return = str_replace("\\\"", "\"", $return);
$return = str_replace("\\'", "'", $return);
return $return;
}
