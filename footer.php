							<?php do_action( 'bb_before_footer' ); ?>
							</div>
						</div>
						<!-- /primary content -->
						
						<?php //get_sidebar(); ?>
					</div>
				</div>
				<!-- /main content -->
				
				<?php $jquery = bb_get_mystique_option( 'jquery' ); ?>
				
				<!-- footer -->
				<div id="footer">
					<!-- blocks + slider -->
					<div id="footer-blocks" class="page-content">
					
						<!-- block container -->
						<div class="slide-container clearfix">
							<ul class="slides">
								<!-- slide (100%) -->
								<li class="slide slide-1 page-content withSlider">
									<div class="slide-content">
										<ul class="blocks widgetcount-3">
											<li class="block block-widget_tags" id="instance-tags-1">
												<div class="block-content clearfix">
													<h4 class="title"><?php _e( 'Hot Tags', 'bb-mystique' ); ?></h4>
													<p class="frontpageheatmap"><?php bb_tag_heat_map(); ?></p>
												</div>
											</li>
											<li class="block block-widget_views" id="instance-views-2"><div class="block-content clearfix"><h4 class="title"><?php _e( 'Views', 'bb-mystique' ); ?></h4>
												<ul id="views">
												<?php foreach ( bb_get_views() as $the_view => $title ) : ?>
													<li class="view"><a href="<?php view_link( $the_view ); ?>"><?php view_name( $the_view ); ?></a></li>
												<?php endforeach; ?>
												</ul>
											</li>											
											<li class="block block-twitter" id="instance-twitterwidget-3"><div class="block-content clearfix"><h4 class="title"><?php _e( 'My Latest Tweets', 'bb-mystique' ); ?></h4>
												<?php bb_mystique_twitter_widget(); ?>
											</li>
										</ul>
									</div>
								</li>
								<!-- /slide -->
							</ul>
						</div>
						<!-- /block container -->
					</div>
					<!-- /blocks + slider -->
						
					<div class="page-content">
						<div id="copyright">
							
							<?php echo sprintf( __( '%1$s is proudly powered by <a href="%2$s">bbPress</a>. bb Mystique theme by <a href="%3$s">digitalnature</a> and ported by <a href="%4$s">Gautam</a>.', 'bb-mystique' ), bb_get_option( 'name' ), 'http://bbpress.org', 'http://digitalnature.ro', 'http://gaut.am/' ); ?>
							
							<!--[if lte IE 6]> <script type="text/javascript"> isIE6 = true; isIE = true; </script> <![endif]-->
							<!--[if gte IE 7]> <script type="text/javascript"> isIE = true; </script> <![endif]-->
						   
							<?php do_action( 'bb_foot' ); ?>
							
						</div>
						
					</div>
				</div>
				<!-- /footer -->

			</div>
		</div>
		<!-- /shadow -->

		<?php if ( $jquery ) : ?>
		<!-- page controls -->
		<div id="pageControls"></div>
		<!-- /page controls -->
		<?php endif; ?>
		<!--
		<?php
		global $bbdb;
		printf(
		__( 'This page generated in %s seconds, using %d queries.', 'bb-mystique' ),
		bb_number_format_i18n( bb_timer_stop(), 2 ),
		bb_number_format_i18n( $bbdb->num_queries )
		);
		?>
		-->
	</div>
	
</body>
</html>
