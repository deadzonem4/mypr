<?php

    if ( ! class_exists( 'Redux_Framework_sample_config' ) ) {

        class Redux_Framework_sample_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                $this->initSettings();

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => esc_html__( 'Section via hook','designed'),
                    'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>','designed'),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;','designed'), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview','designed'); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview','designed'); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo esc_attr($this->theme->display( 'Name' )); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( esc_html__( 'By %s','designed'), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( esc_html__( 'Version %s','designed'), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . esc_html__( 'Tags','designed') . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo esc_attr($this->theme->display( 'Description' )); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.','designed') . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes','designed'), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';

                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => esc_html__( 'General Settings','designed'),
                    'icon'   => 'el el-cogs',
                    'fields' => array( // header end

                        array(
                            'id'       => 'tmnf-main-logo',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Main Logo','designed'),
                            'desc'     => esc_html__( 'Upload a logo for your theme','designed'),
                        ),

                        array(
                            'id'       => 'tmnf-small-logo',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Small Logo','designed'),
                            'desc'     => esc_html__( 'Visible in sticky navigation','designed'),
                        ),
						
                        array(
                            'id'       => 'tmnf-uppercase',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Uppercase Fonts','designed'),
                            'subtitle' => esc_html__( 'You can enable general uppercase here.','designed'),
                            'default'  => '1'// 1 = on | 0 = off
                        ),

						
						array(
                            'id'       => 'tmnf-mailchimp',
                            'type'     => 'text',
                            'title'    => esc_html__( 'MailChimp Shortcode','designed'),
                            'subtitle' => esc_html__( 'Create MailChimp subscribe form and paste shortcode here.','designed' ),
							'default'  => '',
                            'validate' => 'html',
						),
						
					
					
					// section end
                    )
                );
				// General Layout THE END




                $this->sections[] = array(
                    'title'  => esc_html__( 'News Ticker Settings','designed'),
                    'fields' => array( // header end
						
                      	array(
                            'id'       => 'tmnf-ticker-position',
                            'type'     => 'radio',
                            'title'    => esc_html__('News Ticker: Position','designed'),
                            'subtitle' => esc_html__('Select position for "Ticker" section','designed'),
                            //Must provide key => value pairs for radio options
                            'options'  => array(
                                'pos_below' => 'Below Header',
                                'pos_above' => 'Above Header',
                                '' => 'Disabled',
                            ),
                            'default'  => 'pos_dis'
                        ),
						
						 array(
							'id' => 'tmnf-ticker-cats',
							'type' => 'select',
							'data' => 'categories',
							'multi' => true,
							'title' => esc_html__('News Ticker: Featured categories (required)','designed'),
							'default'  => ''
						),
						
						 array(
							'id' => 'tmnf-ticker-nr',
							'type' => 'select',
							'title' => esc_html__('News Ticker: Number of posts','designed'),
							'options'  => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                                '6' => '6',
                                '7' => '7',
                                '8' => '8',
                                '9' => '9',
                                '10' => '10',
							),
							'default'  => '4'
						),
						
						

					
					// section end
                    )
                );
				// Sliders Settings THE END







                $this->sections[] = array(
                    'type' => 'divide',
                );




                $this->sections[] = array(
                    'title'  => esc_html__( 'Primary Styling','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end



						array(
                            'id'          => 'tmnf-body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Typography','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'body' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as general text.','designed'),
                            'default'     => array(
                                'color'       => '#303030',
                                'font-style'  => '400',
                                'font-family' => 'Varela Round',
                                'google'      => true,
                                'font-size'   => '13px',
                                'line-height' => '26px'
                            ),
                        ),

                        array(
                            'id'       => 'tmnf-background',
                            'type'     => 'background',
                            'title'    => esc_html__( 'Main Body Background','designed'),
                            'subtitle' => esc_html__( 'Body background with image, color, etc.','designed'),
                            'output'   => array('body,.footer-fix,.footer-icons ul.social-menu li a' ),
                            'default'     => array(
                                'background-color'       => '#f9f9f9',
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-ghost',
							'type'      => 'color',
							'title'     => esc_html__('Ghost Background Color','designed'),
							'subtitle'  => esc_html__('Pick a alternative background color (similar to Main Body Background)','designed'),
							'default'   => '#fff',
							'output'    => array(
								'background-color' => '.ghost,#comments .navigation a,a.page-numbers,.page-numbers.dots,.page-link a span,.tmnf_menu ul.menu'
							)
						),

                        array(
                            'id'       => 'tmnf-link-color',
                            'type'     => 'link_color',
                            'title'    => esc_html__( 'Links Color Option','designed'),
                            'subtitle' => esc_html__( 'Pick a link color','designed'),
							'output'   => array( 'a' ),
                            'default'  => array(
                                'regular' => '#000',
                                'hover'   => '#FF5722',
                                'active'  => '#000',
                            )
                        ),
						

						
						array(
							'id'        => 'tmnf-color-entry-link',
							'type'      => 'color',
							'title'     => esc_html__('Entry Links (in post texts)','designed'),
							'subtitle'  => esc_html__('Pick a custom color for post links.','designed'),
							'default'   => ' #FF5722',
							'output'    => array(
								'color' => '.entry p a,.additional a',
							)
						),
						
                        array(
                            'id'       => 'tmnf-primary-border',
							'type'      => 'color',
							'title'     => esc_html__('Borders Color','designed'),
							'subtitle'  => esc_html__('Pick a color for primary borders','designed'),
							'default'   => '#efefef',
							'output'    => array(
								'border-color' => '.p-border,.widgetable,.postbarLeft .widgetable,.ml-block-ml_3_column_block,.ml-first.ml-block-ml_3_column_block,.mag-one div.item,.meta,ul.social-menu li a,h3#reply-title,.tagcloud a,.page-numbers,input,textarea,select,.products,.nav_item a,.tp_recent_tweets ul li,.tmnf_menu ul.menu>li,.tmnf_menu ul.menu>li>a,h3#comments-title,h3#reply-title',
								'background-color' => '.slide-nav::after',
							)
						),
						
                        array(
                            'id'       => 'tmnf-custom-css',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Custom CSS','designed'),
                            'subtitle' => esc_html__( 'Quickly add some CSS to your theme by adding it to this block.','designed'),
                            'desc'     => esc_html__( '','designed'),
                        ),


					// section end
                    )
                );
				// Primary styling THE END
				




                $this->sections[] = array(
                    'title'  => esc_html__( 'Header Styling','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end
						

                      	array(
                            'id'       => 'tmnf-header-layout',
                            'type'     => 'radio',
                            'title'    => esc_html__('Header Layout (styling)','designed' ),
                            //Must provide key => value pairs for radio options
                            'options'  => array(
                                'classic-header' => esc_html__('Classic Header','designed'),
                                'slim-header' => esc_html__('Slim Header (Small logo image required)','designed'),
                            ),
                            'default'  => 'classic-header'
                        ),
					
						

						
						array(
							'id'        => 'tmnf-bg-topnav',
							'type'      => 'background',
							'title'     => esc_html__('Topnav + Navigation Background Color','designed'),
							'subtitle'  => esc_html__('Pick a background color for header.','designed'),
							'output'    => array('background-color' => '#topnav,#navigation,.nav li ul,.gticker-wrapper.has-js,.gticker-swipe,.gticker-swipe span',),
                            'default'     => array(
                                'background-color'       => '#f9f9f9',
                            ),
						),


						array(
                            'id'          => 'tmnf-header-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Navigation Typography','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.nav li>a,#topnav h2,ul.loop li h4 a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as navigation text.','designed'),
                            'default'     => array(
                                'color'       => '#000',
                                'font-weight'  => '400',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '18px'
                            ),
                        ),
						
						
                        array(
                            'id'       => 'tmnf-topnav-links',
							'type'      => 'color',
							'title'     => esc_html__('Topnav Link Color','designed'),
							'subtitle'  => esc_html__('Pick a color for Topnav links','designed'),
							'default'   => '#000',
							'output'    => array(
								'color' => '#topnav h2,#topnav ul.social-menu li a,.gticker-content a',
							)
						),
						
						array(
							'id'        => 'tmnf-color-myheader',
							'type'      => 'background',
							'title'     => esc_html__('Header Background Color','designed'),
							'subtitle'  => esc_html__('Pick a background color for header.','designed'),
							'output'    => array('background-color' => '#header',),
                            'default'     => array(
                                'background-color'       => '#fff',
                            ),
						),
						
						array(
							'id'        => 'tmnf-links-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Header Link Color','designed'),
							'subtitle'  => esc_html__('Pick a color for header links.','designed'),
							'default'   => '#333',
							'output'    => array(
								'color' => '#header h1 a',
							)
						),
						
						array(
							'id'        => 'tmnf-text-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Header Icon Color','designed'),
							'subtitle'  => esc_html__('Pick a color for header links.','designed'),
							'default'   => '#333',
							'output'    => array(
								'color' => 'a.searchtrigger',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Navigation Links: Hover Background Color','designed'),
							'subtitle'  => esc_html__('Pick a hover color for header links.','designed'),
							'default'   => '#c1bd91',
							'output'    => array(
								'color' => '#header h1 a:hover,.nav ul li a:hover ',
								'background-color' => '.nav>li.current-menu-item>a,.menu-item-has-children>a::after,.mega2>a::after',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-bg-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Navigation Links: Hover Color','designed'),
							'subtitle'  => esc_html__('Pick a hover color for header links.','designed'),
							'default'   => '#fff',
							'output'    => array(
								'color' => '.nav>li.current-menu-item>a',
								'background-color' => '.menu-item-has-children>a::after:hover,.mega2>a::after:hover',
							)
						),
						
						
                        array(
                            'id'       => 'tmnf-header-border',
							'type'      => 'color',
							'title'     => esc_html__('Header Border Color','designed'),
							'subtitle'  => esc_html__('Pick a color for header borders','designed'),
							'default'   => '#000',
							'output'    => array(
								'border-color' => '.navhead',
								'border-top-color' => '.nav>li>ul:after',
							)
						),
                        array(
                            'id'             => 'tmnf-width-header',
                            'type'           => 'dimensions',
                            'output'   => array( '#titles' ),
                            'units'          => 'px', 
                            'units_extended' => 'true',  
                            'height'          => false, 
                            'title'          => esc_html__( 'Header Title/Logo Width Option','designed'),
                            'subtitle'       => esc_html__( 'Choose the width limitation for header logo.','designed'),
                            'default'        => array(
                                'width'  => 300,
                            )
                        ),

                        array(
                            'id'       => 'tmnf-spacing-header',
                            'type'     => 'spacing',
                            'output'   => array( '#titles' ),
                            'mode'     => 'margin',
                            'all'      => false,
                            'right'         => false,    
                            'left'          => false,     
                            'units'         => 'px',      
                            'title'    => esc_html__( 'Header Title/Logo Margin','designed'),
                            'subtitle' => esc_html__( 'Choose the margin for header logo.','designed'),
                            'default'  => array(
                                'margin-top'    => '40px',
                                'margin-bottom' => '40px',
                            )
                        ),


					// section end
                    )
                );
				// header styling THE END






                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer Styling','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end


						array(
                            'id'          => 'tmnf-footer-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Footer Typography','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '#footer,#footer input' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as footer text.','designed'),
                            'default'     => array(
                                'color'       => '#565656',
                                'font-style'  => '400',
                                'font-family' => 'Varela Round',
                                'google'      => true,
                                'font-size'   => '13px',
                                'line-height' => '27px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Background Color','designed'),
							'subtitle'  => esc_html__('Pick a background color for footer.','designed'),
							'default'   => '#F7F7F7',
							'output'    => array(
								'background-color' => '#footer,#footer .searchform input.s'
							)
						),
						
						array(
							'id'        => 'tmnf-links-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Color','designed'),
							'subtitle'  => esc_html__('Pick a color for footer links.','designed'),
							'default'   => '#1c1c1c',
							'output'    => array(
								'color' => '#footer a,#footer h2,#footer .bottom-menu li a,#footer h3,#footer #serinfo-nav li a,#footer .meta,#footer .meta a,#footer .searchform input.s',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Hover Color','designed'),
							'subtitle'  => esc_html__('Pick a hover color for footer links.','designed'),
							'default'   => '#f98a00',
							'output'    => array(
								'color' => '#footer a:hover,.sticky a:hover',
							)
						),
						
						
                        array(
                            'id'       => 'tmnf-footer-border',
							'type'      => 'color',
							'title'     => esc_html__('Footer Borders','designed'),
							'subtitle'  => esc_html__('Pick a color for footer borders.','designed'),
							'default'   => '#eaeaea',
							'output'    => array(
								'border-color' => '.footer-top,#footer .foocol,#copyright,#footer .tagcloud a,#footer .tp_recent_tweets ul li,#footer .p-border,.sticky .p-border,#footer .searchform input.s,#footer input,#footer ul.social-menu li a',
							)
						),


					// section end
                    )
                );
				// footer styling THE END









                $this->sections[] = array(
                    'title'  => esc_html__( 'Typography','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-bold',
                    'fields' => array( // header end


						array(
                            'id'          => 'tmnf-h1',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H1 Font Style','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h1' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H1.','designed'),
                            'default'     => array(
                                'color'       => '#000',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '45px',
                                'line-height' => '38px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-slider',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Large Titles (Slider, Archives)','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.mainflex-large h2,h1.entry-title,.single-post .tmnf_hero.thumb_disabled h1.entry-title' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for post headings.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '65px',
                                'line-height' => '65px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-titles',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Post Titles','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.maso-1 h2,h2.archiv,.tmnf-product-info-single,.item_2_big h2,.item_3_big h2' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for post titles.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '32px',
                                'line-height' => '36px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H2 Font Style + Block Headings','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h2,.entry h2,h2.block,h2.widget,blockquote,.tmnf-product-info,div.item_2_small::before' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '24px',
                                'line-height' => '31px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h3',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H3 Font Style','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h3,.comment-author cite,.tmnf_menu ul.menu>li>a,.su-button-style-flat span,.mm-inner h2' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H3.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '20px',
                                'line-height' => '26px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h4',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H4 Font Style','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h4,h3.posttitle' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H4.','designed'),
                            'default'     => array(
                                'color'       => '#000',
                                'font-weight'  => '400',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '18px',
                                'line-height' => '26px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h5',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H5 Font Style + Buttons','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h5,.widgetable ul.menu>li>a,.wp_review_tab_widget_content a,.bottomnav h2,#serinfo-nav li a,a.mainbutton,h5.review-title,#comments .navigation a,.slide-nav li>a,#content .topic a, #content .reply a,#respond .form-submit input,.post-pagination' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H5.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '400',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '12px',
                                'line-height' => '16px'
                            ),
                        ),	
						
						array(
                            'id'          => 'tmnf-h6',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H6 Font Style','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h6,.review-total-only' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H6.','designed'),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '25px'
                            ),
                        ),
						


					// section end
                    )
                );
				// typography styling THE END










                $this->sections[] = array(
                    'title'  => esc_html__( 'Other Styling','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end
						
	
						
						array(
                            'id'          => 'tmnf-meta',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Meta Sections - Font Style','designed'),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.meta,.meta a,.meta_more,.meta_more a,.wp-review-tab-postmeta' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for meta sections.','designed'),
                            'default'     => array(
                                'color'       => '#8c8b7e',
                                'font-weight'  => '400',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '11px',
                                'line-height' => '18px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Color','designed'),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.','designed'),
							'default'   => '#c1bd91',
							'output'    => array(
								'background-color' => 'a.searchSubmit,.ribbon,.widgetable ul.menu>li.current-menu-item>a,.menu-post p.meta.cat,.nav-previous a:hover,#respond #submit,.flex-direction-nav a,li.current a,.page-numbers.current,a.mainbutton,.blogger .format-quote,.blogger .format-quote:nth-child(2n),.products li .button.add_to_cart_button,a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link,ul.social-menu li a:hover,.nav li.special,.wrapper .review-total-only',
								'border-color' => '.products li .button.add_to_cart_button,ul.social-menu li a:hover,h2.widget,.mm-inner h2,.related-wrap,.hrline,.hrlineB',
								'color' => 'div.item_2_small::before',
							)
						),
						
						array(
							'id'        => 'tmnf-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Color','designed'),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.','designed'),
							'default'   => '#fff',
							'output'    => array(
								'color' => 'a.searchSubmit,.ribbon,.ribbon a,#content .reply a,.menu-post p.meta.cat,.widgetable ul.menu>li.current-menu-item>a,.entry a.ribbon,.ribbon blockquote,.format-quote blockquote p,#hometab li.current a,#respond #submit,#comments .navigation a:hover,.flex-direction-nav a,#footer a.mainbutton,a.mainbutton,.blogger .format-quote,.blogger .format-quote a,.products li .button.add_to_cart_button,a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link,#footer #hometab li.current a,ul.social-menu li a:hover,#header ul.social-menu li a:hover,#footer ul.social-menu li a:hover,.page-numbers.current,.nav li.special>a,#topnav ul.social-menu li a:hover, #footer input.submit,.wrapper .review-total-only,.blogger .review-star .review-result i,.builder .review-star .review-result i',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Hover Color','designed'),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.','designed'),
							'default'   => '#222',
							'output'    => array(
								'background-color' => 'a.searchSubmit:hover,.ribbon:hover,a.mainbutton:hover,.entry a.ribbon:hover'
							)
						),
						
						array(
							'id'        => 'tmnf-hover-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Hover Color','designed'),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.','designed'),
							'default'   => '#fff',
							'output'    => array(
								'color' => '#header a.searchSubmit:hover,#footer a.mainbutton:hover,.ribbon:hover,.ribbon:hover a,.ribbon a:hover,.entry a.ribbon:hover,a.mainbutton:hover,.post.format-quote:hover blockquote p,.post.format-quote:hover i,#mainhead a.searchSubmit',
							)
						),
						
						array(
							'id'        => 'tmnf-images-bg',
							'type'      => 'color',
							'title'     => esc_html__('Images Background Color','designed'),
							'subtitle'  => esc_html__('Pick a custom background color for theme images.','designed'),
							'default'   => '#111',
							'output'    => array(
								'background-color' => '.imgwrap,.mainflex,.post-nav-image,.page-head,.maso,.item_4,.menu-post .inner,.mm-inner',
							)
						),
						
						
						
						array(
							'id'        => 'tmnf-images-text',
							'type'      => 'color',
							'title'     => esc_html__('Images Text/Link Color','designed'),
							'subtitle'  => esc_html__('Pick a custom text color for image texts (overlay)','designed'),
							'default'   => '#fff',
							'output'    => array(
								'color' => '.flexinside,#footer .tmnf-featured-slider a,p.authorinfo,#footer .tmnf-featured-slider p,#footer .flex-direction-nav a,.mosaicinside a,.page-head h1.entry-title,.page-head a,.mosaicinside .meta,.page-head,.tmnf_icon,.page-head p,.page-head a,.flexinside a,.flexinside p.meta,.flexinside p.meta a,.slide-nav li a,ul.related li h4 a,.single-post .tmnf_hero h1.entry-title,.tmnf-featured-slider a,.tmnf-featured-slider p,.white_over a,.white_over,.white_over p,.mm-inner h2,.mm-inner h2 a',
							)
						),




					// section end
                    )
                );
				// other styling THE END









                $this->sections[] = array(
                    'type' => 'divide',
                );	



                
                $this->sections[] = array(
                    'title'  => esc_html__( 'Post Settings','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-edit',
                    'fields' => array( // header end


                        array(
                            'id'       => 'tmnf-post-image-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Featured Image','designed'),
                            'subtitle' => esc_html__( 'Tick to disable featured image in single post page.','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
					

						
                        array(
                            'id'       => 'tmnf-post-meta-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable "Meta" sections','designed'),
                            'subtitle' => esc_html__( 'Tick to disable post "inforamtions" - date, category etc. below post titles','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-author-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Author Info Section','designed'),
                            'subtitle' => esc_html__( 'Tick to disable author section in single post page.','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-nextprev-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Next/Previous Post Section','designed'),
                            'subtitle' => esc_html__( 'Tick to disable Next/Previous section in single post page.','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-likes-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Tags Section','designed'),
                            'subtitle' => esc_html__( 'Tick to disable tags section in single post page.','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-related-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Related Posts Section','designed'),
                            'subtitle' => esc_html__( 'Tick to disable related section in single post page.','designed'),
                            'desc'     => esc_html__( '','designed'),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
					
					
					// section end
                    )
                );
				// post settings THE END





                
                $this->sections[] = array(
                    'title'  => esc_html__( 'Social Networks','designed'),
                    'icon'   => 'el el-share',
                    'fields' => array( // header end
						
						
						array(
                            'id'       => 'tmnf-social-bottom-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable/Disable Social Section (Above Footer)','designed' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
					

                        array(
                            'id'       => 'tmnf-social-rss',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Rss Feed','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
                        array(
                            'id'       => 'tmnf-social-facebook',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Facebook','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-twitter',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Twitter','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-google',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Google+','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-pinterest',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Pinterest','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-instagram',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Instagram','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-youtube',
                            'type'     => 'text',
                            'title'    => esc_html__( 'You Tube','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-vimeo',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Vimeo','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-tumblr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Tumblr','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-500',
                            'type'     => 'text',
                            'title'    => esc_html__( '500px','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-flickr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Flickr','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-linkedin',
                            'type'     => 'text',
                            'title'    => esc_html__( 'LinkedIn','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-foursquare',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Foursquare','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-dribbble',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Dribbble','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-skype',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Skype','designed'),
                            'subtitle' => esc_html__( 'Enter skype URL','designed'),
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-stumbleupon',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Stumbleupon','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-github',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Github','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-spotify',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Spotify','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-soundcloud',
                            'type'     => 'text',
                            'title'    => esc_html__( 'SoundCloud','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-xing',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Xing','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-whatsapp',
                            'type'     => 'text',
                            'title'    => esc_html__( 'WhatsApp','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-vk',
                            'type'     => 'text',
                            'title'    => esc_html__( 'VK','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						

					// section end
                    )
                );
				// social networks THE END
				
				
				
				
				
                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer','designed'),
                    'desc'   => esc_html__( '','designed'),
                    'icon'   => 'el el-website',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(

                        array(
                            'id'       => 'tmnf-footer-logo',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Footer Logo','designed'),
                            'desc'     => esc_html__( 'Upload a footer logo for your theme.','designed'),
                        ),
						
						
						array(
                            'id'       => 'tmnf-footer-editor',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Footer Text','designed'),
                            'subtitle' => esc_html__( 'Just like a text box widget.','designed'),
                            'desc'     => esc_html__( 'This field is HTML validated!','designed'),
							'default'  => '',
                            'validate' => 'html',
						),
				
				
				
				
					// section end
                    )
                );
				// custom footer THE END		
				
				


                $this->sections[] = array(
                    'title'  => esc_html__( 'Static Ads','designed'),
                    'icon'   => 'el el-website',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(


						array(
                            'id'       => 'tmnf-headad-script',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Header Script Code','designed'),
                            'desc'     => esc_html__( 'Put your code here','designed'),
							'default'  => '',
						),

                        array(
                            'id'       => 'tmnf-headad-image',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Header Ad - image','designed'),
                            'subtitle' => esc_html__( 'Enter full URL of your ad image (banner)','designed'),
                        ),
						
						
                        array(
                            'id'       => 'tmnf-headad-target',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Header Ad - target URL','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
						array(
                            'id'       => 'tmnf-postad-script',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Post Script Code','designed'),
                            'desc'     => esc_html__( 'Put your code here','designed'),
							'default'  => '',
						),

                        array(
                            'id'       => 'tmnf-postad-image',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Post Ad - image','designed'),
                            'subtitle' => esc_html__( 'Enter full URL of your ad image (banner)','designed'),
                        ),
						
						
                        array(
                            'id'       => 'tmnf-postad-target',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Post Ad - target URL','designed'),
                            'subtitle' => esc_html__( 'Enter full URL','designed'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
				
				
				
				
					// section end
                    )
                );
				// custom footer THE END	


				

                $this->sections[] = array(
                    'type' => 'divide',
                );		

                

                $this->sections[] = array(
                    'title'  => esc_html__( 'Import / Export','designed'),
                    'desc'   => esc_html__( 'Import and Export your Redux Framework settings from file, text or URL.','designed'),
                    'icon'   => 'el el-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
                    ),
                );


            }
			
			

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => esc_html__( 'Theme Information 1','designed'),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>','designed')
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => esc_html__( 'Theme Information 2','designed'),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>','designed')
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>','designed');
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'themnific_redux',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => esc_html__( 'Designed - admin panel','designed'),
                    'page_title'           => esc_html__( 'Designed admin panel','designed'),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'themnific-options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'el el-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.


                $this->args['admin_bar_links'][] = array(
                    'href'   => 'https://dannci.freshdesk.com/support/solutions/articles/5000167124-support-policy',
					'target'   => '_blank',
                    'title' => esc_html__( 'Support','designed'),
                );

                $this->args['admin_bar_links'][] = array(
                    'href'   => 'http://themnific.com/',
					'target'   => '_blank',
                    'title' => esc_html__( 'Our themes','designed'),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://dannci.freshdesk.com/support/solutions/articles/5000167124-support-policy',
					'target'   => '_blank',
                    'title' => 'Support',
                    'icon'  => 'el el-wrench-alt'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://twitter.com/dannci',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el el-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://themnific.com/',
                    'title' => 'All our themes! ',
					'target'   => '_blank',
                    'icon'  => 'el el-fire'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( esc_html__( 'Hello in theme admin panel','designed'), $v );
                } else {
                    $this->args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>','designed');
                }

                // Add content after the form.
                $this->args['footer_text'] = esc_html__( 'Redux & Dannci & Themnific','designed');
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public static function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_sample_config();
    } else {
        echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            $return['warning'] = $field;

            return $return;
        }
    endif;


// TMNF admin panel styling	
function addPanelCSS() {
    wp_register_style(
        'redux-tmnf-css',
        get_template_directory_uri() .'/redux-framework/assets/redux-themnific.css',
        array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
        time(),
        'all'
    ); 
    wp_enqueue_style('redux-tmnf-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/themnific_redux/enqueue', 'addPanelCSS' );


// remove redux notices
function landtheme_remove_redux_notices() { 
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'landtheme_remove_redux_notices');