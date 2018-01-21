<?php

/**
 * Class Es_Dashboard_Page
 */
class Es_Dashboard_Page extends Es_Object
{
    /**
     * Add actions for dashboard page.
     */
    public function actions()
    {
        add_action( 'admin_enqueue_scripts', array( $this , 'enqueue_styles' ) );
    }

    /**
     * Enqueue styles for dashboard page.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        $vendor = 'admin/assets/css/vendor/';

        wp_register_style( 'es-scroll-style', ES_PLUGIN_URL . $vendor . 'jquery.mCustomScrollbar.css' );
        wp_enqueue_style( 'es-scroll-style' );

        wp_register_style( 'es-admin-slick-style', ES_PLUGIN_URL . $vendor . 'slick.css' );
        wp_register_style( 'es-admin-slick-theme-style', ES_PLUGIN_URL . $vendor . 'slick-theme.css' );

        wp_enqueue_style( 'es-admin-slick-style' );
        wp_enqueue_style( 'es-admin-slick-theme-style' );
    }

    /**
     * Render dashboard page.
     *
     * @return void
     */
    public static function render()
    {
        $template = apply_filters( 'es_dashboard_page_template_path', ES_ADMIN_TEMPLATES . '/dashboard/dashboard.php' );

        if ( file_exists( $template ) ) {
            include_once( $template );
        }
    }

    /**
     * Return shortcodes list for dashboard page.
     *
     * @return array
     */
    public static function get_shortcodes_list()
    {
        return apply_filters( 'es_get_shortcodes_list', array(
            '[es_my_listing layout="list | 3_col | 2_col"]',
            '[es_my_listing sort="recent | highest_price | lowest_price | most_popular"] ',
            '[es_my_listing  prop_id="1,2,5,6...n"]',
            '[es_my_listing category="category name"]',
            '[es_my_listing status="status name"]',
            '[es_my_listing type="type name"]',
            '[es_my_listing rent_period="rent period 1"]',
            '[es_property_map show="all"] (PRO)',
            '[es_property_map type="your type"] (PRO)',
            '[es_property_map category="your category"] (PRO)',
            '[es_property_map status="your status"] (PRO)',
            '[es_property_map rent_period="your period"] (PRO)',
            '[es_property_map limit=20] (PRO)',
            '[es_property_map ids="1,2,3,4,5"] (PRO)',
            '[es_property_map address="your address string"] (PRO)',
            '[es_property_slideshow] (PRO)',
            '[es_city city="city name"] (PRO)',
            '[es_state state="state name"] (PRO)',
            '[es_country country="country name"] (PRO)',
            '[es_labels label="label_name"] (PRO)',
            '[es_features feature="a,b,c,d"] (PRO)',
            '[es_featured_props] ',
            '[es_latest_props] ',
            '[es_cheapest_props]',
            '[es_agents] (PRO)',
            '[es_listing_agent name="agent username"] (PRO)',
            '[es_subscription_table] (PRO)',
            '[es_register] (PRO)',
            '[es_login] (PRO)',
            '[es_prop_management] (PRO)',
            '[es_reset_pwd] (PRO)',
        ) );
    }

