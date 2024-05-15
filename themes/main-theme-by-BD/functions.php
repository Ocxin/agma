<?php


add_action('wp_enqueue_scripts', 'main_theme_enqueue_styles');
function main_theme_enqueue_styles()
{

    wp_enqueue_style('swiper-slider', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_style('open-sans-font',  'https://fonts.googleapis.com/css?family=Nunito+Sans&amp;display=swap');
    wp_enqueue_style('bootstrap',  'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('main-theme',  get_stylesheet_directory_uri() . '/style/css/main.css');
    wp_enqueue_style('main-theme-custom',  get_stylesheet_directory_uri() . '/style/custom/css/custom.css');
    wp_enqueue_style('main-theme-custom-BD',  get_stylesheet_directory_uri() . '/dist/css/main.css');
    wp_enqueue_style('fontawesome',  get_stylesheet_directory_uri() . '/assets/style/font-awesome-4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick-theme.min.css');
    wp_enqueue_style('slick-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css');
}

function my_custom_scripts()
{
    //wp_enqueue_script( 'jquery-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js', array(),null,true );
    wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
    //wp_enqueue_script('jquery', get_stylesheet_directory_uri() .'/style/js/jquery_3.6.4_jquery.min.js', array('jquery'), null,true);
    //wp_enqueue_script('bs', get_stylesheet_directory_uri() .'/style/js/bootstrap.bundle.min.js', array('jquery'), null,true);
    wp_enqueue_script('slicklib', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.js', array('jquery'), null, true);
    //    wp_enqueue_script('simple-slider', get_stylesheet_directory_uri() .'/style/js/Simple-Slider.js', array('jquery'), null,true);

    wp_enqueue_script('slick-slider', get_stylesheet_directory_uri() . '/style/js/slick-slider.js', array('jquery'), null, true);
    wp_enqueue_script('slick-img', get_stylesheet_directory_uri() . '/style/js/slick-img.js', array('jquery'), null, true);
    wp_enqueue_script('slick-company', get_stylesheet_directory_uri() . '/style/js/slick-company.js', array('jquery'), null, true);
    wp_enqueue_script('product-popup', get_stylesheet_directory_uri() . '/style/js/modifyPhases.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/dist/js/bundle.js', array('jquery'), null, true);

    // wp_enqueue_script('dropdown', get_stylesheet_directory_uri() .'/style/js/dropdown.js', array('jquery'), null,true);
}
add_action('wp_enqueue_scripts', 'my_custom_scripts', 1000);
// remove auther		
function disable_embeds_filter_oembed_responsedata($data)
{
    unset($data['author_url']);
    unset($data['author_name']);
    return $data;
}
add_filter('oembed_response_data', 'disable_embeds_filter_oembed_responsedata');


if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'Options',
        'menu_title'    => 'Options',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false,

    ));
}




// add new menu
register_nav_menus(array(
    'mobile_menu' => 'Menu Mobile',
    'mobile_menu_right' => 'Footer Menu Right',
));



add_filter('acf/fields/flexible_content/layout_title/name=main_content', 'my_acf_fields_flexible_content_layout_title', 10, 4);
function my_acf_fields_flexible_content_layout_title($title, $field, $layout, $i)
{
    $title = $layout["label"];
    if ($text = get_sub_field('section_title')) {
        $title .= ' <b>(' . esc_html($text) . ')</b>';
    } else {
        if ($text = get_sub_field('title')) {
            $title .= ' <b>(' . esc_html($text) . ')</b>';
        }
    }
    return $title;
}


/*@ Change WordPress Admin Login Logo */
if (!function_exists('tf_wp_admin_login_logo')) :

    function tf_wp_admin_login_logo()
    { ?>
        <style type="text/css">
            body.login div#login h1 a {
                background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.png"; ?>');

            }
        </style>
<?php }

    add_action('login_enqueue_scripts', 'tf_wp_admin_login_logo');

endif;

add_filter('wpcf7_autop_or_not', '__return_false');
add_filter('wpcf7_form_elements', function ($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

function get_breadcrumb()
{
    echo '<a href="' . home_url() . '" rel="nofollow" style="color:#fff;">Home </a>';
    if (is_category() || is_single()) {
        echo "  /  Blog";

        if (is_single()) {
            echo "    ";
        }
    } elseif (is_page()) {
        echo "  /  ";
        echo the_title();
    } elseif (is_search()) {
        echo "  /  ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}
// add_filter('acf/format_value/type=number', 'fix_number', 30, 3);
// function fix_number($value, $post_id, $field) {
//   $value = number_format($value);
//   return $value;
// }

add_action('admin_head', 'my_custom_admin_style');

function my_custom_admin_style()
{
    echo '<style>
    #edittag {
        max-width:100% !important;
    }
  </style>';
}


//ALLOW SVG UPLOADS
function upload_svg_files($allowed)
{
    if (!current_user_can('manage_options'))
        return $allowed;
    $allowed['svg'] = 'image/svg+xml';
    return $allowed;
}
add_filter('upload_mimes', 'upload_svg_files');


//FILTERS AGGREGATOR
require get_stylesheet_directory() . '/classes/class-ajaxfilter.php';
new AjaxFilter();



