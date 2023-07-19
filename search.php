<?php get_header(); ?>
    <div class="container">
        <div class="search-page post-entry<?php echo get_search_query() ? '' : ' search-empty'; ?>">
            <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="search-input">
                    <input class="form-control" type="text" value="<?php echo esc_html( get_search_query() ); ?>" name="s" id="s" placeholder="Ваш запрос" />
                    <button class="btn btn-primary" type="submit" id="searchsubmit">Найти</button>
                </div>
            </form>

            <?php
                if (get_search_query()) :
                    get_template_part( 'templates/loop', 'search' );
                endif;
            ?>
        </div>
    </div>
<?php get_footer(); ?>