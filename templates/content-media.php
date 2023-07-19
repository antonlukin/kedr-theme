<div class="post-header">
    <div class="container">
        <div class="post-entry">
            <div class="post-header_title">
                <?php the_title('<h1>', '</h1>'); ?>
                <?php the_excerpt(); ?>

                <div class="meta">
                    <?php echo get_the_date(); ?>
                    <span>•</span>
                    <?php get_template_part('templates/parts/author', 'block'); ?>
                </div>

                <div class="video-block mb-4">
                    <iframe width="100%" height="100%" src="<?php the_field( 'video_frame' ); ?>?controls=0"
                            title="YouTube video player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>

                <p>Подписывайтесь на наш
                    <a class="telegram-link" target="_blank" href="https://www.youtube.com/channel/UCMzDHFttTHKvnmxMr69hGMw">YouTube-канал</a> и
                    <a class="telegram-link" target="_blank" href="https://t.me/kedr_media">Telegram</a></p>
            </div>
        </div>
    </div>
</div>
<?php get_template_part('templates/content'); ?>
