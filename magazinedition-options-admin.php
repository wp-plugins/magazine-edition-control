<?php 
$checked = "";

if (isset ($_POST['_wpnonce']) ) {

if (isset($_POST['showtooltip'])) {
update_option('magazinedition-tooltip', 'on');

} else {
update_option('magazinedition-tooltip', '');
}

}

?>

<div class="wrap">
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

<h2 style="margin-left: 500px; margin-top: -5px; color: white;">Magazine Edition Control Options</h2>
</div>
<a href="http://www.microformatica.com/internet-services/buy-support" style="z-index: 400; position: absolute; margin-top: -170px; margin-left: 10px;"><img src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins//magazine-edition-control/logo.gif.png"></a>


<br />
<div class="wrap">

<?php
$checked = "";

if (get_option('magazinedition-tooltip') == "on") {
$checked = "checked=\"yes\"";
 
}
?>

<h2>Administration settings</h2>
<form method="post" action="<?php echo magazinedition_curPageURL() ?>">
<?php wp_nonce_field('update-options'); ?>
<input type="checkbox" value="<?php echo get_option('magazinedition-tooltip'); ?>" <?php echo $checked; ?>name="showtooltip" title="Show the jQuery tooltips?"></input> Show jQuery tooltip?<br /><br />
<input type="submit" value="Submit" name="submit"></input>
</form>
</div>

<div id="tooltip">&nbsp;</div>
<script type="text/javascript">
$("#accordion").accordion();

<?php if (get_option('magazinedition-tooltip') == "on") : ?>
jQuery(document).ready(function(){
        $('.accordion .head').click(function() {
                $(this).next().toggle('slow');
                return false;
        }).next().hide();

        $("form a").tooltip({tip: '#tooltip', effect: 'bouncy'});
        $("form label").tooltip({tip: '#tooltip', effect: 'bouncy'});
        $("form input").tooltip({tip: '#tooltip', effect: 'bouncy'});
});
<?php endif;?>


</script>

