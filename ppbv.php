<?php 
/*
Plugin Name: Popular Posts by Views
Description: Display most popular posts by views
Version: 1.0
Author: Angel Sih
Author URI: http://www.angelsih.com
*/

//load css and javascript
function my_scripts() {
wp_register_style( 'prefix-style', plugins_url('css/style.css', __FILE__) );
wp_enqueue_style( 'prefix-style' );
}
add_action('wp_enqueue_scripts','my_scripts');


function my_javascript() {
		wp_register_script( 'my_javascript', plugins_url('js/javascript.js', __FILE__) ); 
		wp_register_script( 'jquerylib', plugins_url('http://code.jquery.com/jquery-1.6.3.min.js', __FILE__) );
		wp_enqueue_script('my_javascript');
		wp_enqueue_script('jquerylib'); 
}
add_action( 'wp_enqueue_scripts', 'my_javascript' );



//[popularposts] shortcode
function popular_posts( $atts ){

//jquery navigation tabs
echo '<ul class="tabs">
    <li><a href="#tab1">7 days</a></li>
    <li><a href="#tab2">30 days</a></li>
		<li><a href="#tab3">1 year</a></li>
</ul>';

echo '<div class="tab_container">';

//popular posts 7 days
$start = date('Y-m-d', (time() - (60 * 60 * 24 * 7))); //defines the number of days to consider (365)
$end = date('Y-m-d');
$showpages = 10; //defines the number of posts you want to display (10)
$thispage = 1; 
$login = new GADWidgetData();
$ga = new GALib($login->auth_type, $login->auth_token, $login->oauth_token, $login->oauth_secret, $login->account_id, 60);
$pages = $ga->pages_for_date_period($start, $end, 10); //defines the minimum number of hits a post must have in order to be considered (10)

echo '<div id="tab1" class="tab_content">';       
    
echo "<ol>";

$excludes = array("(not set)", "my-to-excluded-post-title"); //defines an array with a list of excluded titles
foreach($pages as $page) {
  $url = $page['value'];
  $title = $page['children']['value'];
  if ( !(in_array($title, $excludes)) && (strpos($url, '?p=') == false) ) {
    echo '<li><a href="' . $url . '">' . $title . '</a></li>'; //checks if the title is part of the excludes or if the title starts with ?p= which is in my case the prefix of a post preview
    $thispage++;
  }
  if($thispage > $showpages) break;
}
echo "</ol>";
echo '</div>';

//popular posts 30 days
$start = date('Y-m-d', (time() - (60 * 60 * 24 * 30))); //defines the number of days to consider (365)
$end = date('Y-m-d');
$showpages = 10; //defines the number of posts you want to display (10)
$thispage = 1; 
$login = new GADWidgetData();
$ga = new GALib($login->auth_type, $login->auth_token, $login->oauth_token, $login->oauth_secret, $login->account_id, 60);
$pages = $ga->pages_for_date_period($start, $end, 10); //defines the minimum number of hits a post must have in order to be considered (10)

echo '<div id="tab2" class="tab_content">'; 
echo "<ol>";
$excludes = array("(not set)", "my-to-excluded-post-title"); //defines an array with a list of excluded titles
foreach($pages as $page) {
  $url = $page['value'];
  $title = $page['children']['value'];
  if ( !(in_array($title, $excludes)) && (strpos($url, '?p=') == false) ) {
    echo '<li><a href="' . $url . '">' . $title . '</a></li>'; //checks if the title is part of the excludes or if the title starts with ?p= which is in my case the prefix of a post preview
    $thispage++;
  }
  if($thispage > $showpages) break;
}

echo "</ol>";
echo '</div>';

//popular posts in a year
$start = date('Y-m-d', (time() - (60 * 60 * 24 * 365))); //defines the number of days to consider (365)
$end = date('Y-m-d');
$showpages = 10; //defines the number of posts you want to display (10)
$thispage = 1; 
$login = new GADWidgetData();
$ga = new GALib($login->auth_type, $login->auth_token, $login->oauth_token, $login->oauth_secret, $login->account_id, 60);
$pages = $ga->pages_for_date_period($start, $end, 10); //defines the minimum number of hits a post must have in order to be considered (10)

echo '<div id="tab3" class="tab_content">';
echo "<ol>";
$excludes = array("(not set)", "my-to-excluded-post-title"); //defines an array with a list of excluded titles
foreach($pages as $page) {
  $url = $page['value'];
  $title = $page['children']['value'];
  if ( !(in_array($title, $excludes)) && (strpos($url, '?p=') == false) ) {
    echo '<li><a href="' . $url . '">' . $title . '</a></li>'; //checks if the title is part of the excludes or if the title starts with ?p= which is in my case the prefix of a post preview
    $thispage++;
  }
  if($thispage > $showpages) break;
}

echo "</ol>";
echo '</div>';
echo "</div>"; 
}

add_shortcode( 'popularposts', 'popular_posts' ); //adds shortcode called [popularposts]
?>
