<?php get_header(); ?>
<main>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article>
                <h2><?php the_title(); ?></h2>

                <div>
                    <div>
                        <h1>This is Single page</h1>
                        <p>Test From Single</p>
                    </div>
                    <?php the_content(); ?>
                </div>
            </article>
    <?php
        endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>