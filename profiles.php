<?php
/**
 * profiles.php
 *
 * Sets up or updates the social media profiles for the social media page plugin.
 *
 * For use with Social Media Page Plugin version 1.7
 *
 */
// Update old versions
         //youtube update
$sql[] = "UPDATE " . $table_prefix . "socialmediaprofiles
          SET profileTemplate = 'http://www.youtube.com/{username}'
          WHERE site = 'YouTube'
          LIMIT 1;";
         //ebay update
$sql[] = "UPDATE " . $table_prefix . "socialmediaprofiles
          SET profileTemplate = 'http://myworld.ebay.com/{username}/'
          WHERE site = 'ebay'
          LIMIT 1;";
$sql[] = "UPDATE " . $table_prefix . "socialmediaprofiles
          SET site = 'Last.fm'
          WHERE site = 'Last_fm'
          LIMIT 1;";
$sql[] = "UPDATE " . $table_prefix . "socialmediaprofiles
          SET site = 'Friendfeed'
          WHERE site = 'Frendfeed'
          LIMIT 1";
$sql[] = "DELETE FROM " . $table_prefix . "socialmediaprofiles
          WHERE url = 'http://pownce.com/'
          LIMIT 1";
// Update Blip.tv
$sql[] = "UPDATE " . $table_prefix . "socialmediaprofiles
          SET profileTemplate = 'http://{username}.blip.tv/'
          WHERE site = 'Blip.tv'
          LIMIT 1;";

