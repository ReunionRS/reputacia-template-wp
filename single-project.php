<?php
// single-project.php - шаблон для отдельного проекта
get_header(); ?>

<div class="container" style="padding: 80px 20px;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            
            <?php if (has_post_thumbnail()) : ?>
                <div style="margin: 20px 0;">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            
            <div class="content">
                <?php the_content(); ?>
            </div>
            
            <?php 
            $area = get_post_meta(get_the_ID(), '_project_area', true);
            $price = get_post_meta(get_the_ID(), '_project_price', true);
            $features = get_post_meta(get_the_ID(), '_project_features', true);
            
            if ($area || $price || $features) :
            ?>
            <div class="project-details" style="background: var(--bg-soft); padding: 30px; border-radius: 20px; margin: 40px 0;">
                <h3>Характеристики проекта</h3>
                <?php if ($area) : ?>
                    <p><strong>Площадь:</strong> <?php echo $area; ?> м²</p>
                <?php endif; ?>
                <?php if ($price) : ?>
                    <p><strong>Цена:</strong> от <?php echo number_format($price, 0, '', ' '); ?> ₽</p>
                <?php endif; ?>
                <?php if ($features) : ?>
                    <p><strong>Особенности:</strong> <?php echo $features; ?></p>
                <?php endif; ?>
                
                <button class="cta" data-open="callback" style="margin-top: 20px;">Заказать консультацию</button>
            </div>
            <?php endif; ?>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>






