<?php
/**
 * social-media-page.php
 *
 * PHP Version 5
 *
 * @category WordPress
 * @package  WordPress
 * @author   Philip Norton <philipnorton42@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 *
 * Plugin Name: Social Media Page
 * Plugin URI: http://www.hashbangcode.com/
 * Description: Generates a list of social media profiles on a given page or as a widget. <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social Media Page plugin homepage">Social Media Page plugin homepage</a>.
 * Author: Philip Norton
 * Version: 2.2
 * Author URI: http://www.hashbangcode.com/
 *
 */

/**
 * Include the SocialMediaPage class, see file info for more detail.
 */
require 'SocialMediaPage.php';

/**
 * Include the SocialMediaPageUpdae class, see file info for more detail.
 */
require 'SocialMediaPageUpdate.php';

/**
 * Version number.
 */
$smpVer = '2.1';

/**
 * Image path.
 */
$smpimagepath = WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/images/';

/**
 * Page title.
 */
$smp_title = __('Social Media Page Plugin');

/**
 * Add options page
 */
function smp_add_option_pages()
{
    // Add menu items.
    add_menu_page(__('Social Media Page'), __('SMP'), 'edit_posts', __FILE__, 'smp_options_page');
    add_submenu_page(__FILE__, __('Help'), __('Help'), 'edit_posts', dirname(__FILE__) . '/smp-help.php');
    add_submenu_page(__FILE__, __('Update'), __('Update'), 'manage_options', dirname(__FILE__) . '/smp-update.php');
}

/**
 * Display and run actions on the crete, update and delete pages.
 *
 * @global object $wpdb         The Wordpress database object.
 * @global string $smpimagepath The image path.
 */
