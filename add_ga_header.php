<?php

/**
 * Plugin Name: Add GA js in header
 * Description: Save ga id in database, then add gtag and adsence js in the themes header.
 * Version: 1.0
*/

//1.先检查数据库是否有这两个字段；（读取数据库）
//3.

$ag_ga_id = get_option('ag_ga_id');//your ga id
$ag_ad_id = get_option('ag_ad_id');//your adsence id

function add_ga_header() {
	echo wp_sprintf('<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=%s"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'%s\');
</script>'.'<br>', $GLOBALS['ag_ga_id'], $GLOBALS['ag_ga_id']);
}

function add_ad_header() {
	echo wp_sprintf('<!--20200419, tommy, add google adsend js-->
<script data-ad-client="%s" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'.'<br>', $GLOBALS['ag_ad_id']);
}


//2.根据读取的结果显示不同的界面：分为：两个都没有数据、有一个、两个都有；
if ($ag_ga_id) {
	add_action('wp_head', 'add_ga_header');
}
if ($ag_ad_id) {
	add_action('wp_head', 'add_ad_header');
}

function ag_header_page_html() {
?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="<?php menu_page_url( 'ag_header' ) ?>" method="post">
		  <table class="form-table">
		  <?php if (!$GLOBALS['ag_ga_id']) {?>
			GA id: <input name="ga_id" type="Text"/> (Google Analytics id)<br><br>
		  <?php 
		  }
		  // else {
			  // add_action('wp_head', 'add_ga_header');
		  // }
		  
		  if (!$GLOBALS['ag_ad_id']) {
		  ?>
			Ad id: <input name="ad_id" type="Text"/> (Google AdSence id)
		  <?php
		  }
		  // else {
			  // add_action('wp_head', 'add_ad_header');
		  // }
			// output security fields for the registered setting "wporg_options"
			////settings_fields( 'wporg_options' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			////do_settings_sections( 'wporg' );
			// output save settings button
			if (!$GLOBALS['ag_ga_id'] || !$GLOBALS['ag_ad_id']) {
			submit_button( __( 'Sumbmit', 'textdomain' ) );
			}
			else {
			?>
			  <p>already set the ga and ad id!</p>
			<?php
			}
			?>
		  </table>
      </form>
    </div>
<?php
}


//3.处理 submit 后的动作
function ag_page_submit() {
	//echo 'ffffffffffffffffffffffffffffffff';
	if ($_SERVER["REQUEST_METHOD"] == "POST") { //提交
		$op_ga_id = $_POST['ga_id'];
		$op_ad_id = $_POST['ad_id'];
		var_dump($op_ga_id);
		var_dump($op_ad_id);
		
		if ($op_ga_id) {
			add_option('ag_ga_id', $op_ga_id);
			$GLOBALS['ag_ga_id'] = $op_ga_id;
			//add_action('wp_head', 'add_ga_header');
		}
		
		if ($op_ad_id) {
			add_option('ag_ad_id', $op_ad_id);
			$GLOBALS['ag_ad_id'] = $op_ad_id;
			//add_action('wp_head', 'add_ad_header');
		}
		
		//echo 'Lillian'.'<br>';
	}
	else { //刷新
		//echo 'tommy'.'<br>';
		
		// $op_ga_id = get_option('ag_ga_id');
		// $op_ad_id = get_option('ag_ad_id');
		// if ($op_ga_id) {
			// $GLOBALS['ag_ga_id'] = $op_ga_id;
			// add_action('wp_head', 'add_ga_header');
		// }
		
		// if ($op_ad_id) {
			// $GLOBALS['ag_ad_id'] = $op_ad_id;
			// add_action('wp_head', 'add_ad_header');
		// }
		//var_dump($op_ga_id);
		//var_dump($op_ad_id);
	}
}

//add_action('wp_head', 'add_ga_header');
//add_action('wp_head', 'add_ad_header');

add_action( 'admin_menu', 'ag_options_page' );
function ag_options_page() {
    $hookname = add_menu_page(
        'choose to add ga header',
        'add ga header',
        'manage_options',
        'ag_header',
        'ag_header_page_html',
        plugin_dir_url(__FILE__) . 'public/images/google_analytics_icon.png',
        20
    );
	
	//echo $hookname;
	
	add_action('load-'.$hookname, 'ag_page_submit');
}

/**
* basic operations：
* activation、deactivation、uninstall
*/
function ag_activate() {
	add_option('ag_ga_id');
}

function ag_uninstall() {
	if (get_option('ag_ga_id')) {
		delete_option('ag_ga_id');
	}
	if (get_option('ag_ad_id')) {
		delete_option('ag_ad_id');
	}
}

//register_activation_hook(__FILE__, 'ag_activate');
register_deactivation_hook(__FILE__, 'ag_uninstall');
//register_uninstall_hook(__FILE__, 'ag_uninstall');

?>