    /**
     * Return changelog array for dashboard page.
     *
     * @return mixed
     */
    public static function get_changelog_list()
    {
        return apply_filters( 'es_get_changelog_list', array(
            __( '3.3.3 (October 9, 2017)', 'es-plugin' ) => '<ul>
                <li>Fields builder bug with repeated fields fixed</li>
                <li>Scroll bar to drop-down fields in search added</li>
                <li>Images repeatition bug in lightbox gallery fixed</li>
                <li>Description text output in list view added</li>
                <li>Romanian language files added</li>
            </ul>',

            __( '3.3.2 (August 11, 2017)', 'es-plugin' ) => '<ul>
                <li>Alignment issue with fields in frontend fixed</li>
                <li>some minor fixes</li>
            </ul>',

            __( '3.3.1 (July 21, 2017)', 'es-plugin' ) => '<ul>
                <li>Price issue is fixed</li>
            </ul>',

            __( '3.3.0 (Juy 17, 2017)', 'es-plugin' ) => '<ul>
                <li>Fields builder added</li>
                <li>Currency manager added</li>
                <li>Search shortcode added [es_search]</li>
                <li>hu_HU language translation files added</li>
                <li>PDF brochure with Logo upload option updated (PRO)</li>
                <li>other minor fixes</li>
            </ul>',

            __( '3.2.1 (July 8, 2017)', 'es-plugin' ) => '<ul>
                <li>Search shortcode added</li>
                <li>New currenies are added (COP, Thai Baht, Turkish Lira, Hungarin Forint)</li>
                <li>PDF brochure updated (PRO)</li>
                <li>Labels icons fixed (PRO)</li>
                <li>hu_HU language files added</li>
                <li>minor fixes</li>
            </ul>',
          __( '3.2.0 (June, 17, 2017)', 'es-plugin' ) => '<ul>
                <li>WPML support added</li>
                <li>New currencies (Rp, AED, ZAR) added</li>
                <li>Drag & drop feature for new fields added (PRO & Premium)</li>
                <li>Powered by link fixed</li>
                <li>Remove icons in listings if empty values</li>
                <li>minor fixes</li>
            </ul>',

            __( '3.1.0 (MAY, 24, 2017)', 'es-plugin' ) => '<ul>
                <li>Frontend management added back</li>
                <li>Pagination bug fixed</li>
                <li>Some texts edited</li>
                <li>Display of excerpt text in subscriptions fixed</li>
                <li>Show/hide Title removed</li>
                <li>Extra layouts settings added</li>
                <li>Sharing via Facebook, Twitter, LinkedIn added</li>
                <li>Currency symbols issue fixed</li>
            </ul>',

            __( '3.0.2 (May, 10, 2017)', 'es-plugin' ) => '<ul>
                <li>Area field fixed</li>
                <li>Search widget enhanced by search by tags</li>
                <li>Bug with copying fields fixed (PRO)</li>
                <li>Hide title option removed from Settings</li>
                <li>Spanish and Russian language files updated</li>
                <li>Shortcode [es_my_listing category="for rent" posts_per_page="3" show_filter=0] fixed</li>
                <li>Bug with agents registration fixed (PRO)</li>
            </ul>',

            __( '3.0.1 (APRIL, 18, 2017)', 'es-plugin' ) => '<ul>
                <li>New currencies added: ₹ (INR), ¥ (JPY), Fr. (CHF), ₱ (PHP)</li>
                <li>Fixed some styles in description html text box</li>
                <li>Migration from ver. 2.4.0 optimized</li>
                <li>Optimized image styles</li>
            </ul>',

            __( '3.0.0 (April, 12, 2017)', 'es-plugin' ) => '<ul>
                <li>Property became WP_Post entity</li>
                <li>Images upload via WP Media only</li>
                <li>Numerous new shortcodes added</li>
                <li>Search with drag & drop feature improved</li>
                <li>Archive page created, can be customized using wp hooks</li>
                <li>Pagination improved</li>
                <li>Google Map improved, option to add address with lat/lng fields added (PRO only)</li>
                <li>Labels became editable (PRO only)</li>
                <li>CSV Import improved, images import via link added (PRO only)</li>
                <li>Subscriptions: recurring payments added (PRO only)</li>
                <li>Frontend management replaced by limited admin area (PRO only)</li>
                <li>Admin logo upload added (PRO only)</li>
                <li>Other fixes..</li>
            </ul>',

            __( '2.4.0 (September 26, 2016)', 'es-plugin' ) => '<ul>
                <li>Issue with Upgrade to Pro option fixed</li>
            </ul>',

            __( '2.3.1 (August 21, 2016)', 'es-plugin' ) => '<ul>
                <li>Arbitrary file upload vulnerability fixed</li>
            </ul>',

            __( '2.3.0 (August 15, 2016)', 'es-plugin' ) => '<ul>
                <li>File upload vulnerability fixed</li>
                <li>Review and removal of session_start() and ob_start()</li>
                <li>MAP API issue fixed</li>
            </ul>',

            __( '2.2.3 (March 30, 2016)', 'es-plugin' ) => '<ul>
                <li>Permalinks issue fixed</li>
                <li>Price issue > 1 mln fixed</li>
                <li>beds and baths translation fixed</li>
                <li>Search bug fixed</li>
                <li>Subscription plans added (PRO)</li>
                <li>PDF bug with currency change fixed (PRO)</li>
                <li>New shortcode to display listings of a specific agent added (PRO)</li>
                <li>Automatic/manual approval of listings added (PRO)</li>
            </ul>Please read detailed description of release <a href="http://estatik.net/estatik-simple-pro-ver-2-2-0-released/" target="_blank">here</a>.',

            __( '2.2.2 (November 21, 2015)', 'es-plugin' ) => '<ul>
                <li>View first menu ON/OFF option added</li>
                <li>Bug with currency format 99 999 fixed</li>
                <li>Popup icon in admin map returned</li>
                <li>Search results on 2,3, etc. pages fixed</li>
                <li>Some grammatical errors corrected</li>
                <li>Half baths added to front-end management page (PRO)</li>
                <li>Correct redirection for agents after logged into front-end management page fixed (PRO)</li>
            </ul>',

            __( '2.2.1 (October 22, 2015)', 'es-plugin' ) => '<ul>
                <li>Search by category fixed</li>
            </ul>',

            __( '2.2.0 (October 22, 2015)', 'es-plugin' ) => '<ul>
                <li>Map issues fixed in frontend, admin and lightbox</li>
                <li>Half bathroom option added</li>
                <li>Dark/light style mode added</li>
                <li>Search widget updated with separate Country, State and City drop-down fields</li>
                <li>New shortcode for city added [es_city city="city name"]</li>
                <li>Dimension display of Area and Lot size fields bug fixed</li>
                <li>Slashes // in new fields removed</li>
                <li>Agent phone field bug fixed</li>
                <li>Deprecated method for wp_widget updated</li>
            </ul>Please read full description of new release <a href="http://estatik.net/estatik-simple-pro-ver-2-2-0-released/" target="_blank">here</a>.',

            __( '2.1.0 (July 7, 2015)', 'es-plugin' ) => '<ul>
                <li>New shortcodes for categories added: [es_category category="for sale"],[es_category type="house"],[es_category status="open"].</li>
                <li>New shortcode for search results page added.</li>
                <li>French translation added.</li>
                <li>Google Map API option added.</li>
                <li>Search widget results page bug fixed.</li>
                <li>Description box bug with text fixed.</li>
                <li>Display of area/lot size dimensions on front-end fixed.</li>
                <li>PRO: PDF translation issue fixed.</li>
                <li>PRO: PDF display in IE and Chrome error fixed.</li>
                <li>PRO: Google Map API option added.</li>
                <li>PRO: Copying images after CSV import fixed.</li>
                </ul>Please read full description of new release <a href="http://estatik.net/estatik-2-1-release-no-more-coding-from-now/" target="_blank">here</a>.',

            __( '2.0.1', 'es-plugin' ) => '<ul>
                <li>Italian translation added</li>
                <li>Spanish translation added</li>
                <li>Arabic translation added</li>
                </ul>Please read full description of new release <a href="http://estatik.net/estatik-2-0-terrific-released-map-view-lots-of-major-fixes-done/" target="_blank">here</a>.',

            __( '2.0 (May 16, 2015)', 'es-plugin' ) => '<ul>
                <li>Safari responsive layout issue fixed.</li>
                <li>Google Map icons issue fixed.</li>
                <li>PRO - HTML editor added.</li>
                <li>PRO - Lightbox on single property page added.</li>
                <li>PRO - Tabs issue fixed.</li>
                <li>PRO - Map view shortcodes added.</li>
                <li>PRO - Map view widget added.</li>
                <li>PRO - Option to use different layouts added.</li>
                </ul>',

            __( '1.1.1', 'es-plugin' ) => '<ul>
                <li>Issue with Google Map API fixed</li>
                <li>Translation into Russian added</li>
                </ul>',

            __( '1.0.1', 'es-plugin' ) => '<ul>
                <li>jQuery conflicts fixed.</li>
                <li>Language files added.</li>
                </ul>',

            __( '1.0.0 (March 24, 2015)', 'es-plugin' ) => '<ul>
                <li>Data manager is added.</li>
                <li>Property listings shortcodes are added.</li>
                <li>Search widget is added.</li></ul>
            ',
        ) );
    }

    /**
     * Return themes list for dashboard page.
     *
     * @return mixed|void
     */
    public static function get_themes_list()
    {

	    return apply_filters( 'es_get_themes_list', array(
		    'trendy' => array(
			    'link' => 'https://estatik.net/product/theme-trendy-estatik-pro/',
			    'image' => ES_ADMIN_IMAGES_URL . 'es_theme_trendy.png'
		    ),
		    'native' => array(
			    'link' => 'https://estatik.net/?post_type=product&p=12&preview=true',
			    'image' => ES_ADMIN_IMAGES_URL . 'es_theme_native.png'
		    )
	    ) );
    }
}