function smp_crud_pages()
{
    global $wpdb, $smpimagepath;

    if (!current_user_can('edit_posts'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    if ($_GET['action'] == 'add1') {
        check_admin_referer('social_media_page_plugin_add_profile1');
        include('smp-addprofile1.php');
    } elseif ($_GET['action'] == 'add2') {
        check_admin_referer('social_media_page_plugin_add_profile2');
        include('smp-addprofile2.php');
    } elseif ($_GET['action'] == 'edit') {
        check_admin_referer('social_media_page_plugin_edit_profile');
        include('smp-editprofile.php');
    } elseif ($_GET['action'] == 'delete') {
        check_admin_referer('social_media_page_plugin_delete_profile');
        include('smp-deleteprofile.php');
    }
}

/**
 * Install plugin. This function will install the plugin but also take care of
 * updating from previos versions.
 *
 * @return boolean True if function ran.
 */
function smp_install() {
    $smp = new SocialMediaPage();
    $smp->install();
    return true;
}

/**
 * Uninstall plugin and remove any options.
 *
 * @return boolean True if the function ran.
 */
function smp_unnstall() {
    $smp = new SocialMediaPage();
    $smp->uninstall();
    return true;
}

/**
 * Update the smpOptions array contained in the options table in the database.
 *
 * @global object $wpdb The Wordpress database object.
 *
 * @return boolean True if everything was saved, otherwise false.
 */
function smp_update_options()
{
    if (isset($_POST['smpUpdateOptions']) && current_user_can('manage_options')) {
        check_admin_referer('social_media_page_plugin_update_options');

        global $wpdb;

        $smp = new SocialMediaPage();
        $smpOptions = $smp->getSmpOptions();


        if (isset($_POST['smp_sortOrder'])) {
            $smpOptions['smp_sortOrder'] = $_POST['smp_sortOrder'];
        }

        if (isset($_POST['smp_actualSortOrder'])) {
            $order = stripcslashes($_POST['smp_actualSortOrder']);
            $order = explode(',', $order);
            $smp->smpSetCustomSortOrder($order);
        }

        if (isset($_POST['smp_outputStyle'])) {
            $smpOptions['smp_outputStyle'] = $_POST['smp_outputStyle'];
        }

        $smpOptions['smp_keyword'] = trim($wpdb->escape((string)$_POST["smp_keyword"]));
        if (isset($_POST["smp_giveCredit"])) {
            $smpOptions['smp_giveCredit'] = 'yes';
        } else {
            $smpOptions['smp_giveCredit'] = 'no';
        }

        if (isset($_POST["smp_linkTargetWindow"])) {
            $smpOptions['smp_linkTargetWindow'] = 'yes';
        } else {
            $smpOptions['smp_linkTargetWindow'] = 'no';
        }

        if (isset($_POST["smp_relNoFollow"])) {
            $smpOptions['smp_relNoFollow'] = 'yes';
        } else {
            $smpOptions['smp_relNoFollow'] = 'no';
        }

        if (isset($_POST["smp_widgetTitle"])) {
            $widgetTitle = trim($wpdb->escape((string)$_POST["smp_widgetTitle"]));
            if ($widgetTitle == '') {
                $smpOptions['smp_widgetTitle'] = 'Social Media';
            } else {
                $smpOptions['smp_widgetTitle'] = $widgetTitle;
            }
        } else {
            $smpOptions['smp_widgetTitle'] = 'Social Media';
        }

        if (isset($_POST['smp_widgetUserId'])) {
            $widgetUserId = (int)$wpdb->escape($_POST['smp_widgetUserId']);
            $smpOptions['smp_widgetUserId'] = $widgetUserId;
        }

        $smp->saveSmpOptions($smpOptions);
        return true;
    }
    return false;
}

/**
 * Generate options form and save options.
 *
 * @global string  $smp_title    The title of the plugin.
 * @global string  $smpVer       The version of the plugin.
 * @global object  $wpdb         The Wordpress db object.
 * @global integer $user_ID      The current user ID.
 * @global string  $smpimagepath The path of the image directory.
 *
 * @return mixed The return value depends on the action of the user.
 */
function smp_options_page() {

    if (get_option('smpOptions') == false) {
        smp_install();
    }

    if (isset($_GET['action'])) {
        // nonce check is done in function.
        return smp_crud_pages();
    }

    if (smp_update_options() === true) {
         echo '<div id="message" class="updated fade"><p><strong>Config updated</strong></p></div>';
    }

    // Get plugin vars
    global $smp_title, $smpVer;
    // Get wordpress database connection
    global $wpdb;
    // Get user details
    global $user_ID;
    $smp = new SocialMediaPage();
    $smpOptions = $smp->getSmpOptions();

    // get sort order
    $sortOrder  = $smp->getSmpOption('smp_sortOrder');
    
    if (isset($_POST['smpSaveProfile'])) {
        check_admin_referer('social_media_page_plugin_add_site');
        // save site information
        $site            = $wpdb->escape($_POST['site']);
        $url             = $wpdb->escape($_POST['url']);
        $profile         = $wpdb->escape($_POST['profile']);
        $profileTemplate = $wpdb->escape($_POST['profileTemplate']);
        $logo            = $wpdb->escape($_POST['logo']);
        $user_id         = (int)$wpdb->escape($_POST['user']);
        $keyword         = $wpdb->escape($_POST['keyword']);

        $smp->smpInsertProfile($site, $url, $profile, $profileTemplate, $logo, $user_id, $keyword);
        echo '<div id="message" class="updated fade"><p><strong>Profile Saved</strong></p></div>';
    } elseif (isset($_POST['smpUpdateProfile'])) {
        check_admin_referer('social_media_page_plugin_update_site');
        // save site information
        $id              = (int)$wpdb->escape($_POST['id']);
        $profile         = $wpdb->escape($_POST['profile']);
        $profileTemplate = $wpdb->escape($_POST['profileTemplate']);
        $logo            = $wpdb->escape($_POST['logo']);
        $user_id         = (int)$wpdb->escape($_POST['user']);
        $keyword         = $wpdb->escape($_POST['keyword']);

        $smp->smpUpdateProfile($id, $profile, $profileTemplate, $user_id, $keyword);
        echo '<div id="message" class="updated fade"><p><strong>Profile Updated</strong></p></div>';
    } elseif (isset($_POST['smpDeleteProfile'])) {
        check_admin_referer('social_media_page_plugin_delete_site');
        switch ($_POST['smpDeleteProfile']) {
            case 'Yes':
                $id = (int)$wpdb->escape($_POST['id']);
                $smp->smpDeleteProfile($id);
                break;
            case 'No':
            default:
                break;
        }
    }

    $smpupdate = new SocialMediaPageUpdate();

    // run once every couple of days or so to check for updates to profiles
    if ($smpupdate->timeForUpdate($smp->getSmpOption('smp_lastFileCheck'))) {
        $updatetime = $smpupdate->checkForUpdate();
        if ($updatetime !== false) {
            $options = array(
                    'smp_updateFileStamp' => $updatetime,
                    'smp_lastFileCheck' => time()
            );
            $smp->saveSmpOptions($options);
        }
    }

    // Only users with manage_options privileges can access the update page.
    if (current_user_can('manage_options')) {
        // Get current profiles.csv file location
        $file = $smpupdate->getProfilesCsvLocation();
        if ($smp->getSmpOption('smp_updateFileStamp') > filemtime($file) && current_user_can('manage_options')) {
            // If the file is ready to be updated print link to update aciton
            $url = get_bloginfo('url') . 's/wp-admin/admin.php?page=social-media-page%2Fsmp-update.php&update=updateprofiles';
            $action = "social_media_page_plugin_update_profiles";
            $link = wp_nonce_url($url, $action);
            echo "<p>The profiles file you have is out of date. Do you want to <a href='" . $link . "' title=\"Update profiles\">update</a>?</p>";
        }
    }

    ?><div class="wrap">
    <h2><?php echo $smp_title; ?> v <?php echo $smpVer; ?></h2>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <?php if (current_user_can('manage_options')) { ?>
        <?php wp_nonce_field('social_media_page_plugin_update_options'); ?>
        <div style="border-top:1px solid rgb(204,204,204);">
            <h3>General Options</h3>
            <label for="smp_keyword">Keyword</label>
            <input name="smp_keyword" type="text" size="50" value="<?php echo $smp->getSmpOption('smp_keyword'); ?>" />
            <p><em>This is the keyword that will be used to link to your profiles.</em></p>
            <div style="border-top:1px solid rgb(204,204,204);">
                <p><label for="smp_giveCredit">Give credit for plugin to plugin author?</label>
    <?php
    $smpCreditChecked = '';
    if ($smp->getSmpOption('smp_giveCredit') == 'yes') {
        $smpCreditChecked = 'checked="checked"';
    }
    ?>
                    <input name="smp_giveCredit" type="checkbox" <?php echo $smpCreditChecked; ?>
                           value="smp_giveCredit" /></p>
                <p><label for="smp_linkTargetWindow">Open links in a new window?</label>
    <?php
    $smpLinkTargetWindowChecked = '';
    if ($smp->getSmpOption('smp_linkTargetWindow') == 'yes') {
        $smpLinkTargetWindow = 'checked="checked"';
    }
    ?>
                    <input name="smp_linkTargetWindow" type="checkbox" <?php echo $smpLinkTargetWindow; ?>
                           value="smp_linkTargetWindow" /></p>
                <p><label for="smp_relNoFollow">Add rel=&quot;nofollow&quot; attribute to all
                        links?</label>
                        <?php
    $smpNoFollowChecked = '';
    if ($smp->getSmpOption('smp_relNoFollow') == 'yes') {
        $smpNoFollowChecked = 'checked="checked"';
    }
    ?>
                    <input name="smp_relNoFollow" type="checkbox" <?php echo $smpNoFollowChecked; ?>
                           value="smp_relNoFollow" /></p>

                <p><label for="smp_widgetTitle">Title of Widget</label>
                    <input name="smp_widgetTitle" type="text" size="50"
                           value="<?php echo $smp->getSmpOption('smp_widgetTitle') ?>" /></p>
                <p><em>Leave blank to set back to the default of &quot;Social Media&quot;.</em></p>

                <p><label for="smp_widgetUserId">Which User To Use For Widget</label>
    <?php wp_dropdown_users('show_option_all=All&name=smp_widgetUserId&selected=' . $smp->getSmpOption('smp_widgetUserId')); ?>
                <p><label for="smp_sortOrder">Sort Order</label>
                    <select name="smp_sortOrder">
                        <option value="profile"<?php echo ($sortOrder=='profile')?' selected="selected"':''; ?>>Sort by profile name.</option>
                        <option value="url"<?php echo ($sortOrder=='url')?' selected="selected"':''; ?>>Sort by site url.</option>
                        <option value="sortOrder"<?php echo ($sortOrder=='sortOrder')?' selected="selected"':''; ?>>Sort by user defined sort order.</option>
                        <option value="site"<?php echo ($sortOrder=='site')?' selected="selected"':''; ?>>Sort by site name.</option>
                        <option value="random"<?php echo ($sortOrder=='random')?' selected="selected"':''; ?>>Random!</option>
                    </select></p>
    <?php
    // get outputstyle
    $outputStyle  = $smp->getSmpOption('smp_outputStyle');
    ?>
                <p><label for="smp_outputStyle">Output Style</label>
                    <select name="smp_outputStyle">
                        <option value="list"<?php echo ($outputStyle=='list')?' selected="selected"':''; ?>>A list.</option>
                        <option value="images"<?php echo ($outputStyle=='images')?' selected="selected"':''; ?>>Lots of images.</option>
                    </select></p>

            </div>
        </div>
<?php } ?>
        <h3>Social Media Profiles</h3>
    <?php
    if ($sortOrder == 'sortOrder') {
        echo '<p>Drag the grey areas up and down to order profiles.</p>';
    }

            get_currentuserinfo();
            $smp = new SocialMediaPage();
            if (!isset($_GET['user_id'])) {
                if (current_user_can('manage_options')) {
                    $profiles = $smp->smpGetSocialProfiles();
                } else {
                    $profiles = $smp->smpGetSocialProfiles($user_ID);
                }
            } else {
                $profiles = $smp->smpGetSocialProfiles($_GET['user_id']);
            }

            echo '<p>' . count($profiles) . ' profiles found.</p>';

            if ($sortOrder == 'sortOrder') {
                echo '<ul id="containersmpSiteWrapper">';
            } else {
                echo '<ul id="smpSiteWrapper">';
            }
            global $smpimagepath;
            foreach ($profiles as $profile) {
                ?>
        <li class="smp-sortable" id="<?php echo $profile['id']; ?>">
            <span class="smp-sortable-handle smpLogoSpan">
                <img src="<?php
                echo $smpimagepath . $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" /><?php echo $profile['site']; ?>
                &nbsp;-&nbsp;&nbsp;<?php echo $profile['profileUrl'];
            $profileUser = get_userdata($profile['user_login']);
            echo ' (' . $profileUser->display_name . ') ';
            if ($profile['keyword'] != '') {
                echo ' Keyword: ' . $profile['keyword'];
            }
         ?>
            </span>
            <span class="smpEditSpan">
                        <?php
                        $url = $_SERVER["REQUEST_URI"]. "&action=edit";
                        $action = "social_media_page_plugin_edit_profile";
                        $link = wp_nonce_url($url, $action);
        ?>
                <a class="editProfile" href="<?php echo $link . '&amp;site=' . $profile['id']; ?>" title="Edit <?php echo $profile['site']; ?> Profile">Edit</a>
                        <?php
                        $url = $_SERVER["REQUEST_URI"]. "&action=delete";
                        $action = "social_media_page_plugin_delete_profile";
                        $link = wp_nonce_url($url, $action);
                        ?>
                <a class="editProfile" href="<?php echo $link . '&amp;site=' . $profile['id']; ?>" title="Delte <?php echo $profile['site']; ?> Profile">Delete</a>
            </span>
        </li><?php } ?>
        </ul>
        <div class="more">
    <?php
    $url = $_SERVER["REQUEST_URI"]. "&action=add1";
            $action = "social_media_page_plugin_add_profile1";
            $link = wp_nonce_url($url, $action);
    ?>
            <p><strong><a href="<?php echo $link; ?>">Add profile to list</a></strong></p>
        </div>

        <div class="submit">
            <input type="submit" name="smpUpdateOptions" value="Save Options" />
        </div>
        <input type="hidden" value="" id="smp_actualSortOrder" name="smp_actualSortOrder" />
    </form>
    <?php
    if (current_user_can('manage_options')) {
        echo '<h4>Filter by user:</h4>';
        echo '<form method="get" action=' . $_SERVER["REQUEST_URI"] . '">';
        if (isset($_GET['user_id']) && is_integer((int)$_GET['user_id'])) {
            wp_dropdown_users(array('show_option_all' => 'All', 'name' => 'user_id', 'selected' => (int)$_GET['user_id']));
            } else {
                wp_dropdown_users(array('show_option_all' => 'All', 'name' => 'user_id'));
            }
            echo '<input type="submit" name="smpSelectUser" id="smpSelectUser" value="Show this users profiles" />';
            echo '<input type="hidden" name="page" value="social-media-page/social-media-page.php" />';
            echo '</form>';
        }
        ?>
        <?php
        if ($sortOrder == 'sortOrder') {
            ?>
    <script type="text/javascript">
        jQuery(function() {
            jQuery("#containersmpSiteWrapper").sortable({
                placeholder: 'smp-sortable',
                cancel: '.smpEditSpan',
                update: function(event, ui) {
                    var order = jQuery('#containersmpSiteWrapper').sortable('toArray');
                    console.log(order);
                    jQuery('#smp_actualSortOrder').val(order);
                }
            });
            jQuery("#containersmpSiteWrapper").disableSelection();
        });
    </script>
        <?php
    }
    ?>
    <h4>For all profiles on this list you should make sure that that:</h4>
    <ul id="smpSiteHints">
        <li>You have enabled public vewing.</li>
        <li>You have set your personalised profile URL.</li>
    </ul>
    <p>Not all sites will have these options, but you should make sure that
        users can visit your profile page. If in doubt just log out and try and
        view your profile.</p>

</div>
    <?php
    $smp->saveSmpOptions($smpOptions);
}

/**
 * Add style information to the admin page.
 */
function smp_add_admin_header() {
    ?><style type="text/css">
    span.smpLogoSpan { line-height:20px; }
    span.smpEditSpan { display:block; float:left; padding-right:10px; }
    span.smpLogoSpan img { margin-right:5px; }
    ul#containersmpSiteWrapper li, ul#smpSiteWrapper li { background-color:#EFEFEF; border:1px solid #DADADA; padding:3px 5px 1px 3px; }
    ul#containersmpSiteWrapper li span.smp-sortable-handle { cursor: move; }
    ul#smpSiteHints li{ list-style:disc; margin-left:20px; }
</style><?php
}

/**
 * Create the content for the widget or page.
 *
 * @global string $smpimagepath The path of the images.
 *
 * @param integer $user_id The current user ID.
 * @param boolean $widget  Are we in widget mode?
 *
 * @return string The generated content.
 */
function smp_print_list($user_id = 0, $widget=false) {
    global $smpimagepath;

    $smp = new SocialMediaPage();

    $globalkeyword    = (string)$smp->getSmpOption('smp_keyword');
    $giveCredit       = $smp->getSmpOption('smp_giveCredit');
    $linkTargetWindow = ($smp->getSmpOption('smp_linkTargetWindow')=='yes'?' target="_blank"':'');
    $relNofollow      = ($smp->getSmpOption('smp_relNoFollow')=='yes'?' rel="nofollow"':'');
    $outputStyle      = $smp->getSmpOption('smp_outputStyle');

    // If called from the widget then use smp_widgetUserId option otherwise user_id will be present.
    if ($widget == false) {
        $profiles    = $smp->smpGetSocialProfiles($user_id);
        $templatefile = 'widget.tpl';
    } else {
        $profiles    = $smp->smpGetSocialProfiles($smp->getSmpOption('smp_widgetUserId'));
        $templatefile = 'page.tpl';
    }

    $t_out = '';

    // Include template file
    include  'templates/' . $templatefile;

    // Ampersand fix
    $t_out = str_replace("&amp;amp;", "&amp;", $t_out);
    return $t_out;
}

/**
 * Find and replace a sring in the text with the social media list.
 *
 * @param string $content The content of the page/post.
 * 
 * @return string The altered content.
 */
function smp_generate_page($content) {
    preg_match_all('/\<!-- social-media-page(\d+)? --\>/', $content, $match);

    foreach ($match[0] as $key => $block) {
        // If the same key in second item in $match array is an integer then this is the user id to use.
        // Otherwise we can just use a normal string replace.
        if (is_numeric($match[1][$key])) {
            $content = preg_replace('/(\<!-- social-media-page'.$match[1][$key].' --\>)/', smp_print_list($match[1][$key]), $content);
        } else {
            $content = str_replace('<!-- social-media-page -->', smp_print_list(), $content);
        }
    }

    return $content;
}

/**
 *
 * @param <type> $args
 */
function smp_widget($args) {
    extract($args);
    $smp = new SocialMediaPage();
    $widgetTitle = $smp->getSmpOption('smp_widgetTitle');

    echo $before_widget;
    echo $before_title . __($widgetTitle) . $after_title;
    echo smp_print_list($smp->getSmpOption('smp_widgetUserId'), true);
    echo $after_widget;
}

/**
 * Add the widget.
 *
 * @global array $wp_registered_widgets The available registered widgets.
 */
function smp_init_social_media() {
    register_sidebar_widget(__('Social Media Page'), 'smp_widget');
    global $wp_registered_widgets;
    $wp_registered_widgets[sanitize_title(__('Social Media Page'))]['description'] = 'Social Media Page Plugin Widget';
}

/**
 * Register actions and filters with Wordpress.
 */
// Add widget initialisation function for this plugin to Wordpress.
add_action("plugins_loaded", "smp_init_social_media");

// Register the install function.
register_activation_hook(__FILE__, 'smp_install');

// Register the uninstall function.
register_deactivation_hook(__FILE__, 'smp_unnstall');

// Add a content filter to convert post text into the social media page.
add_filter('the_content', 'smp_generate_page');

// Add the options page.
add_action('admin_menu', 'smp_add_option_pages');

// include scripts and styling, but only in admin section and only
// when on the correct page
if (strpos($_GET['page'],'social-media-page') !== false) {
    if (is_admin()) {
        add_action('admin_head', 'smp_add_admin_header');
        wp_enqueue_script("jquery-ui-sortable");
    }
}
