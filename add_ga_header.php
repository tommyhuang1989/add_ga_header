<?php

/**
 * Plugin Name: Add GA js in header
 * Description: Login with google account, and will add gtag and adsence js in the themes header.
 * Version: 1.0
*/

$ga_id = 'UA-143299014-2';
$ad_id = 'ca-pub-8905153292353842';

function add_ga_header() {
	echo wp_sprintf('<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=%s"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'%s\');
</script>'.'<br>', $GLOBALS['ga_id'], $GLOBALS['ga_id']);
}

function add_ad_header() {
	echo wp_sprintf('<!--20200419, tommy, add google adsend js-->
<script data-ad-client="%s" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'.'<br>', $GLOBALS['ad_id']);
}

add_action('wp_head', 'add_ga_header');
add_action('wp_head', 'add_ad_header');
?>