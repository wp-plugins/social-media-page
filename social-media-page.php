<?php
/**
 * MyClass File Doc Comment
 *
 * PHP Version 5
 *
 * @category WordPress
 * @package  WordPress
 * @author   Philip Norton <philipnorton42@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.norton42.org.uk/
 *
 *
 * Plugin Name: Social Media Page
 * Plugin URI: http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html
 * Description: Generates a list of social media profiles on a given page. <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social Media Page plugin homepage">Social Media Page plugin homepage</a>.
 * Author: Philip Norton
 * Version: 1.0
 * Author URI: http://www.norton42.org.uk/
 *
 */

$smpVer      = '1.0';
$smpimagepath = WP_CONTENT_URL . '/plugins/' .
                plugin_basename(dirname(__FILE__)) . '/images/';
$exclusions   = array( 'Facebook','Wis.dm' );

/**
* Create smp_keyword option if it doesn't exist.  This option is used to store
* the keyword that will be used to link to the profiles entered.
*/
add_option('smp_keyword', "");

/**
* Add options page
*
* @return void
*/
function smpAddOptionPages()
{
    if ( function_exists('add_options_page') ) {
        add_options_page('Social Media Page',
                         'Social Media Page',
                         8,
                         __FILE__,
                         'smpOptionsPage');
    };
}

/**
* Install plugin and set default values.
*
* @return void
*/
function smpInstall()
{
    global $table_prefix, $wpdb;

    // never used Social Media Page before
    $first_time = $wpdb->get_var("SHOW TABLES LIKE '".
                                 $table_prefix.
                                 "socialmediaprofiles'")
                  != $table_prefix . "socialmediaprofiles";
    $sql   = array();
    if ( $first_time ) {
        $sql[] = "CREATE TABLE " . $table_prefix . "socialmediaprofiles (
           id int(10) unsigned NOT NULL auto_increment,
           site varchar(200) collate latin1_general_ci NOT NULL,
           url varchar(200) collate latin1_general_ci NOT NULL,
           profileUrl varchar(200) collate latin1_general_ci default NULL,
           profileTemplate varchar(200) collate latin1_general_ci NOT NULL,
           sortOrder int(10) unsigned NOT NULL,
           logo varchar(100) collate latin1_general_ci NOT NULL,
           PRIMARY KEY  (id),
           UNIQUE KEY site (site)
        )";
    }
    // try to install all of the profiles.
    include 'profiles.php';
    foreach ( $sql as $qry ) {
        $wpdb->query($qry);
    }
}

/**
 * Save profile information
 *
 * @param integer $siteID    The ID of the site to be updated.
 * @param string  $profile   A string containing the username to be used in the save.
 * @param integer $sortOrder An optional integer that allows the position of the
 *                           site to be set.
 *
 * @return void
 */
