<h2>Delete Profile.</h2>

<p>Delete This Profile?</p>
<?php
$submittedSite = $_GET['site'];

$sql = "SELECT * FROM " . $wpdb->prefix . "socialmediaprofiles WHERE id = ".$wpdb->escape($submittedSite).";";

$profile = (array)$wpdb->get_results($sql, ARRAY_A);
echo '<ul>';
  echo '<li><strong>Profile Id: </strong>'.$profile[0]['id'].'</il>';
  echo '<li><strong>Site: </strong>'.$profile[0]['site'].'</il>';
  echo '<li><strong>Site URL: </strong>'.$profile[0]['url'].'</il>';
  echo '<li><strong>Profile URL: </strong>'.$profile[0]['profileUrl'].'</il>';
  echo '<li><strong>Logo: </strong><img src="'.$smpimagepath.$profile[0]['logo'].'" alt="" /></il>';
  echo '<li><strong>User ID: </strong>'.$profile[0]['user_login'].'</il>';
echo '</ul><br />';
?>
<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=social-media-page/social-media-page.php" id="socialMediaPageProfile">
<?php
if (function_exists('wp_nonce_field')) {
	wp_nonce_field('social_media_page_plugin_delete_site');
}
?>
<input type="submit" name="smpDeleteProfile" value="Yes" id="smpDeleteProfile" />
<input type="submit" name="smpDeleteProfile" value="No" id="smpDeleteProfile" />
<input type="hidden" name="id" value="<?php echo $profile[0]['id']; ?>" />
</form>
    <script type="text/javascript">
		// <!--
      jQuery('#profile').keyup(
        function(event){
          var userprofile = jQuery('#profile').val();
          var profile = "<?php echo $siteArray[2]; ?>".replace('{username}', userprofile);
          jQuery('#profileOutput').text(profile);
        }
      );
      jQuery('#profile').trigger('keyup');
		// -->
	</script>