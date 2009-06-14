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
 * @link     http://www.norton42.org.uk/
 *
 *
 * Plugin Name: Social Media Page
 * Plugin URI: http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html
 * Description: Generates a list of social media profiles on a given page or as a widget. <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social Media Page plugin homepage">Social Media Page plugin homepage</a>.
 * Author: Philip Norton
 * Version: 1.6
 * Author URI: http://www.norton42.org.uk/
 *
 */
 /**
  * Version number.
  */
$smpVer      = '1.6';

 /**
  * Image path.
  */
$smpimagepath = WP_CONTENT_URL . '/plugins/' .
                plugin_basename(dirname(__FILE__)) . '/images/';
				
 /**
  * Normal profile exclusions.
  */				
$exclusions   = array('Facebook', 'Wis.dm', 'Hi5', 'Facebook Page', 'LinkedIn Company');

 /**
  * Page title.
  */
$smp_title = __( 'Social Media Page Plugin' );

/**
* Create smp_keyword option if it doesn't exist.  This option is used to store
* the keyword that will be used to link to the profiles entered.
*/
add_option('smp_keyword', "");

/**
* Create smp_giveCredit option if it doesn't exist.  This option is used to
* store a boolean value regarding the displaying of a link back to the author.
*/
add_option('smp_giveCredit', "yes");

/**
* Create smp_relNoFollow option if it doesn't exist.  This option is used to
* store a boolean value regarding the addition of rel="nofollow" to the links.
*/
add_option('smp_relNoFollow', "no");

/**
* Create smp_widgetTitle option if it doesn't exist.  This option is used to
* store the title of the Widget if the user wants to change it.
*/
add_option('smp_widgetTitle', "Social Media");

/**
* Create smp_sortOrder option if it doesn't exist.  This option is used to
* decide on the order that the items will be sorted in.
*/
add_option('smp_sortOrder', "sortOrder");

/**
* Create smp_sortOrder option if it doesn't exist.  This option is used to
* decide on the order that the items will be sorted in.
*/
add_option('smp_outputStyle', "list");

/**
* Add options page
*
* @return void
*/
function smpAddOptionPages()
{
    if ( function_exists('add_options_page') ) {
        if ( isset($_GET['help']) ) {
			add_options_page(__('Social Media Page'),
                         __('Social Media Page'),
                         8,
                         __FILE__,
                         'helpFile');
		} else {
			add_options_page(__('Social Media Page'),
                         __('Social Media Page'),
                         8,
                         __FILE__,
                         'smpOptionsPage');
		}
    }
}

function helpFile()
{
	include('smp-help.php');
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

    // Get this directory and all sub directories and correct permissions.
    // This is needed as Wordpress plugin updater sometimes causes permission
    // issues.
    chmod_R(dirname(__FILE__), 0775);
}

/**
 * A recursive function that runs through a directory and all sub directories
 * and sets the permissions to a defined value.
 *
 * @param string $path     The starting directory.
 * @param string $filemode The permission to set the directories to.
 *
 * @return boolean True on sucess, false on failure.
 **/
