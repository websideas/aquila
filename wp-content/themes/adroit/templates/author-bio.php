<?php
/**
 * The template for displaying Author bios
 *
 */
?>

<div class="author-info">
    <div class="author-avatar">
        <?php
        $author_bio_avatar_size = apply_filters( 'kt_author_bio_avatar_size', 120 );
        echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
        ?>
    </div><!-- .author-avatar -->
    <div class="author-description">
        <h2 class="author-title">
            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr(sprintf( esc_html__( 'View all posts by %s', 'adroit' ), get_the_author() ) ); ?>">
                <?php printf( esc_html__( 'About %s', 'adroit' ), get_the_author() ); ?>
            </a>
        </h2>

        <?php
        if($description = get_the_author_meta('description')){
            printf('<div class="author-bio">%s</div>', $description);
        }

        $googleplus = get_the_author_meta('googleplus');
        $url = get_the_author_meta('url');
        $twitter = get_the_author_meta('twitter');
        $facebook = get_the_author_meta('facebook');
        $pinterest = get_the_author_meta('pinterest');
        $instagram = get_the_author_meta('instagram');
        $tumblr = get_the_author_meta('tumblr');
        ?>
        <?php if($facebook || $twitter || $pinterest || $googleplus || $instagram || $tumblr || $url){ ?>
            <p class="author-social">
                <?php if($facebook){ ?>
                    <a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                <?php } ?>
                <?php if($twitter){ ?>
                    <a href="http://www.twitter.com/<?php echo esc_attr($twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                <?php } ?>
                <?php if($pinterest){ ?>
                    <a href="http://www.pinterest.com/<?php echo esc_attr($pinterest); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                <?php } ?>
                <?php if($googleplus){ ?>
                    <a href="<?php echo esc_url($googleplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                <?php } ?>
                <?php if($instagram){ ?>
                    <a href="http://instagram.com/<?php echo esc_attr($instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                <?php } ?>
                <?php if($tumblr){ ?>
                    <a href="http://<?php echo esc_attr($tumblr); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a>
                <?php } ?>
                <?php if($url){ ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank"><i class="fa fa-globe"></i></a>
                <?php } ?>
            </p>
        <?php } ?>

    </div><!-- .author-description -->
</div><!-- .author-info -->