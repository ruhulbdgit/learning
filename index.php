<button onclick="myFunction()">Try it</button>
<?php get_header(); ?>
<main>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </article>
    <?php
        endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>
    <?php get_sidebar(); ?>
</main>


<?php get_footer(); ?>