function chmod_R($path, $filemode) {
    if ( !is_dir($path) ) {
       return chmod($path, $filemode);
    }
    $dh = opendir($path);
    while ( $file = readdir($dh) ) {
        if ( $file != '.' && $file != '..' ) {
            $fullpath = $path.'/'.$file;
            if( !is_dir($fullpath) ) {
              if ( !chmod($fullpath, $filemode) ) {
                 return false;
              }
            } else {
              if ( !chmod_R($fullpath, $filemode) ) {
                 return false;
              }
            }
        }
    }

    closedir($dh);

    if ( chmod($path, $filemode) ) {
      return true;
    } else {
      return false;
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
						REPLACE(
								REPLACE(profileTemplate,
										'{userid}',
										'" . $profile . "'),
								'{username}',
								'" . $profile . "'),
						'{groupid}',
						'" . $profile . "')";
    };
    if ( $sortOrder > 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
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
    };
    if ( $sortOrder != 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Save Facebook page information
 *
 * @param integer $siteID    The ID of the site to be updated - this should be the ID
 *                           for Facebook
 * @param string  $name      A string containing the username to be used in the save.
 * @param integer $pageid    The ID of the page to be used in the save.
 * @param integer $sortOrder An optional integer that allows the position of Facebook
 *                           to be set.
 *
 * @return void
 */
function smpSaveFacebookPage($siteID, $name, $pageid, $sortOrder=0)
{
    global $wpdb;
    $tp  = $wpdb->prefix;
    $sql = "UPDATE " . $tp . "socialmediaprofiles";
    if ( $name == '' && $pageid == '' ) {
        $sql .= " SET profileUrl = ''";
    } else {
        $sql .= " SET profileUrl =
                REPLACE(REPLACE(profileTemplate,
                                '{pagename}',
                                '" . $name . "'),
                        '{pageid}',
                        '" . $pageid . "')";
    };
    if ( $sortOrder != 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
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
    };
    if ( $sortOrder != 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Save Hi5 profile information
 *
 * @param integer $siteID    The ID of the site to be updated - this should be the ID
 *                           for Hi5
 * @param string  $name      A string containing the username to be used in the save.
 * @param integer $userid    The ID of the user to be used in the save.
 * @param integer $sortOrder An optional integer that allows the position of Hi5
 *                           to be set.
 *
 * @return void
 */
function smpSaveHi5Profile($siteID, $username, $userid, $sortOrder=0)
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
    };
    if ( $sortOrder != 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Save LinkedIn Company profile information
 *
 * @param integer $siteID       The ID of the site to be updated - this should be the ID
 *                              for LinkedIn Company
 * @param string  $companyname  A string containing the company name to be used in the save.
 * @param integer $companyid    The ID of the company to be used in the save.
 * @param integer $sortOrder    An optional integer that allows the position of LinkedIn Company
 *                              to be set.
 *
 * @return void
 */
function smpSaveLinkedInCompanyProfile($siteID, $companyname, $companyid, $sortOrder=0)
{
    global $wpdb;
    $tp  = $wpdb->prefix;
    $sql = "UPDATE " . $tp . "socialmediaprofiles";
    if ( $companyname == '' && $companyid == '' ) {
        $sql .= " SET profileUrl = ''";
    } else {
        $sql .= " SET profileUrl =
                REPLACE(REPLACE(profileTemplate,
                                '{lkdncompanyname}',
                                '" . $companyname . "'),
                        '{lkdncompanynameid}',
                        '" . $companyid . "')";
    };
    if ( $sortOrder != 0 ) {
        $sql .= ", sortOrder = '".$sortOrder."'";
    }
    $sql .= " WHERE id = '" . $siteID . "';";
    $wpdb->query($sql);
}

/**
 * Generate options form and save options.
 *
 * @return void
 */
function smpOptionsPage()
{
    global $smp_title, $smpVer, $wpdb;

	// update orders
	if ( isset($_POST['smp_sortOrder']) ) {
		switch ($_POST['smp_sortOrder']) {
		case "site":
			update_option('smp_sortOrder', 'site');
			break;
		case "url":
			update_option('smp_sortOrder', 'url');
			break;
		case "profile":
			update_option('smp_sortOrder', 'profile');
			break;
		case "random":
			update_option('smp_sortOrder', 'random');
			break;		
		case "sortOrder":
			update_option('smp_sortOrder', 'sortOrder');
			break;
		default:
			update_option('smp_sortOrder', 'sortOrder');
		}
	}

	if ( isset($_POST['smp_outputStyle']) ) {
		switch ($_POST['smp_outputStyle']) {
		case "list":
			update_option('smp_outputStyle', 'list');
			break;
		case "images":
			update_option('smp_outputStyle', 'images');
			break;
		default:
			update_option('smp_outputStyle', 'list');
		}
	}
	
    if ( isset($_POST['smp_update']) ) {
        echo '<div id="message" class="updated fade"><p><strong>';
        update_option('smp_keyword', trim($wpdb->escape((string)$_POST["smp_keyword"])));
        if ( isset($_POST["smp_giveCredit"]) ) {
          update_option('smp_giveCredit', 'yes');
        }else{
          update_option('smp_giveCredit', 'no');
        }

        if ( isset($_POST["smp_relNoFollow"]) ) {
          update_option('smp_relNoFollow', 'yes');
        }else{
          update_option('smp_relNoFollow', 'no');
        }

        if ( isset($_POST["smp_widgetTitle"]) ) {
          $widgetTitle = trim($wpdb->escape((string)$_POST["smp_widgetTitle"]));
          if ( $widgetTitle == '' ) {
              update_option('smp_widgetTitle', 'Social Media');
          } else {
              update_option('smp_widgetTitle', $widgetTitle);
          }
        }else{
          update_option('smp_widgetTitle', 'Social Media');
        }

        // save site information - excluding exceptions
        foreach ( $_POST['smp-id'] as $sortOrder=>$siteID ) {
			if ( $_POST['facebookid'] == $siteID ) {
				// Save Facebook information
				$facebookname   = $wpdb->escape($_POST['facebookname']);
				$facebookuserid = $wpdb->escape($_POST['facebookuserid']);
				smpSaveFacebookProfile($_POST['facebookid'],
										   $facebookname,
										   $facebookuserid,
										   $sortOrder+1);
			} elseif ( $_POST['wisdmid'] == $siteID ) {
				// Save Wis.dm information
				$wisdmusername   = $wpdb->escape($_POST['wisdmusername']);
				$wisdmuserid = $wpdb->escape($_POST['wisdmuserid']);
					smpSaveWisdmProfile($_POST['wisdmid'],
										   $wisdmusername,
										   $wisdmuserid,
										   $sortOrder+1);			
			} elseif ( $_POST['hi5id'] == $siteID ) {
				// Save Hi5 information
				$hi5username   = $wpdb->escape($_POST['hi5username']);
				$hi5userid     = $wpdb->escape($_POST['hi5userid']);
					smpSaveHi5Profile($_POST['hi5id'],
										   $hi5username,
										   $hi5userid,
										   $sortOrder+1);
			} elseif ( $_POST['facebookpageid'] == $siteID ) {
				// Save Facebook information
				$facebookpagename   = $wpdb->escape($_POST['facebookpagename']);
				$facebookpageid = $wpdb->escape($_POST['facebookpagepageid']);
				smpSaveFacebookPage($_POST['facebookpageid'],
										   $facebookpagename,
										   $facebookpageid,
										   $sortOrder+1);
			} elseif ( $_POST['lkdncompanyid'] == $siteID ) {
				// Save LinkedIn Company information   
				$lkdncompanyname   = $wpdb->escape($_POST['lkdncompanyname']);
				$lkdncompanynameid = $wpdb->escape($_POST['lkdncompanynameid']);
				smpSaveLinkedInCompanyProfile($_POST['lkdncompanyid'],
										   $lkdncompanyname,
										   $lkdncompanynameid,
										   $sortOrder+1);
			} else {
				$value = $wpdb->escape($_POST[$siteID]);
				smpSaveProfile($siteID, $value, $sortOrder+1);
			}
        }
								   
        echo "Config updated";
        echo '</strong></p></div>';

    };
    ?>
    <div class="wrap">
    <h2><?php echo $smp_title; ?> v <?php echo $smpVer; ?></h2>
	<p>Setup | <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&help=help">Help</a></p>
	
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="smp_update" id="smp_update" value="true" />

    <div style="border-top:1px solid rgb(204,204,204);">
    <h3>General Options</h3>

    <label for="smp_keyword">Keyword</label>
    <input name="smp_keyword" type="text" size="50"
           value="<?php echo get_option('smp_keyword') ?>" />
    <p><em>This is the keyword that will be used to link to your profiles.</em></p>

    <div style="border-top:1px solid rgb(204,204,204);">
    <p><label for="smp_giveCredit">Give credit for plugin to plugin author?</label>
    <?php
    $smpCreditChecked = '';
    if ( get_option('smp_giveCredit') == 'yes' ) {
        $smpCreditChecked = 'checked="checked"';
    }
    ?>
    <input name="smp_giveCredit" type="checkbox" <?php echo $smpCreditChecked; ?>
    value="smp_giveCredit" /></p>

    <p><label for="smp_relNoFollow">Add rel=&quot;nofollow&quot; attribute to all
    links?</label>
    <?php
    $smpNoFollowChecked = '';
    if ( get_option('smp_relNoFollow') == 'yes' ) {
        $smpNoFollowChecked = 'checked="checked"';
    }
    ?>
    <input name="smp_relNoFollow" type="checkbox" <?php echo $smpNoFollowChecked; ?>
    value="smp_relNoFollow" /></p>

    <p><label for="smp_widgetTitle">Title of Widget</label>
    <input name="smp_widgetTitle" type="text" size="50"
           value="<?php echo get_option('smp_widgetTitle') ?>" /></p>
    <p><em>Leave blank to set back to the default of &quot;Social Media&quot;.</em></p>

	<?php
	// get sort order
	$sortOrder  = get_option('smp_sortOrder');
	?>
	<p><label for="smp_sortOrder">Sort Order</label>
	<select name="smp_sortOrder">
		<option value="profile"<?php echo ($sortOrder=='profile')?' selected="selected"':''; ?>>Sort by profile name.</a></option>
		<option value="url"<?php echo ($sortOrder=='url')?' selected="selected"':''; ?>>Sort by site url.</a></option>
		<option value="sortOrder"<?php echo ($sortOrder=='sortOrder')?' selected="selected"':''; ?>>Sort by user defined sort order.</a></option>
		<option value="site"<?php echo ($sortOrder=='site')?' selected="selected"':''; ?>>Sort by site name.</option>
		<option value="random"<?php echo ($sortOrder=='random')?' selected="selected"':''; ?>>Random!</option>
	</select></p>
	
	<?php
	// get outputstyle
	$outputStyle  = get_option('smp_outputStyle');
	?>
	<p><label for="smp_outputStyle">Output Style</label>
	<select name="smp_outputStyle">
		<option value="list"<?php echo ($outputStyle=='list')?' selected="selected"':''; ?>>A list.</a></option>
		<option value="images"<?php echo ($outputStyle=='images')?' selected="selected"':''; ?>>Lots of images.</a></option>
	</select></p>	
	
    </div>
    </div>
    <div class="submit">
    <input type="submit" name="smp_update" value="Update Profiles &amp; Options" />
    </div>

    <h3>Social Media Profiles</h3>
	<?php 
	if ( $sortOrder == 'sortOrder' ) {	
		?><p>Drag the grey areas up and down to order profiles.</p><?php
	}
	?>
    <div id="smpUsername">Username/UserID</div>

    <?php
    $profiles   = smpGetSocialProfiles(true);
    global $exclusions;
	if ( $sortOrder == 'sortOrder' ) {	
		echo '<ul id="containersmpSiteWrapper">';
	} else {
		echo '<ul>';
	}
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
            $pattern = '#' . str_replace(array('{username}', '{userid}', '{groupid}'),
                                         '(.*)',
                                         str_replace('?',
										             '\?',
													 $profile['profileTemplate'])
										) .
                       '#i';
            preg_match($pattern, $profile['profileUrl'], $fixedProfile);
            $profile['profileUrl'] = $fixedProfile[1];
            ?>
			<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
			<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />
			<span class="smp-sortable-handle smpLogoSpan">
            <img src="../wp-content/plugins/social-media-page/images/<?php
            echo $profile['logo']; ?>"
            alt="<?php echo $profile['site']; ?>" /><?php echo $profile['site'].$additional; ?></span>

            <input name="<?php echo $profile['id']; ?>" type="text" size="30" value="<?php
                  echo $profile['profileUrl']; ?>" /> <?php
                  echo $profile['profileTemplate']; ?><br />
            </li><?php
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
                ?>
				<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
				<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />
                <span class="smp-sortable-handle smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Name</em> <input name="facebookname"
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
                </li><?php
            } elseif ( $profile['site'] == 'Facebook Page' ) {
                // add Facebook Page
                $pattern = str_replace('{pagename}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{pageid}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?>
				<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
				<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />
                <span class="smp-sortable-handle smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Page Name</em> <input name="facebookpagename"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[1]; ?>" />
                <?php echo $profile['profileTemplate']; ?>
                <br />
                <em id="smpFacebookId">Page ID</em>
                <input name="facebookpagepageid"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[2]; ?>" />
                <input name="facebookpageid"
                       type="hidden"
                       value="<?php echo $profile['id']; ?>" />
                </li><?php				
            } elseif ( $profile['site'] == 'Wis.dm' ) {
                // add Wis.dm
                $pattern = str_replace('{username}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{userid}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?>
				<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
				<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />				
                <span class="smp-sortable-handle smpLogoSpan">
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
                </li><?php
            } elseif ( $profile['site'] == 'Hi5' ) {
                // add Hi5
                $pattern = str_replace('{username}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{userid}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?>
				<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
				<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />				
                <span class="smp-sortable-handle smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Username</em> <input name="hi5username"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[1]; ?>" />
                <?php echo $profile['profileTemplate']; ?>
                <br />
                <em id="smphi5Id">User ID</em>
                <input name="hi5userid"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[2]; ?>" />
                <input name="hi5id"
                       type="hidden"
                       value="<?php echo $profile['id']; ?>" />
                </li><?php
            } elseif ( $profile['site'] == 'LinkedIn Company' ) {
                // add LinkedIn Company 
                $pattern = str_replace('{lkdncompanynameid}',
                                       '(.*)',
                                       $profile['profileTemplate']);
                $pattern = '#'.str_replace('{lkdncompanyname}', '(.*)', $pattern).'#i';
                preg_match($pattern, $profile['profileUrl'], $fixedProfile);
                $profile['profileUrl'] = $fixedProfile[1];
                ?>
				<li class="smp-sortable" id="<?php echo $profile['id']; ?>">
				<input type="hidden" name="smp-id[]" value="<?php echo $profile['id']; ?>" />				
                <span class="smp-sortable-handle smpLogoSpan">
                <img src="../wp-content/plugins/social-media-page/images/<?php
                          echo $profile['logo']; ?>"
                     alt="<?php echo $profile['site']; ?>" />
                <?php echo $profile['site'].$additional; ?></span>
                <em>Company ID</em> <input name="lkdncompanynameid"
                       type="text"
                       size="30"
                       value="<?php echo $profile['profileUrl']; ?>" />
                <?php echo $profile['profileTemplate']; ?>
                <br />
                <em id="smpLinkedInCompanyId">Company Name</em>
                <input name="lkdncompanyname"
                       type="text"
                       size="30"
                       value="<?php echo $fixedProfile[2]; ?>" />
                <input name="lkdncompanyid"
                       type="hidden"
                       value="<?php echo $profile['id']; ?>" />
                </li><?php
            }
        }
    }
    ?>
    </ul>
	<?php
	if ( $sortOrder == 'sortOrder' ) {
	?>
    <script type="text/javascript">
        //Position.includeScrollOffsets = true;
        //Sortable.create('containersmpSiteWrapper',{
        //    tag: 'li',
        //    scroll: window
        //});
		
		jQuery(function() {
			jQuery("#containersmpSiteWrapper").sortable({
				placeholder: 'smp-sortable'
			});
			jQuery("#containersmpSiteWrapper").disableSelection();
		});
    </script>
	<?php 
	}
	?>
    <p><strong>*</strong> Make sure that you enable public vewing in your
    options page!</p>
    <p><strong>**</strong> Make sure that you set your profile URL in the
    settings.</p>

    <div class="submit">
    <input type="submit" name="smp_update" value="Update Profiles &amp; Options" />
    </div>
	</form>
    </div>
	<?php
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
    ul#containersmpSiteWrapper li.smp-sortable{
		padding-bottom:0px;
		border-bottom:1px dotted #BFBFBF;
		white-space: nowrap;
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
	#containersmpSiteWrapper li span.smp-sortable-handle{
		cursor:move;
		margin-top:2px;
        border:1px solid #DADADA;
	    background-color:#EFEFEF;		
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

    $sortOrder  = get_option('smp_sortOrder');

    $tp = $wpdb->prefix;

    $sql = "SELECT id,site,profileUrl,logo,profileTemplate,sortOrder
            FROM " . $tp . "socialmediaprofiles";
    if ( $all !== true ) {
        $sql .= " WHERE profileUrl <> ''";
    }
    
    switch ($sortOrder) {
    case "site":
        $sql .= " ORDER BY site ASC";
        break;
    case "url":
        $sql .= " ORDER BY url ASC";
        break;
    case "random":
        $sql .= " ORDER BY RAND() ASC";
        break;
    case "profile":
        $sql .= " ORDER BY profileUrl ASC";
        break;		
    case "sortOrder":
        $sql .= " ORDER BY sortOrder ASC";
        break;
    default:
        $sql .= " ORDER BY sortOrder ASC";
    }
    $profiles = (array)$wpdb->get_results($sql, ARRAY_A);
    return $profiles;
}

/**
* Create the page
*
* @param boolean $widget Used to display different layout for widgets.
*
* @return string The page contents.
*/
function smpCreatePage( $widget=false )
{
    global $smpimagepath;

    $keyword     = (string)get_option('smp_keyword');
    $giveCredit  = get_option('smp_giveCredit');
    $relNofollow = get_option('smp_relNoFollow');
	$outputStyle = get_option('smp_outputStyle');	
    $profiles    = smpGetSocialProfiles();
    $t_out       = '';

    // make sure there are profiles to use
    if ( count($profiles) > 0 ) {
        if ( !$widget ) {
            $t_out .= '<div id="smp-wrapper">';
        }
		
		if ( $outputStyle == 'images' ) {
				foreach ( $profiles as $profile ) {
					$t_out .= '<a href="' . $profile['profileUrl'] . '" title="' . $keyword . '"';
					if ( $relNofollow == 'yes' ) {
						$t_out .= ' rel="nofollow"';
					}
					$t_out .= '><img src="' . $smpimagepath.$profile['logo'] . '"
						 alt="' . $keyword . ' ' . $profile['site'] . '" /></a>';
				}
		} else {
			$t_out .= '<ul>';
			if ( $widget ) {
				foreach ( $profiles as $profile ) {
					$t_out .= '<li>
					<img src="' . $smpimagepath.$profile['logo'] . '"
						 alt="' . $keyword . ' ' . $profile['site'] . '" />
					<a href="' . $profile['profileUrl'] . '" title="' . $keyword . '"';
					if ( $relNofollow == 'yes' ) {
						$t_out .= ' rel="nofollow"';
					}
					$t_out .= '>' . $profile['site'] . '</a></li>';
				}
			} else {
				foreach ( $profiles as $profile ) {
					$t_out .= '<li>
					<img src="' . $smpimagepath.$profile['logo'] . '"
						 alt="' . $keyword . ' ' . $profile['site'] . '" />
					<a href="' . $profile['profileUrl'] . '" title="' . $keyword . '"';
					if ( $relNofollow == 'yes' ) {
						$t_out .= ' rel="nofollow"';
					}
					$t_out .= '>' . $keyword . '</a> at ' . $profile['site'] . '</li>';
				}
			}
			$t_out .= '</ul>';
		}
        if ( $giveCredit == "yes" ) {
            $t_out .= '<div style="text-align:right;">
                   <p style="font-size:90%;">Created by
                   <a href="http://www.norton42.org.uk" title="Philip Norton"';
            if ( $relNofollow == 'yes' ) {
                $t_out .= ' rel="nofollow"';
            }
            $t_out .= '>Philip Norton</a></p></div>';
        }
        if ( !$widget ) {
            $t_out .= '</div>';
        }

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

/**
* Create a Social Media Page Widget
*
* @return void
*/
function smpWidget($args)
{
    extract($args);

    $widgetTitle = get_option('smp_widgetTitle');

    echo $before_widget;
    echo $before_title . __($widgetTitle) . $after_title;
    echo smpCreatePage(true);
    echo $after_widget;
}

/**
* Initialise and register the Social Media Page Widget
*
* @return void
*/
function initSocialMedia() {
    register_sidebar_widget(__('Social Media Page'), 'smpWidget');
    global $wp_registered_widgets;
    $wp_registered_widgets[sanitize_title(__('Social Media Page'))]['description'] = 'Social Media Page Plugin Widget';
}

/**
 * Register with Wordpress.
 */
add_action("plugins_loaded", "initSocialMedia");

register_activation_hook(__FILE__, 'smpInstall');

add_filter('the_content', 'smpGeneratePage');
add_action('admin_menu', 'smpAddOptionPages');
add_action('admin_head', 'smpAddAdminHeader');

// include scripts for drag and drop, but only in admin section
if ( is_admin() ) {
    wp_enqueue_script("jquery-ui-sortable");
}