// Add profiles
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('StumbleUpon',
                 'http://www.stumbleupon.com/',
                 'http://{username}.stumbleupon.com/',
                 1,
                 'stumbleupon.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Twitter',
                 'http://www.twitter.com/',
                 'http://www.twitter.com/{username}',
                 2,
                 'twitter.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Plurk',
                 'http://www.plurk.com/',
                 'http://www.plurk.com/user/{username}/',
                 3,
                 'plurk.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Ma.gnolia',
                 'http://ma.gnolia.com/',
                 'http://ma.gnolia.com/people/{username}/',
                 4,
                 'magnolia.png');";                 
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Flickr',
                 'http://www.flickr.com/',
                 'http://www.flickr.com/photos/{username}/',
                 5,
                 'flickr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Delicious',
                 'http://delicious.com/',
                 'http://delicious.com/{username}/',
                 6,
                 'delicious.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Facebook',
                 'http://www.facebook.com/',
                 'http://www.facebook.com/people/{name}/{userid}',
                 7,
                 'facebook.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Friendfeed',
                 'http://friendfeed.com',
                 'http://friendfeed.com/{username}',
                 8,
                 'friendfeed.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Lifestream',
                 'http://lifestream.fm/',
                 'http://lifestream.fm/{username}',
                 9,
                 'lifestream.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LinkedIn',
                 'http://www.linkedin.com/',
                 'http://www.linkedin.com/in/{username}',
                 10,
                 'linkedin.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('MySpace',
                 'http://www.myspace.com/',
                 'http://www.myspace.com/{username}',
                 11,
                 'myspace.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Sphinn',
                 'http://www.sphinn.com/',
                 'http://sphinn.com/user/view/profile/{username}/',
                 12,
                 'sphinn.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('MyOpenId',
                 'http://www.myopenid.com/',
                 'http://{username}.myopenid.com/',
                 13,
                 'myopenid.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('YouTube',
                 'http://www.youtube.com/',
                 'http://www.youtube.com/{username}',
                 14,
                 'youtube.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ThisNext',
                 'http://www.thisnext.com/',
                 'http://www.thisnext.com/by/{username}/',
                 15,
                 'thisnext.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Digg',
                 'http://digg.com/',
                 'http://digg.com/users/{username}/',
                 16,
                 'digg.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ThinkAtheist',
                 'http://www.thinkatheist.com/',
                 'http://www.thinkatheist.com/profile/{username}/',
                 17,
                 'thinkatheist.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('netlog',
                 'http://www.netlog.com/',
                 'http://www.netlog.com/{username}/',
                 18,
                 'netlog.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Barcodepedia',
                 'http://www.barcodepedia.com/',
                 'http://www.barcodepedia.com/users/{username}/',
                 19,
                 'barcodepedia.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Steam',
                 'http://steamcommunity.com/',
                 'http://steamcommunity.com/id/{username}/',
                 20,
                 'steam.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Last.fm',
                 'http://www.last.fm',
                 'http://www.last.fm/user/{username}',
                 21,
                 'lastfm.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Reddit',
                 'http://www.reddit.com/',
                 'http://www.reddit.com/user/{username}/',
                 22,
                 'reddit.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Furl',
                 'http://www.furl.net/',
                 'http://www.furl.net/member/{username}/',
                 23,
                 'furl.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Mister Wong',
                 'http://www.mister-wong.com/',
                 'http://www.mister-wong.com/user/{username}/',
                 24,
                 'misterwong.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Twine',
                 'http://www.twine.com/',
                 'http://www.twine.com/user/{username}/',
                 25,
                 'twine.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Wis.dm',
                 'http://wis.dm/',
                 'http://wis.dm/users/{userid}-{username}/',
                 26,
                 'wisdm.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('SWiK',
                 'http://swik.net/',
                 'http://swik.net/User:{username}/',
                 27,
                 'swik.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Squidoo',
                 'http://www.squidoo.com/',
                 'http://www.squidoo.com/lensmasters/{username}',
                 28,
                 'squidoo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Simpy',
                 'http://www.simpy.com/',
                 'http://www.simpy.com/user/{username}',
                 29,
                 'simpy.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('SEOmoz',
                 'http://www.seomoz.org/',
                 'http://www.seomoz.org/users/view/{username}/',
                 30,
                 'seomoz.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Newsvine',
                 'http://www.newsvine.com/',
                 'http://{username}.newsvine.com/',
                 31,
                 'newsvine.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Netvouz',
                 'http://www.netvouz.com/',
                 'http://www.netvouz.com/{username}/',
                 32,
                 'netvouz.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Faves',
                 'http://faves.com/',
                 'http://faves.com/users/{username}',
                 33,
                 'faves.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Diigo',
                 'http://www.diigo.com/',
                 'http://www.diigo.com/profile/{username}/',
                 34,
                 'diigo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('de.lirio.us',
                 'http://de.lirio.us/',
                 'http://de.lirio.us/profile.php/{username}/',
                 35,
                 'delirious.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BlinkList',
                 'http://www.blinklist.com/',
                 'http://www.blinklist.com/{username}/',
                 36,
                 'blinklist.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BibSonomy',
                 'http://www.bibsonomy.org/',
                 'http://www.bibsonomy.org/user/{username}',
                 37,
                 'bigsonomy.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('MyBlogLog',
                 'http://www.mybloglog.com/',
                 'http://www.mybloglog.com/buzz/members/{username}/',
                 38,
                 'mybloglog.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('bebo',
                 'http://www.bebo.com/',
                 'http://www.bebo.com/{username}/',
                 39,
                 'bebo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Friendster',
                 'http://www.friendster.com/',
                 'http://profiles.friendster.com/{username}/',
                 40,
                 'friendster.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('DOPPLR',
                 'http://www.dopplr.com/',
                 'http://www.dopplr.com/traveller/{username}/',
                 41,
                 'dopplr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Jaiku',
                 'http://www.jaiku.com/',
                 'http://{username}.jaiku.com/',
                 42,
                 'jaiku.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Jumpcut',
                 'http://www.jumpcut.com/',
                 'http://www.jumpcut.com/{username}',
                 43,
                 'jumpcut.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LiveJournal',
                 'http://www.livejournal.com/',
                 'http://{username}.livejournal.com/',
                 44,
                 'ilivejournal.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Multiply',
                 'http://www.multiply.com/',
                 'http://{username}.multiply.com/',
                 45,
                 'multiply.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Netflix',
                 'http://www.netflix.com/',
                 'http://rss.netflix.com/QueueRSS?id={username}',
                 46,
                 'netflix.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Shelfari',
                 'http://www.shelfari.com/',
                 'http://www.shelfari.com/{username}',
                 47,
                 'shelfari.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('SlideShare',
                 'http://www.slideshare.net/',
                 'http://www.slideshare.net/{username}/',
                 48,
                 'slideshare.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Technorati',
                 'http://www.technorati.com/',
                 'http://www.technorati.com/people/technorati/{username}/',
                 48,
                 'technorati.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('The DJ List',
                 'http://www.thedjlist.com/',
                 'http://www.thedjlist.com/djs/{username}/',
                 49,
                 'thedjlist.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Upcoming',
                 'http://upcoming.yahoo.com/',
                 'http://upcoming.yahoo.com/user/{username}/',
                 50,
                 'upcoming.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Wakoopa',
                 'http://wakoopa.com/',
                 'http://wakoopa.com/{username}/',
                 51,
                 'wakoopa.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Yelp',
                 'http://www.yelp.com/',
                 'http://www.yelp.com/user_details?userid={username}',
                 52,
                 'yelp.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Zorpia',
                 'http://www.zorpia.com/',
                 'http://www.zorpia.com/{username}/',
                 53,
                 'zorpia.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BlogMarks',
                 'http://www.blogmarks.net/',
                 'http://www.blogmarks.net/user/{username}/',
                 54,
                 'blogmarks.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BlogMemes',
                 'http://www.blogmemes.com/',
                 'http://www.blogmemes.com/user/{username}',
                 55,
                 'blogmemes.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Blogosphere News',
                 'http://www.blogospherenews.com/',
                 'http://www.blogospherenews.com/user.php?login={username}',
                 56,
                 'blogospherenews.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Blogsvine',
                 'http://www.blogsvine.com/',
                 'http://www.blogsvine.com/user/view/profile/{username}/',
                 57,
                 'blogsvine.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('brightkite',
                 'http://brightkite.com/',
                 'http://brightkite.com/people/{username}/',
                 58,
                 'brightkite.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BUMPzee',
                 'http://www.bumpzee.com/',
                 'http://www.bumpzee.com/users/view/{username}/',
                 58,
                 'bumpzee.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Dailymotion',
                 'http://www.dailymotion.com/',
                 'http://www.dailymotion.com/{username}/',
                 59,
                 'dailymotion.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Clipmarks',
                 'http://www.clipmarks.com/clipper/Torley/',
                 'http://www.clipmarks.com/clipper/{username}/',
                 60,
                 'clipmarks.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Connotea',
                 'http://www.connotea.org/',
                 'http://www.connotea.org/wiki/User:{username}',
                 61,
                 'connotea.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Design Float',
                 'http://www.designfloat.com/',
                 'http://www.designfloat.com/user/view/profile/{username}/',
                 62,
                 'designfloat.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('DotNetKicks',
                 'http://www.dotnetkicks.com/',
                 'http://www.dotnetkicks.com/users/{username}/',
                 63,
                 'dotnetkicks.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('DZone',
                 'http://www.dzone.com/',
                 'http://www.dzone.com/links/users/profile/{username}.html',
                 64,
                 'dzone.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('eKudos',
                 'http://www.ekudos.nl/',
                 'http://www.ekudos.nl/gebruiker/{username}/',
                 65,
                 'ekudos.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('FARK',
                 'http://www.fark.com/',
                 'http://cgi.fark.com/cgi/fark/users.pl?login={username}',
                 66,
                 'fark.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Feed Me Links',
                 'http://www.feedmelinks.com/',
                 'http://www.feedmelinks.com/u/{username}/',
                 67,
                 'feedmelinks.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Fleck',
                 'http://www.fleck.com/',
                 'http://www.fleck.com/profile/{username}/',
                 68,
                 'fleck.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Fleck',
                 'http://www.foodfeed.us/',
                 'http://{username}.foodfeed.us/',
                 69,
                 'foodfeed.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Global Grind',
                 'http://globalgrind.com/',
                 'http://globalgrind.com/user/{username}/',
                 70,
                 'globalgrind.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Health Ranker',
                 'http://www.healthranker.com/',
                 'http://www.healthranker.com/user/view/profile/{username}/',
                 71,
                 'healthranker.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('HEMiDEMi',
                 'http://www.hemidemi.com/',
                 'http://www.hemidemi.com/user/{username}/',
                 72,
                 'hemidemi.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('identi.ca',
                 'http://identi.ca/',
                 'http://identi.ca/{username}',
                 73,
                 'identica.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('iLike',
                 'http://www.ilike.com/',
                 'http://www.ilike.com/user/{username}/',
                 74,
                 'ilike.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('iliketotallyloveit',
                 'http://www.iliketotallyloveit.com/',
                 'http://www.iliketotallyloveit.com/user/{username}/',
                 75,
                 'iliketotallyloveit.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('IndianPad',
                 'http://www.indianpad.com/',
                 'http://www.indianpad.com/user/{username}/',
                 76,
                 'indianpad.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('joinR',
                 'http://www.joinr.de/',
                 'http://{username}.joinr.de/',
                 77,
                 'joinr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Joost',
                 'http://www.joost.com/',
                 'http://www.joost.com/users/{username}/',
                 78,
                 'joost.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('kirtsy',
                 'http://www.kirtsy.com/',
                 'http://www.kirtsy.com/user.php?login={username}',
                 79,
                 'kirtsy.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('KWICK',
                 'http://www.kwick.de/',
                 'http://www.kwick.de/{username}/',
                 80,
                 'kwick.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LinkARENA',
                 'http://linkarena.com/',
                 'http://{username}.linkarena.com/',
                 81,
                 'linkarena.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('BLOGTER',
                 'http://www.blogter.hu/',
                 'http://www.blogter.hu/index.php?action=view_profile&user_id={username}',
                 82,
                 'linkter.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Google Reader',
                 'http://www.google.com/',
                 'http://www.google.com/reader/shared/{username}',
                 83,
                 'googlereader.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('men&eacute;ame',
                 'http://meneame.net/',
                 'http://meneame.net/user/{username}/',
                 84,
                 'meneame.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ebay',
                 'http://www.ebay.com/',
                 'http://myworld.ebay.com/{username}/',
                 85,
                 'ebay.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Mixx',
                 'http://www.mixx.com/',
                 'http://www.mixx.com/users/{username}',
                 86,
                 'mixx.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('muti',
                 'http://www.muti.co.za/',
                 'http://www.muti.co.za/user?name={username}',
                 87,
                 'muti.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('myvideo',
                 'http://www.myvideo.co.za/',
                 'http://www.myvideo.co.za/channels/{username}',
                 88,
                 'myvideo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('N4G',
                 'http://www.n4g.com',
                 'http://www.n4g.com/up/{username}.aspx',
                 89,
                 'n4g.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Netvibes',
                 'http://www.netvibes.com/',
                 'http://www.netvibes.com/{username}',
                 90,
                 'netvibes.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Odeo',
                 'http://www.odeo.com/',
                 'http://www.odeo.com/users/{username}/',
                 91,
                 'odeo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Photocase',
                 'http://www.photocase.com/',
                 'http://www.photocase.com/en/user.asp?u={username}',
                 92,
                 'photocase.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Picasaweb',
                 'http://picasaweb.google.com/',
                 'http://picasaweb.google.com/{username}/',
                 93,
                 'picasa.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Plazes',
                 'http://plazes.com/',
                 'http://plazes.com/users/{username}/',
                 94,
                 'plazes.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('PlugIM',
                 'http://www.plugim.com/',
                 'http://www.plugim.com/user/{username}/',
                 95,
                 'plugim.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Polyvore',
                 'http://www.polyvore.com/',
                 'http://www.polyvore.com/cgi/profile?id={username}',
                 96,
                 'polyvore.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ppnow',
                 'http://www.ppnow.com/',
                 'http://www.ppnow.com/bookmark/{username}/',
                 97,
                 'ppnow.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Propeller',
                 'http://www.propeller.com/',
                 'http://www.propeller.com/member/{username}/',
                 98,
                 'propeller.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('QIK',
                 'http://qik.com/',
                 'http://qik.com/{username}/',
                 99,
                 'qik.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Qype',
                 'http://www.qype.co.uk/',
                 'http://www.qype.co.uk/people/{username}/',
                 100,
                 'qype.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Ratimarks',
                 'http://www.ratimarks.org/',
                 'http://www.ratimarks.org/bookmarks.php/{username}/',
                 101,
                 'ratimarks.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Scoopeo',
                 'http://www.scoopeo.com/',
                 'http://www.scoopeo.com/membre/{username}/',
                 102,
                 'scoopeo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Segnalo',
                 'http://segnalo.alice.it/',
                 'http://segnalo.alice.it/profile/{username}',
                 103,
                 'segnalo.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Sevenload',
                 'http://www.sevenload.com/',
                 'http://www.sevenload.com/users/{username}',
                 104,
                 'sevenload.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Sixgroups',
                 'http://sixgroups.com/',
                 'http://sixgroups.com/profile/{username}/',
                 105,
                 'sixgroups.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Slashdot',
                 'http://slashdot.org/',
                 'http://slashdot.org/~{username}',
                 106,
                 'slashdot.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('SmugMug',
                 'http://www.smugmug.com',
                 'http://{username}.smugmug.com/',
                 107,
                 'smugmug.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Folkd',
                 'http://www.folkd.com/',
                 'http://www.folkd.com/user/{username}/',
                 108,
                 'folkd.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('tipjoy',
                 'http://tipjoy.com/',
                 'http://tipjoy.com/u/{username}/',
                 109,
                 'tipjoy.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Tumblr',
                 'http://www.tumblr.com/',
                 'http://{username}.tumblr.com/',
                 110,
                 'tumblr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Twitxr',
                 'http://www.twitxr.com/',
                 'http://www.twitxr.com/{username}/',
                 111,
                 'twitxr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('uboot',
                 'http://www.uboot.com/',
                 'http://{username}.uboot.com/',
                 112,
                 'uboot.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Upnews',
                 'http://www.upnews.it/',
                 'http://www.upnews.it/user/view/profile/{username}/',
                 113,
                 'upnews.gif');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Venteria',
                 'http://venteria.com/',
                 'http://venteria.com/users/{username}/',
                 114,
                 'venteria.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Vimeo',
                 'http://www.vimeo.com/',
                 'http://www.vimeo.com/{username}/',
                 115,
                 'vimeo.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('vi.sualize.us',
                 'http://vi.sualize.us/',
                 'http://vi.sualize.us/{username}/',
                 116,
                 'visualizeus.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Webride',
                 'http://webride.org/',
                 'http://webride.org/users/{username}/',
                 117,
                 'webride.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('weheartit',
                 'http://www.weheartit.com/',
                 'http://www.weheartit.com/user/{username}/',
                 118,
                 'weheartit.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Wikipedia',
                 'http://www.wikipedia.org/',
                 'http://www.wikipedia.org/wiki/User:{username}',
                 119,
                 'wikipedia.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Wists',
                 'http://www.wists.com/',
                 'http://www.wists.com/{username}/',
                 120,
                 'wists.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Woobby',
                 'http://de.woobby.com/',
                 'http://de.woobby.com/user/profile?username={username}',
                 121,
                 'woobby.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('xerpi',
                 'http://www.xerpi.com/',
                 'http://www.xerpi.com/profile/{username}/',
                 122,
                 'xerpi.gif');";

