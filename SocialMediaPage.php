<?php
/**
 * This file contains the SocialMediaPage class.
 *
 * @category Wordpress Plugin
 * @package  SocialMediaPage
 * @author   Philip Norton
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 */

/**
 * The SocialMediaPage class is used to control the data access functions for
 * the social media page plugin.
 *
 * @category Wordpress Plugin
 * @package  SocialMediaPage
 * @author   Philip Norton
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 */
class SocialMediaPage
{

    /**
     * An array of options.
     *
     * @var array|null
     */
    protected $smpOptions = null;

    /**
     * A link to the wpdb object.
     *
     * @var wpdb|null
     */
    protected $wpdb = null;

    /**
     * Constructor
     *
     */
    public function SocialMediaPage()
    {
        // Make sure the smpOptions parameter has been set
        if ($this->smpOptions == null) {
            $this->smpOptions = get_option('smpOptions');
        }
    }

    /**
     * Get all of the options in an array.
     *
     * @return array The options array.
     */
    public function getSmpOptions()
    {
        return $this->smpOptions;
    }

    /**
     * Get a single option value via the key in the smpOptions array.
     *
     * @param string $option The key of the option value to retrive.
     * @return mixed         The option value.
     */
    public function getSmpOption($option)
    {
        // We might not have a correct option parameter.
        if (!isset($this->smpOptions[$option])) {
            return false;
        }
        return $this->smpOptions[$option];
    }

    /**
     * Save multiple options, if no options array is set or the key values are
     * not present then the current values of the option or options will be used.
     *
     * @param array $options An array of the options to set.
     * @return boolean       Return true on sucess, otherwise false.
     */
    public function saveSmpOptions($options = array())
    {
        // Return false if options is not an array
        if (!is_array($options)) {
            return false;
        }

        if (isset($options['smp_keyword'])) {
            $this->smpOptions['smp_keyword'] = $options['smp_keyword'];
        }

        if (isset($options['smp_giveCredit'])) {
            $this->smpOptions['smp_giveCredit'] = $options['smp_giveCredit'];
        }

        if (isset($options['smp_relNoFollow'])) {
            $this->smpOptions['smp_relNoFollow'] = $options['smp_relNoFollow'];
        }

        if (isset($options['smp_widgetTitle'])) {
            $this->smpOptions['smp_widgetTitle'] = $options['smp_widgetTitle'];
        }

        if (isset($options['smp_sortOrder'])) {
            $this->smpSetSortOrder($options['smp_sortOrder']);
        }

        if (isset($options['smp_outputStyle'])) {
            $this->smpSetOutputStyle($options['smp_outputStyle']);
        }

        if (isset($options['smp_widgetUserId'])) {
            $this->smpOptions['smp_widgetUserId'] = $options['smp_widgetUserId'];
        }

        if (isset($options['smp_lastFileCheck'])) {
            $this->smpOptions['smp_lastFileCheck'] = $options['smp_lastFileCheck'];
        }

        if (isset($options['smp_updateFileStamp'])) {
            $this->smpOptions['smp_updateFileStamp'] = $options['smp_updateFileStamp'];
        }

        if (isset($options['smp_linkTargetWindow'])) {
            $this->smpOptions['smp_linkTargetWindow'] = $options['smp_linkTargetWindow'];
        }

        // Update options in Wordpress table.
        update_option('smpOptions', $this->smpOptions);
        return true;
    }

    /**
     *
     * @global <type> $wpdb
     * @return <type>
     */
    protected function getWpdb()
    {
        if ($this->wpdb == null) {
            global $wpdb;
            $this->wpdb = $wpdb;
        }
        return $this->wpdb;
    }

