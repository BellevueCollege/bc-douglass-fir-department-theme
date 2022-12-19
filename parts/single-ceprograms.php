<?php
/**
 * CE Program Post Single Part
 *
 * @link https://github.com/BellevueCollege/ce-custom-functionality
 * @package Mayflower
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
	<main id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="main">
		<div class="post-heading">
			<h1><?php the_title(); ?></h1>
		</div>
		<article>
			<?php the_content(); ?>
		</article>


			<?php
			// Make sure CE Custom Functionality plugin is active.
			if ( class_exists( 'CE_Custom_Functions' ) && class_exists( 'CE_Plugin_Settings' ) ) :

				// Make sure AJAX method exists.
				if ( method_exists( 'CE_Custom_Functions', 'cecf_rest_course_info' ) ) :
					// Set PHP Variables.
					$field_id     = CE_Plugin_Settings::get_ce_field_id();
					$category_id  = get_post_meta( get_the_ID(), $field_id, true );
					$rest_version = CE_Custom_Functionality::$rest_version;
					$rest_url     = site_url( '/wp-json/ce/v' . $rest_version ); // full extension (example) is /ce/wp-json/ce/v1.

					// Make sure Category ID is in correct format (4 numeric chars).
					if ( preg_match( '/^(\d{4})$/', $category_id ) ) :
						?>

					<hr />
					<script type="text/javascript">
						/*
						* Pull course data from CampusCE
						*
						*/
						jQuery( document ).ready( function( $ ) { //START: Ajax

							// Hide response area so it can slide down later
							jQuery( "#response_area" ).hide( );

							// Base URL format for links to CampusCE
							var campusce_base_url = 'https://www.campusce.net/BC/course/course.aspx?C=';

							// Get data from WordPress
							$.ajax({
								method: 'GET',
								url: '<?php echo esc_url( $rest_url ); ?>' + '/courses/' + <?php echo esc_attr( $category_id ); ?>,
								data: {
									catid: <?php echo esc_attr( $category_id ); ?>
								}
							}).done(function(campusce_data){
								$('#ce-header, #ce-overlay').remove();

								var data = campusce_data; // Data from CampusCE
								var output = '';

								// verify data returned is JSON
								if ( typeof data == 'object' ) {
									output += '<h2>Current <?php the_title(); ?> Classes</h2>'
									output += '<ul class="list-group">';
									$.each( data.courses, function( i, course ) {

										// Set variables for ease of use
										var campusce_url = campusce_base_url + course.CourseID + '&mc=' + course.CategoryID + '&pc=' + data.category.ParentID;
										var title = course.Title;
										var descr = course.WebDescr;

										// Build HTML output
										output += '<li class\="list-group-item">';
										output += '<h3><a href="' + campusce_url + '">' + title + '</a></h3>';
										output += '<p>' + descr + ' <a class="btn btn-outline-primary btn-sm" href="' + campusce_url + '">More <span class="sr-only"> about ' + title + '</span> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>';
										output += '</li>';
									});
									output += '</ul>';

								} else { // if non - JSON data is returned
									output += '<div class="card card-body bg-light">';
									output += data;
									output += '</div>';
								}

								// Output to DOM
								$("#ce-courses").html( output ).slideDown();
							}).error(function(error){
								console.log('Error calling REST API: ' );
								console.log(error.responseText);
								$('#ce-header, #ce-overlay').remove();
							});
						});
					</script>
					<noscript>
						JavaScript is required to view courses. Please enable JavaScript in your browser.
					</noscript>
						<?php
						// Set variables.
						$campusce_base_url = 'https://www.campusce.net/BC/course/course.aspx?C=';
						$field_id          = CE_Plugin_Settings::get_ce_field_id();
						$category_id       = get_post_meta( get_the_ID(), $field_id, true );
						// Check if category_id is properly defined (four digit number).
						if ( preg_match( '/^(\d{4})/', $category_id ) ) :
							// Only load courses if category_id is defined.
							$courses  = CE_Custom_Functions::cecf_get_courses_by_category_id( $category_id );
							$category = CE_Custom_Functions::cecf_get_category_by_id( $category_id );
							// Courses loaded to be replaced by the REST API.
							?>
						<section id="ce-header">
							<h2><img src="/wp-includes/images/spinner.gif" alt="" /> &nbsp;Updating Classes...</h2>
						</section>
						<section id="ce-courses">
							<?php
							if ( ! empty( $courses ) ) :
								$parent_ID = $category->ParentID;
								?>
								<div id="ce-overlay"></div>
								<h2>Current <?php the_title(); ?> Classes</h2>
								<ul class="list-group">
									<?php foreach ( $courses as $class ) { ?>
										<?php
										if ( empty( $class->CourseID ) == false ) {
											// Load title and desc in to variables, and force tags to be balanced.
											$class_title = balanceTags( $class->Title, true );
											$class_desc  = balanceTags( wp_trim_words( $class->WebDescr, 40, '...' ), true );
											?>
											<?php $campusce_url = $campusce_base_url . $class->CourseID . '&mc=' . $class->CategoryID . '&pc=' . $parent_ID; ?>
											<li class="list-group-item">
												<h3><a href="<?php echo $campusce_url; ?>"><?php echo $class_title; ?></a></h3>
												<p><?php echo $class_desc; ?> <a class="btn btn-outline-primary btn-sm" href="<?php echo $campusce_url; ?>">More <span class="sr-only"> about <?php echo $class_title; ?></span> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
											</li>
										<?php } ?>
									<?php } ?>
								</ul>
							<?php else : // No available courses. ?>
								<br>
								<div class="card">
									<div class="card-body bg-light">
										<p class="card-text">Courses have begun. Please check back for future offerings.</p>
										<p class="card-text">Also, check out our <a href="https://www.campusce.net/BC/category/category.aspx">online catalog</a> for other offerings.</p>
									</div>
								</div>
							<?php endif; ?>
						</section>

							<?php
							else : // if field id is not available.
								echo '<!-- Category ID is not defined, or does not match proper pattern -->';
							endif;
							?>


					<?php else : ?>
					<!-- Classes can not be retrieved. Class category code provided is in the wrong format, or is missing.-->
				<?php endif; ?>
				<?php endif; ?>
				<?php
			else :
				echo '<p>Error: Custom Functionality Plugin not active</p>';
			endif;
			?>
	</main>
		<?php
endwhile;
	wp_reset_postdata();
endif;