$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Xing',
                 'http://www.xing.com/',
                 'http://www.xing.com/profile/{username}',
                 123,
                 'xing.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('YiGG',
                 'http://www.yigg.de/',
                 'http://www.yigg.de/profil/{username}',
                 124,
                 'yigg.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Zooomr',
                 'http://www.zooomr.com/',
                 'http://www.zooomr.com/photos/{username}/',
                 125,
                 'zooomr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Clipmarks',
                 'http://www.clipmarks.com/',
                 'http://www.clipmarks.com/clipper/{username}/',
                 126,
                 'zooomr.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Blogger',
                 'http://www.blogger.com/',
                 'http://www.blogger.com/profile/{username}',
                 127,
                 'blogger.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Goodreads',
                 'http://www.goodreads.com/',
                 'http://www.goodreads.com/profile/{userid}/',
                 128,
                 'goodreads.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Disqus',
                 'http://www.disqus.com/',
                 'http://www.disqus.com/people/{username}/',
                 129,
                 'disqus.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Hi5',
                 'http://www.hi5.com/',
                 'http://www.hi5.com/friend/p{userid}--{username}--html',
                 130,
                 'hi5.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ohloh',
                 'http://www.ohloh.net/',
                 'http://www.ohloh.net/accounts/{username}',
                 131,
                 'ohloh.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Writing.com',
                 'http://www.writing.com/',
                 'http://www.writing.com/main/view_item/user_id/{username}',
                 132,
                 'writing.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('deviantART',
                 'http://www.deviantart.com/',
                 'http://{username}.deviantart.com/',
                 133,
                 'deviantart.png');";			 
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Blip.fm',
                 'http://blip.fm/',
                 'http://blip.fm/{username}/',
                 134,
                 'blipfm.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Blip.tv',
                 'http://blip.tv/',
                 'http://{username}.blip.tv/',
                 135,
                 'bliptv.png');";				 
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Windows Live',
                 'http://profile.live.com/',
                 'http://{userid}.profile.live.com/ ',
                 136,
                 'livecom.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('WAYN',
                 'http://www.wayn.com/',
                 'http://www.wayn.com/waynprofile.html?member_key={userid} ',
                 137,
                 'wayncom.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Facebook Group',
                 'http://www.facebook.com/',
                 'http://www.facebook.com/group.php?gid={groupid}',
                 138,
                 'facebook.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Facebook Page',
                 'http://www.facebook.com/',
                 'http://www.facebook.com/pages/{pagename}/{pageid}',
                 139,
                 'facebook.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LinkedIn Company',
                 'http://www.linkedin.com/',
                 'http://www.linkedin.com/companies/{lkdncompanynameid}/{lkdncompanyname}',
                 140,
                 'linkedin.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('imeem',
                 'http://www.imeem.com/',
                 'http://www.imeem.com/{username}',
                 141,
                 'imeem.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('12seconds',
                 'http://12seconds/',
                 'http://12seconds.tv/channel/{username}',
                 142,
                 '12secondstv.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Behance',
                 'http://www.behance.net/',
                 'http://www.behance.net/{username}',
                 143,
                 'behancenet.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LibraryThing',
                 'http://www.librarything.com/',
                 'http://www.librarything.com/profile/{username}',
                 144,
                 'librarythingcom.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('LibraryThing Author',
                 'http://www.librarything.com/',
                 'http://www.librarything.com/author/{username}',
                 145,
                 'librarythingcom.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Facebook Profile',
                 'http://www.facebook.com/',
                 'http://www.facebook.com/{username}',
                 146,
                 'facebook.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('Hyves',
                 'http://www.hyves.co.uk/',
                 'http://{username}.hyves.co.uk/',
                 147,
                 'hyvescom.png');";
$sql[] = "INSERT INTO " . $table_prefix . "socialmediaprofiles(
          site,url,profileTemplate,sortOrder,logo)
          VALUES('ClaimID',
                 'http://claimid.com/',
                 'http://claimid.com/{username}',
                 148,
                 'claimidcom.png');";
