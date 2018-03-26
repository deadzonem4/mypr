function shortcode_cause_funds() {
   ob_start();
   $data = '<div class="CauseSlider">';
       $query = new WP_Query($args = array('post_type' => 'cause-funds','posts_per_page' => -1));
           while( $query->have_posts() ):$query->the_post();
           $data .= '<div class="cause-fund">';
           $thumb_id = get_post_thumbnail_id();
           $thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
               $data .= '<div class="cause-fund-image"><img src="'.$thumb_url[0].'" alt="cause fund image"></div>';
               $data .= '<div class="cause-fund-details"><h3>'.get_the_title().'</h3><p>'.get_the_content().'</p></div>';
               $data .= '<div class="cause-fund-link"><a href="'.get_field("button_link").'"target="_blank">'.get_field("button_text").'</a></div>';
           $data .= '</div>';
       endwhile; wp_reset_postdata();
   $data .= '</div>';
   return $data;
} 
add_shortcode('sc_cause_funds','shortcode_cause_funds');