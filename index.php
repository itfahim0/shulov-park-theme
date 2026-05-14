<?php
/**
 * The main template file
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
		<?php
		if ( have_posts() ) :

			while ( have_posts() ) :
				the_post();

				echo '<article id="post-' . get_the_ID() . '" ' . get_post_class() . '>';
                echo '<header class="entry-header">';
                the_title( '<h1 class="entry-title">', '</h1>' );
                echo '</header>';
                echo '<div class="entry-content">';
                the_content();
                echo '</div>';
                echo '</article>';

			endwhile;

			the_posts_navigation();

		else :

			echo '<p>No content found.</p>';

		endif;
		?>
		</div>
	</main><!-- #main -->

<?php
get_footer();
