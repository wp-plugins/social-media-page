<?php 
// make sure there are profiles to use
if (count($profiles) > 0) {
  if ($outputStyle == 'images') {
    foreach ($profiles as $profile) {
      $keyword = '';
      if ($profile['keyword'] != '') {
          $keyword = $profile['keyword'];
      } elseif ($globalkeyword != '') {
          $keyword = $globalkeyword;
      } else {
          $keyword .= $profile['site'];
      }
      $t_out .= '<a href="' . $profile['profileUrl'] . '" title="' . $keyword . '"';
      $t_out .= $relNofollow;
      $t_out .= $linkTargetWindow;
      $t_out .= '><img src="' . $smpimagepath . $profile['logo'] . '" alt="' . $keyword . ' ' . $profile['site'] . '" /></a>';
    }
  } else {
    $t_out .= '<ul>';
    foreach ($profiles as $profile) {
      $keyword = '';
      if ($profile['keyword'] != '') {
          $keyword = $profile['keyword'];
      } elseif ($globalkeyword != '') {
          $keyword = $globalkeyword;
      } else {
          $keyword .= $profile['site'];
      }

      $t_out .= '<li><img src="' . $smpimagepath . $profile['logo'] . '" alt="' . $keyword . ' ' . $profile['site'] . '" />
                     <a href="' . $profile['profileUrl'] . '" title="' . $keyword . '"';
      $t_out .= $relNofollow;
      $t_out .= $linkTargetWindow;
      $t_out .= '>' . $keyword;

    $t_out .= '</a> at ' . $profile['site'] . '</li>';
    }
    $t_out .= '</ul>';
  }

  if ($giveCredit == "yes") {
    $t_out .= '<div style="text-align:right;"><p style="font-size:90%;">Created by <a href="http://www.hashbangcode.com/" title="#! code"';
    $t_out .= $linkTargetWindow;
    $t_out .= $relNofollow;
    $t_out .= '>#! code</a></p></div>';
  }

  $t_out = '<div id="smp-wrapper">' . $t_out . '</div>';
}
