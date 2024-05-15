			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>
				</div><!-- /.col -->

				<?php
				get_sidebar();
				?>

				</div><!-- /.row -->
			<?php
			endif;
			?>
			</main><!-- /#main -->
			<footer id="footer" class="footer py-5 px-5">
				<div class="container">
					<div class="footer__body mb-5 py-4">
						<div class="row gy-5">
							<div class="col-sm-12 col-md-6 col-lg-4">
								<div id="footer__body__lists" class="d-flex align-items-center flex-wrap footer__body__lists ps-3 ">
									<?php $header_logo = get_theme_mod('header_logo'); // Get custom meta-value.
									?>
									<?php if (!empty($header_logo)) : ?>
										<a class="navbar-brand header__logo" href="/">
											<img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
										</a>
									<?php else : ?>
										<a class="navbar-brand header__logo" href="/">MARD<br>ELLO</a>
									<?php endif; ?>
									<a class="footer__body__lists__link mb-4" href="tel:<?php echo get_field('phone', 'option'); ?>"><span>Ufficio Vendita</span><br><?php echo get_field('phone', 'option'); ?></a>
									<a href="tel:<?php echo get_field('phone_two', 'option'); ?>" class="footer__body__lists__link"><span>Ufficio Vendita Bologna</span><br><?php echo get_field('phone_two', 'option'); ?></a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<div id="footer__body__lists-2" class="d-flex justify-content-between align-items-center flex-wrap footer__body__lists ps-3">
									<h3 class="footer__body__lists__heading w-100">Link utili</h3>
									<?php

									wp_nav_menu(
										array(
											'theme_location' => 'mobile_menu_right',
											'container'      => '',
											'menu_class'     => 'navbar-nav me-auto',
											'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
											'walker'         => new WP_Bootstrap_Navwalker(),
										)
									);

									?>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<div id="footer__body__lists-1" class="d-flex justify-content-between align-items-center flex-wrap footer__body__lists ps-3">
									<h3 class="footer__body__lists__heading w-100">Iscriviti alla Nesletter</h3>
									<?php echo do_shortcode('[contact-form-7 id="ab3aacb" title="Subscription Form"]'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-12 d-flex justify-content-between">
							<?php echo get_field('copy_right', 'option'); ?>
							<p>Web Agency Milano - <a href="https://www.bluedog.it" target="_blank">Bluedog</a></p>
						</div>
					</div>
			</footer>

			</div><!-- /#wrapper -->
			<?php
			wp_footer();
			?>
			</body>

			</html>