    /**
     * Insert profile.
     *
     * @param string  $site            The site name.
     * @param string  $url             The site url.
     * @param string  $profile         The profile for the user.
     * @param string  $profileTemplate The template of the profile.
     * @param string  $logo            The logo of the site.
     * @param integer $user_login      The user ID.
     * @param string  $keyword         The keyword.
     */
    public function smpInsertProfile($site, $url, $profile, $profileTemplate, $logo, $user_login, $keyword)
    {
        $wpdb = $this->getWpdb();
        $tp   = $wpdb->prefix;
        $sql  = "INSERT INTO " . $tp . "socialmediaprofiles(
                 site, url, profileUrl, sortOrder, logo, user_login";
        if ($keyword != '') {
            $sql .= ", keyword";
        }
        $sql .= ") VALUES('" . $wpdb->escape($site) . "','" . $wpdb->escape($url) . "',REPLACE(
                                      REPLACE(
                                          REPLACE('".$profileTemplate."',
                                              '{userid}',
                                              '" . $profile . "'),
                                          '{username}',
                                          '" . $profile . "'),
                                      '{groupid}',
                                      '" . $wpdb->escape($profile) . "')".
                 ",'1','" . $wpdb->escape($logo) . "'," . $wpdb->escape($user_login);
        if ($keyword != '') {
            $sql .= ",'" . $wpdb->escape($keyword) . "'";
        }
        $sql .= ");";
        $wpdb->query($sql);
    }

    /**
     * Update an existing profile.
     *
     * @param integer $siteID          The id of the progile to update.
     * @param string  $profile         The information to be updated.
     * @param string  $profileTemplate The profile template.
     * @param string  $user_login      The user that this profile belongs to.
     * @param string  $keyword         The keyword.
     */
    public function smpUpdateProfile($siteID, $profile, $profileTemplate, $user_login, $keyword = '')
    {
        $wpdb = $this->getWpdb();
        $tp   = $wpdb->prefix;

        $sql  = "UPDATE ".$tp . "socialmediaprofiles";
        $sql .= " SET profileUrl =
            REPLACE(
        REPLACE(
            REPLACE('" . $profileTemplate . "',
                '{userid}',
                '" . $profile . "'),
            '{username}',
            '" . $profile . "'),
        '{groupid}',
        '" . $profile . "')";
        $sql .= ",user_login = " . $wpdb->escape($user_login);

        if ($keyword != '') {
            $sql .= ",keyword = '" . $wpdb->escape($keyword) . "'";
        }

        $sql .= " WHERE id = '" . $wpdb->escape($siteID) . "';";
        $wpdb->query($sql);
    }

    /**
     * Delete a profile.
     *
     * @param integer $siteID The id to delete.
     */
    public function smpDeleteProfile($id)
    {
        $wpdb = $this->getWpdb();
        $tp   = $wpdb->prefix;
        $sql  = "DELETE FROM ".$tp . "socialmediaprofiles";
        $sql .= " WHERE id = '" . $wpdb->escape($id) . "';";
        $wpdb->query($sql);
    }


    /**
     * Install or update the plugin, this function will automatically detect
     * which action needs to happen.
     */
    public function install()
    {
        $wpdb = $this->getWpdb();
        $tp  = $wpdb->prefix;

        // Do we need to install the table
        $first_time = $wpdb->get_var("SHOW TABLES LIKE '" . $tp . "socialmediaprofiles'") != $tp . "socialmediaprofiles";
        if ($first_time == true) {
            // Create table
            $createTable = "CREATE TABLE " . $tp . "socialmediaprofiles (
             id int(10) unsigned NOT NULL auto_increment,
             site varchar(200) collate latin1_general_ci NOT NULL,
             url varchar(200) collate latin1_general_ci NOT NULL,
             profileUrl varchar(200) collate latin1_general_ci default NULL,
             profileTemplate varchar(200) collate latin1_general_ci NOT NULL,
             sortOrder int(10) unsigned NOT NULL,
             logo varchar(100) collate latin1_general_ci NOT NULL,
             user_login varchar(60) NOT NULL,
             keyword varchar(100) NULL,
             PRIMARY KEY  (id)
          )";
          $wpdb->query($createTable);          
        } else {
          // Find out if we need to alter the table
          $describeTable = "DESCRIBE " . $tp . "socialmediaprofiles;";
          $tableDescription = $wpdb->get_results($describeTable, ARRAY_A);

          $user_login = false;
          $keyword    = false;

          foreach ($tableDescription as $column) {
              if ($column['Field'] == 'user_login') {
                  $user_login = true;
              } elseif ($column['Feild'] == 'keyword') {
                  $keyword = true;
              }
          }

          if ($user_login === false && $keyword === false) {
              /*
               * 1. add user_login and keyword to the end
               * 2. remove profileTemplate from table
               */
              $alterTable = "ALTER TABLE " . $tp . "socialmediaprofiles
                  ADD `user_login` varchar(60) NOT NULL AFTER `logo`,
                  ADD `keyword` varchar(100) NULL AFTER `user_login`,
                  DROP `profileTemplate`,
                  DROP INDEX `site`";
              $wpdb->query($alterTable);

              // also need to delete any of the old profile information from the table
              $deleteOldData = "DELETE FROM " . $tp . "socialmediaprofiles WHERE
              profileUrl = ''";
              $wpdb->query($deleteOldData);

              // Finally, add in the default user as admin
              $setDefaultUser = "UPDATE " . $tp . "socialmediaprofiles SET
              user_login = 1";
              $wpdb->query($setDefaultUser);
          }
		}

        /**
         * Get this directory and all sub directories and correct permissions.
         * This is needed as Wordpress plugin updater sometimes causes permission
         * issues.
         */
        $this->recursiveChmod(dirname(__FILE__), 0775);

        // Set up default values and attempt to migrate existing ones from 1.x versions.
        if (get_option('smp_keyword') !== false) {
            $smpOptions['smp_keyword'] = get_option('smp_keyword');
            delete_option('smp_keyword');
        } else {
            $smpOptions['smp_keyword'] = '';
        }

        if (get_option('smp_giveCredit') !== false) {
            $smpOptions['smp_giveCredit'] = get_option('smp_giveCredit');
            delete_option('smp_giveCredit');
        } else {
            $smpOptions['smp_giveCredit'] = 'yes';
        }

        if (get_option('smp_relNoFollow') !== false) {
            $smpOptions['smp_relNoFollow'] = get_option('smp_relNoFollow');
            delete_option('smp_relNoFollow');

        } else {
            $smpOptions['smp_relNoFollow'] = 'no';
        }

        if (get_option('smp_widgetTitle') !== false) {
            $smpOptions['smp_widgetTitle'] = get_option('smp_widgetTitle');
            delete_option('smp_widgetTitle');

        } else {
            $smpOptions['smp_widgetTitle'] = 'Social Media';
        }

        if (get_option('smp_sortOrder') !== false) {
            $smpOptions['smp_sortOrder'] = get_option('smp_sortOrder');
            delete_option('smp_sortOrder');
        } else {
            $smpOptions['smp_sortOrder'] = 'sortOrder';
        }

        if (get_option('smp_outputStyle') !== false) {
            $smpOptions['smp_outputStyle'] = get_option('smp_outputStyle');
            delete_option('smp_outputStyle');
        } else {
            $smpOptions['smp_outputStyle'] = 'list';
        }

        if (get_option('smp_widgetUserId') !== false) {
            $smpOptions['smp_widgetUserId'] = get_option('smp_widgetUserId');
            delete_option('smp_widgetUserId');
        } else {
            $smpOptions['smp_widgetUserId'] = '0';
        }

        $smpOptions['smp_linkTargetWindow'] = 'yes';

        update_option('smpOptions', $smpOptions);
    }

    /**
     * Remove any traces of the plugin from the database.
     */
    public function uninstall()
    {
        $wpdb = $this->getWpdb();
        $tp  = $wpdb->prefix;

        $createTable = "DROP TABLE " . $tp . "socialmediaprofiles";
        $wpdb->query($createTable);

        delete_option('smpOptions');

        // delete any old version options
        delete_option('smp_keyword');
        delete_option('smp_giveCredit');
        delete_option('smp_relNoFollow');
        delete_option('smp_widgetTitle');
        delete_option('smp_sortOrder');
        delete_option('smp_outputStyle');
        delete_option('smp_widgetUserId');

        return true;
    }

    /**
     * Create the page
     *
     * @param boolean $all Boolean value that indicates if all profiles should be
     *                     returned or only those that have user information saved.
     *
     * @return array An array of profiles.
     */
    public function smpGetSocialProfiles($user_login = 0)
    {
        $wpdb = $this->getWpdb();
        $smpOptions = $this->getSmpOptions();

        $tp = $wpdb->prefix;

        $sql = "SELECT id,site,profileUrl,logo,sortOrder,user_login,keyword
                FROM " . $tp . "socialmediaprofiles";

        if (is_integer((int)$user_login) && (int)$user_login != 0) {
            $sql .= " WHERE user_login = " . (int)$user_login;
        }

        switch ($smpOptions['smp_sortOrder']) {
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
     * A recursive function that runs through a directory and all sub directories
     * and sets the permissions to a defined value. This is run after the install
     * function is run to make sure that all of the images have the correct
     * permissions as the Wordpress auto-update feature can mess them up.
     *
     * @param string $path     The starting directory.
     * @param string $filemode The permission to set the directories to.
     *
     * @return boolean True on sucess, false on failure.
     **/
    function recursiveChmod($path, $filemode) {
        if (!is_dir($path)) {
            return chmod($path, $filemode);
        }
        $dh = opendir($path);
        while ( $file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path.'/'.$file;
                if (!is_dir($fullpath)) {
                    if (!@chmod($fullpath, $filemode)) {
                        return false;
                    }
                } else {
                    if (!$this->recursiveChmod($fullpath, $filemode)) {
                        return false;
                    }
                }
            }
        }

        closedir($dh);

        if (@chmod($path, $filemode)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * As the sort order must be one of several values this function
     * prevents any other values being set.
     *
     * @param string $sortOrder The sort order.
     */
    protected function smpSetSortOrder($sortOrder)
    {
        switch ($sortOrder) {
            case "site":
                $this->smpOptions['smp_sortOrder'] = 'site';
                break;
            case "url":
                $this->smpOptions['smp_sortOrder'] = 'url';
                break;
            case "profile":
                $this->smpOptions['smp_sortOrder'] = 'profile';
                break;
            case "random":
                $this->smpOptions['smp_sortOrder'] = 'random';
                break;
            case "sortOrder":
                $this->smpOptions['smp_sortOrder'] = 'sortOrder';
                break;
            default:
                $this->smpOptions['smp_sortOrder'] = 'sortOrder';
        }
    }

    /**
     * Take an array of profile ID's and set the profile table to 
     * order the results by the order of these ID's.
     *
     * @param array $order The order of the elements.
     */
    public function smpSetCustomSortOrder($order)
    {
        $wpdb  = $this->getWpdb();
        foreach ($order as $key => $id) {
            $sql = "UPDATE " . $wpdb->prefix . "socialmediaprofiles
            SET sortOrder = " . ($key + 1) . "
            WHERE id = " . $id. ";";
            $wpdb->query($sql);
        }
    }

    /**
     * Restrict what canbe set as the output style.
     *
     * @param string $outputStyle The output style to be set.
     */
    public function smpSetOutputStyle($outputStyle)
    {
        switch ($outputStyle) {
            case "list":
                $this->smpOptions['smp_outputStyle'] = 'list';
                break;
            case "images":
                $this->smpOptions['smp_outputStyle'] = 'images';
                break;
            default:
                $this->smpOptions['smp_outputStyle'] = 'list';
        }
    }
}