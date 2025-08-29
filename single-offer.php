<?php
// single-offer.php - шаблон для отдельного предложения
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
            $area = get_post_meta(get_the_ID(), '_offer_area', true);
            $price = get_post_meta(get_the_ID(), '_offer_price', true);
            $features = get_post_meta(get_the_ID(), '_offer_features', true);
            
            if ($area || $price || $features) :
            ?>
            <div class="offer-details" style="background: var(--bg-soft); padding: 30px; border-radius: 20px; margin: 40px 0;">
                <h3>Детали предложения</h3>
                <?php if ($area) : ?>
                    <p><strong>Площадь:</strong> <?php echo $area; ?> м²</p>
                <?php endif; ?>
                <?php if ($price) : ?>
                    <div class="price" style="font-size: 24px; color: var(--accent); font-weight: 800; margin: 10px 0;">
                        от <?php echo number_format($price, 0, '', ' '); ?> ₽
                    </div>
                <?php endif; ?>
                <?php if ($features) : ?>
                    <div class="features" style="margin: 20px 0;">
                        <?php 
                        $features_array = explode(',', $features);
                        foreach ($features_array as $feature) :
                        ?>
                        <span class="feature-tag"><?php echo trim($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <button class="cta" data-open="calculator" style="margin-top: 20px;">Рассчитать стоимость</button>
            </div>
            <?php endif; ?>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>