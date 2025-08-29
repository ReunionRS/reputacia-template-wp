<?php
// archive-project.php - архив проектов
get_header(); ?>

<div class="container" style="padding: 80px 20px;">
    <h1>Наши проекты</h1>
    
    <div class="projects-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="project-card">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
                    </a>
                <?php endif; ?>
                <div class="project-card-body">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
    
    <?php the_posts_pagination(); ?>
</div>

<?php get_footer(); ?>