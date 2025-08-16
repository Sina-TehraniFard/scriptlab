<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ScriptLab
 */

get_header();
?>

	<!-- Tailwind CSS テストセクション -->
	<div style="background: linear-gradient(to right, #8b5cf6, #ec4899); color: white; padding: 3rem 0; margin-bottom: 2rem;">
		<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
			<h2 style="font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 1rem;">🎨 Tailwind CSS 導入完了!</h2>
			<p style="font-size: 1.25rem; text-align: center; margin-bottom: 2rem;">このセクションはTailwind CSSでスタイリングされています</p>
			
			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; max-width: 64rem; margin: 0 auto;">
				<!-- カード1 -->
				<div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); border-radius: 0.5rem; padding: 1.5rem; transition: all 0.3s;" 
					 onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='scale(1.05)'" 
					 onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.transform='scale(1)'">
					<div style="font-size: 2rem; margin-bottom: 0.75rem;">⚡</div>
					<h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">高速開発</h3>
					<p style="font-size: 0.875rem;">ユーティリティファーストで素早くデザイン</p>
				</div>
				
				<!-- カード2 -->
				<div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); border-radius: 0.5rem; padding: 1.5rem; transition: all 0.3s;" 
					 onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='scale(1.05)'" 
					 onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.transform='scale(1)'">
					<div style="font-size: 2rem; margin-bottom: 0.75rem;">🎯</div>
					<h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">一貫性</h3>
					<p style="font-size: 0.875rem;">統一されたデザインシステム</p>
				</div>
				
				<!-- カード3 -->
				<div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); border-radius: 0.5rem; padding: 1.5rem; transition: all 0.3s;" 
					 onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='scale(1.05)'" 
					 onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.transform='scale(1)'">
					<div style="font-size: 2rem; margin-bottom: 0.75rem;">📱</div>
					<h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">レスポンシブ</h3>
					<p style="font-size: 0.875rem;">モバイルファーストで構築</p>
				</div>
			</div>
			
			<div style="text-align: center; margin-top: 2rem;">
				<button style="background: white; color: #8b5cf6; padding: 0.75rem 2rem; border-radius: 9999px; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: background 0.3s;"
						onmouseover="this.style.background='#f3f4f6'"
						onmouseout="this.style.background='white'">
					詳細を見る
				</button>
			</div>
		</div>
	</div>
	
	<!-- Tailwindクラステストエリア（ヘッダー変更） -->

	<main id="primary" class="site-main container mx-auto px-4">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();