function smpSaveProfile($siteID, $profile, $sortOrder=0)
{
    global $wpdb;
    $tp  = $wpdb->prefix;
    $sql = "UPDATE ".$tp . "socialmediaprofiles";
    if ( $profile == '' ) {
        $sql .= " SET profileUrl = ''";
    } else {
        $sql .= " SET profileUrl =
                REPLACE(
                        profileTemplate,
                        '{username}',
                        '" . $profile . "')";
        if ( $sortOrder > 0 ) {
            $sql .= ", sortOrder = '".$sortOrder."'";
        }
    };
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Save Facebook profile information
 *
 * @param integer $siteID    The ID of the site to be updated - this should be the ID
 *                           for Facebook
 * @param string  $name      A string containing the username to be used in the save.
 * @param integer $userid    The ID of the user to be used in the save.
 * @param integer $sortOrder An optional integer that allows the position of Facebook
 *                           to be set.
 *
 * @return void
 */
function smpSaveFacebookProfile($siteID, $name, $userid, $sortOrder=0)
{
    global $wpdb;
    $tp  = $wpdb->prefix;
    $sql = "UPDATE " . $tp . "socialmediaprofiles";
    if ( $name == '' && $userid == '' ) {
        $sql .= " SET profileUrl = ''";
    } else {
        $sql .= " SET profileUrl =
                REPLACE(REPLACE(profileTemplate,
                                '{name}',
                                '" . $name . "'),
                        '{userid}',
                        '" . $userid . "')";
        if ( $sortOrder != 0 ) {
            $sql .= ", sortOrder = '".$sortOrder."'";
        }
    };
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Save Wis.dm profile information
 *
 * @param integer $siteID    The ID of the site to be updated - this should be the ID
 *                           for Wis.dm
 * @param string  $name      A string containing the username to be used in the save.
 * @param integer $userid    The ID of the user to be used in the save.
 * @param integer $sortOrder An optional integer that allows the position of Wis.dm
 *                           to be set.
 *
 * @return void
 */
function smpSaveWisdmProfile($siteID, $username, $userid, $sortOrder=0)
{
    global $wpdb;
    $tp  = $wpdb->prefix;
    $sql = "UPDATE " . $tp . "socialmediaprofiles";
    if ( $name == '' && $userid == '' ) {
        $sql .= " SET profileUrl = ''";
    } else {
        $sql .= " SET profileUrl =
                REPLACE(REPLACE(profileTemplate,
                                '{username}',
                                '" . $username . "'),
                        '{userid}',
                        '" . $userid . "')";
        if ( $sortOrder != 0 ) {
            $sql .= ", sortOrder = '".$sortOrder."'";
        }
    };
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Generate options page
 *
 * @return void
 */
function smpOptionsPage()
{
    global $smpVer, $wpdb;

    if ( isset($_POST['smp_update']) ) {
        echo '<div id="message" class="updated fade"><p><strong>';
        update_option('smp_keyword', (string)$_POST["smp_keyword"]);

        global $exclusions;

        // work out sort orders.
        if ( isset($_POST['sortOrder']) ) {
            if ( $_POST['sortOrder']!='' ) {
                $order     = explode('|', $_POST['sortOrder']);
                $sortOrder = array();
                for ( $i=0 ; $i<count($order)-1 ; ++$i ) {
                    $sortOrder[$order[$i]] = $i+1;
                }
            }
        }

        // save site information - excluding exceptions
        foreach ( $_POST as $siteID=>$value ) {
            if ( !in_array($siteID, $exclusions) && is_numeric($siteID) ) {
                $value = $wpdb->escape($value);
                if ( isset($sortOrder[$siteID]) ) {
                    smpSaveProfile($siteID, $value, $sortOrder[$siteID]);
                } else {
                    smpSaveProfile($siteID, $value);
                }
            };
        };

        // Save Facebook information
        $facebookname   = $wpdb->escape($_POST['facebookname']);
        $facebookuserid = $wpdb->escape($_POST['facebookuserid']);
        if ( isset($sortOrder[$_POST['facebookid']]) ) {
            smpSaveFacebookProfile($_POST['facebookid'],
                                   $facebookname,
                                   $facebookuserid,
                                   $sortOrder[$_POST['facebookid']]);
        } else {
            smpSaveFacebookProfile($_POST['facebookid'],
                                   $facebookname,
                                   $facebookuserid);
        }

        // Save Wis.dm information
        $wisdmusername   = $wpdb->escape($_POST['wisdmusername']);
        $wisdmuserid = $wpdb->escape($_POST['wisdmuserid']);
        if ( isset($sortOrder[$_POST['wisdmid']]) ) {
            smpSaveWisdmProfile($_POST['wisdmid'],
                                   $wisdmusername,
                                   $wisdmuserid,
                                   $sortOrder[$_POST['wisdmid']]);
        } else {
            smpSaveWisdmProfile($_POST['wisdmid'],
                                   $wisdmusername,
                                   $wisdmuserid);
        }

        echo "Config updated";
        echo '</strong></p></div>';

    };
    ?>
    <div class="wrap">
    <h2>Social Media Page v <?php echo $smpVer; ?></h2>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="smp_update" id="smp_update" value="true" />
    <fieldset class="options">
    <h3>General Options</h3>
    <label for="smp_keyword">Keyword</label>
    <input name="smp_keyword" type="text" size="50"
           value="<?php echo get_option('smp_keyword') ?>"/>
    <br />
    <p>This is the keyword that will be used to link to your profiles.</p>

    </fieldset>
    <div class="submit">
    <input type="submit" name="smp_update" value="Update Profiles" />
    </div>
    <fieldset class="options">
    <h3>Social Media Profiles</h3>
    <p>Drag the grey areas up and down to order the ouput of the profiles.</p>
    <div id="smpUsername">Username/UserID</div>

    <?php
    $profiles = smpGetSocialProfiles(true);
    global $exclusions;
    echo '<div id="container_smpSiteWrapper">';
    foreach ( $profiles as $profile ) {
        $additional = '';
        switch ( $profile['site'] ) {
        case 'MyBlogLog':
        case 'bebo':
        case 'Shelfari':
        case 'Vimeo';
            $additional = ' <strong>**</strong>';
            break;
        case 'Facebook':
        case 'Reddit':
        case 'MyOpenId':
            $additional = ' <strong>*</strong>';
            break;
        default:
            break;
        }
        if ( !in_array($profile['site'], $exclusions) ) {
            $pattern = '#' . str_replace('{username}',
                                         '(.*)',
                                         $profile['profileTemplate']) .
                       '#i';
            preg_match($pattern, $profile['profileUrl'], $fixedProfile);
            $profile['profileUrl'] = $fixedProfile[1];

            ?><div id="div_<?php echo $profile['id']; ?>"><span class="smpLogoSpan">
            <img src="../wp-content/plugins/social-media-page/images/<?php
            echo $profile['logo']; ?>"
            alt="<?php echo $profile['site']; ?>" />
            <?php echo $profile['site'].$additional; ?></span>
            <input name="<?php echo $profile['id']; ?>"
                  type="text" size="30" value="<?php
                  echo $profile['profileUrl']; ?>" /> <?php
                  echo $profile['profileTemplate']; ?><br />
            </div><?php
        } else {
            // create exceptions
            if ( $profile['site'] == 'Facebook' ) {
                // add Facebook
                $pattern = str_replace('{name}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{userid}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?><div id="div_<?php echo $profile['id']; ?>">
                <span class="smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Username</em> <input name="facebookname"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[1]; ?>" />
                <?php echo $profile['profileTemplate']; ?>
                <br />
                <em id="smpFacebookId">User ID</em>
                <input name="facebookuserid"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[2]; ?>" />
                <input name="facebookid"
                       type="hidden"
                       value="<?php echo $profile['id']; ?>" />
                </div><?php
            } else if ( $profile['site'] == 'Wis.dm' ) {
                // add Wis.dm
                $pattern = str_replace('{username}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{userid}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?><div id="div_<?php echo $profile['id']; ?>">
                <span class="smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Username</em> <input name="wisdmuserid"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[1]; ?>" />
                <?php echo $profile['profileTemplate']; ?>
                <br />
                <em id="smpWisdmId">User ID</em>
                <input name="wisdmusername"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[2]; ?>" />
                <input name="wisdmid"
                       type="hidden"
                       value="<?php echo $profile['id']; ?>" />
                </div><?php
                            
            }
        }
    }
    ?>
    </div>
    <input type="hidden" name="sortOrder" value="" id="sortOrder" />
    <script type="text/javascript">
        Position.includeScrollOffsets = true;
        Sortable.create('container_smpSiteWrapper',{
            tag: 'div',
            scroll: window,
            onChange: smpRecordSequence
        });


        function smpRecordSequence(){
            var items = Sortable.sequence('container_smpSiteWrapper',{tag:'div'});
            var str   = '';
            for ( var i = 0 ; i<items.length ; i++ ) {
                str += items[i]+'|';
            }
            $('sortOrder').value = str;
        }
    </script>

    <p><strong>*</strong> Make sure that you enable public vewing in your
    options page!</p>
    <p><strong>**</strong> Make sure that you set your profile URL in the 
    settings.</p>    
    </fieldset>

    <div class="submit">
    <input type="submit" name="smp_update" value="Update Profiles" />
    </div>
    </form>
    <h3>Social Media Page Plugin</h3>
    <p>To add this to your site put the following to a page or post:<br />
    <p>&lt;!-- social-media-page --&gt;</p>
    <p>Make sure you are in HTML mode as the visual editor will display that text on
    your site and not the intended content.</p>
    <p>For more informaiton about this plugin, or to report bugs and suggestions go
    to <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social media page plugin">social media page plugin</a> page at <a href="http://www.norton42.org.uk/" title="www.norton42.org.uk">www.norton42.org.uk</a>.</p>
    </div><?php
}

/**
* Add header information to the admin page.
*
* @return void
*/
function smpAddAdminHeader()
{
    ?>
    <style type="text/css">
    div#container_smpSiteWrapper div{
        border:1px solid #DADADA;
	       background-color:#EFEFEF;
        cursor:move;
    }
    div#smpUsername{
        margin-left:200px;
    }
    span.smpLogoSpan{
        display:block;
        width:150px;
        float:left;
    }
    span.smpLogoSpan img{
       padding:3px;
       margin:0;
    }
    em#smpFacebookId{
        margin:0 16px 0 150px;
    }
    em#smpWisdmId{
       margin:0 16px 0 150px;
    }
    </style>
    <?php
}

/**
* Create the page
*
* @param boolean $all Boolean value that indicates if all profiles should be
*                     returned or only those that have user information saved.
*
* @return array An array of profiles.
*/
function smpGetSocialProfiles( $all=false )
{
    global $wpdb;

    $tp = $wpdb->prefix;

    $sql = "SELECT id,site,profileUrl,logo,profileTemplate,sortOrder
            FROM " . $tp . "socialmediaprofiles";
    if ( $all !== true ) {
        $sql .= " WHERE profileUrl <> ''";
    }
    $sql .= " ORDER BY sortOrder";

    $profiles = (array)$wpdb->get_results($sql, ARRAY_A);
    return $profiles;
}

/**
* Create the page
*
* @return string The page contents.
*/
function smpCreatePage()
{
    global $smpimagepath;

    $keyword  = (string)get_option('smp_keyword');
    $profiles = smpGetSocialProfiles();
    $t_out    = '';
    // make sure there are profiles to use
    if ( count($profiles) > 0 ) {
        $t_out .= '<div id="smp-wrapper">';
        $t_out .= '<ul>';

        foreach ( $profiles as $profile ) {
            $t_out .= '<li>
            <img src="' . $smpimagepath.$profile['logo'] . '"
                 alt="' . $keyword . ' ' . $profile['site'] . '" />
            <a href="' . $profile['profileUrl'] . '" title="' . $keyword . '">
            ' . $keyword . '</a> at ' . $profile['site'] . '</li>';
        }
        $t_out .= '</ul>';

        $t_out .= '<div style="text-align:right;">
                   <p style="font-size:90%;">Created by
                   <a href="http://www.norton42.org.uk" title="Philip Norton">
                   Philip Norton</a></p></div>';
        $t_out .= '</div>';

        // Ampersand fix
        $t_out = str_replace("&amp;amp;", "&amp;", $t_out);

    }
    return $t_out;
}

/**
* Create the page
*
* @param string $content The contents of the page.
*
* @return string The page contents.
*/
function smpGeneratePage( $content )
{
    if ( strpos($content, "<!-- social-media-page -->") !== false ) {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i',
                                "<!--$1-->",
                                $content);
        $content = str_replace('<!-- social-media-page -->',
                               smpCreatePage(),
                               $content);
    }
    return $content;
}


register_activation_hook(__FILE__, 'smpInstall');

add_filter('the_content', 'smpGeneratePage');
add_action('admin_menu', 'smpAddOptionPages');
add_action('admin_head', 'smpAddAdminHeader');

// include scripts for drag and drop, but only in admin section
if ( is_admin() ) {
    wp_enqueue_script("scriptaculous-dragdrop");
}
?>
