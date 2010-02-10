=== Magazine Edition Control ===
Contributors: erwinwolff
Donate link: http://www.microformatica.com/internet-services/buy-support
Tags: magazine, control
Requires at least: 2.9.1
Tested up to: 2.9.1
Stable tag: 1

Control the editions of your magazine. Easy and with no expesive software.

== Description ==

Control the editions of your magazine. Easy and with no expesive software.

== Installation ==

Use the "echo magazineditions_picturebook()" API in your templates to display a list of images. It will create a list of images set by your "URL of edition front" settings which points to the editions page.

The public part of the installation requires a bit of hacking, so insert the following code on a custom template page with the slug "editions":

// ****************************

$uitgave = "";
if (isset($_GET['uitid'])) {
       $uitgave = $_GET['uitid'];
} else {
       $uitgave = "";
}

$datum = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "magazinedition_uitgaven WHERE cat_guid='" . $uitgave . "'");


if ( current_user_can('manage_options') ) {
echo "<span style=\"float: right;\"><a href=\"" . get_bloginfo('siteurl') .
   "/wp-admin/options-general.php?page=magazinedition\">Edit</a></span>";
}

$lastposts = get_posts('numberposts=-1');
foreach($lastposts as $post) {

        setup_postdata($post);

        if (get_post_meta( $post->ID, 'magazineditionuitgave', true) == $uitgave) {
          echo "<a href=\"" . get_permalink($post->ID) . "\"> " . $post->post_title . "</a><br /><br />";
          echo substr(strip_tags($post->post_content), 0, 200) . "... <br /><br />";
        }
}

echo resetencap(base64_decode($datum->uitgave_desc));

// ****************************



== Frequently Asked Questions ==

= The hacking part is too difficult for me, can I just pay you? =

Of course, just follow the download link and provide us your info, and we will get it set up for you.

= Where can I see a working example of this?  =

Here: http://www.catholica.nl/ (live website)

== Screenshots ==

1. screenshot1.png

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
* Initial release

== Arbitrary section ==

Yes, we are working to get the installation a little smoother.
