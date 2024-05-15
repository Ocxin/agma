<?php
class AjaxFilter
{
    public function __construct()
    {
        add_action('wp_ajax_filter_posts', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_filter_posts', [$this, 'handle_ajax_request']);
    }

    public function handle_ajax_request()
    {
        $term_slug = sanitize_text_field($_GET['term-slug']);
        $post_type = sanitize_text_field($_GET['post_type']);
        $is_slider = filter_var($_GET['is-slider'], FILTER_VALIDATE_BOOLEAN);
        $layout_tile = sanitize_text_field($_GET['layout-tile']);
        $filter_for = sanitize_text_field($_GET['filter-for']);
    
        if (!$term_slug) {
            wp_send_json_error('No category specified', 400);
            return;
        }

        $posts = $this->fetch_posts($term_slug, $post_type, $filter_for);
        $slides = $this->generate_html_for_posts($posts, $layout_tile, $is_slider);

        wp_send_json_success(['html' => $slides]);
    }

    private function fetch_posts($term_slug, $post_type, $filter_for)
    {
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => $filter_for,
                    'field' => 'slug',
                    'terms' => $term_slug
                ]
            ]
        ];

        $query = new WP_Query($args);
        return $query->have_posts() ? $query->posts : [];
    }

    private function generate_html_for_posts($posts, $layout_tile, $is_slider)
    {
        $slides = [];
        foreach ($posts as $post) {
            setup_postdata($post);
            ob_start();
            $this->choose_template_for_post($post, $layout_tile, $is_slider);
            $slide_html = ob_get_clean();
            wp_reset_postdata();
    
            // Aggiungi ciascuna slide all'array di slides
            $slides[] = $slide_html;
        }
        return $slides;
    }

    private function choose_template_for_post($post, $layout_tile, $is_slider)
    {
        $args = ['is_slider' => $is_slider];
        include(locate_template('partials/tile/' . $layout_tile . '.php'));
    }
}
