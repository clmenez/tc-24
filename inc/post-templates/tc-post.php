<?php
/**
 * Template Name: TC Post Template
 * Template Post Type: post
 */

function tc_render_article_hero() {
    $share_url = urlencode(get_permalink());
    $share_title = urlencode(get_the_title());
    
    if (is_single() && get_post_type() === 'post') {
        ?>
        <div class="article-hero article-hero--image-and-text has-green-500-background-color wp-block-techcrunch-article-hero">
            <div class="article-hero__first-section">
                <?php if (has_post_thumbnail()) : ?>
                    <figure class="wp-block-post-featured-image">
                        <?php the_post_thumbnail('full', array('class' => 'attachment-post-thumbnail size-post-thumbnail wp-post-image', 'style' => 'object-fit:cover;')); ?>
                        <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                            <figcaption class="wp-block-post-featured-image__caption">
                                <strong>Image Credits:</strong> <?php echo wp_get_attachment_caption(get_post_thumbnail_id()); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </div>
            <div class="article-hero__second-section">
                <div inert role="presentation" class="article-hero__extension-2"></div>
                <div class="article-hero__content">
                    <div inert role="presentation" class="article-hero__extension"></div>
                    <div class="article-hero__top">
                        <div class="article-hero__category">
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                $category = $categories[0];
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="is-taxonomy-category wp-block-tenup-post-primary-term">';
                                echo esc_html($category->name);
                                echo '</a>';
                            }
                            ?>
                        </div>
                        <div class="article-hero__share">
                            <div class="is-horizontal wp-block-techcrunch-social-share">
                                <div class="wp-block-techcrunch-social-share__wrapper">
                                    <a class="wp-block-techcrunch-social-share__link" aria-label="Share on Facebook" href="https://www.facebook.com/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener">
                                        <svg width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z"/></svg>
                                    </a>
                                    <a class="wp-block-techcrunch-social-share__link" aria-label="Share on X" href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener">
                                        <svg width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M12.6.75l-2.1 2.1c2.4 3.2 2.1 7.7-.8 10.6-2.9 2.9-7.4 3.2-10.6.8l4.2-4.2c.7.3 1.5.3 2.1-.3.9-.9.9-2.3 0-3.2-.9-.9-2.3-.9-3.2 0-.6.6-.6 1.4-.3 2.1L.75 12.6C3.1 14.9 6.4 16 9.7 16c3.3 0 6.6-1.1 9-3.4 4.7-4.7 4.7-12.3 0-17l-2.1 2.1z"/></svg>
                                    </a>
                                    <a class="wp-block-techcrunch-social-share__link" aria-label="Share on LinkedIn" href="https://www.linkedin.com/shareArticle?url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>&mini=1" target="_blank" rel="noopener">
                                        <svg width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/></svg>
                                    </a>
                                    <a class="wp-block-techcrunch-social-share__link" aria-label="Share via Email" href="mailto:?subject=<?php echo $share_title; ?>&body=Article: <?php echo $share_url; ?>" target="_blank" rel="noopener">
                                        <svg width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="article-hero__middle">
                        <h1 class="article-hero__title wp-block-post-title"><?php the_title(); ?></h1>
                    </div>
                    <div class="article-hero__bottom">
                        <div class="article-hero__authors">
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php the_author(); ?>
                            </a>
                        </div>
                        <div class="article-hero__date">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo get_the_date('F j, Y'); ?>
                            </time>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

// Register the template
function register_tc_post_template() {
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = array(
        array('techcrunch/article-hero', array(
            'className' => 'article-hero article-hero--image-and-text has-green-500-background-color wp-block-techcrunch-article-hero',
            'layout' => array(
                'type' => 'default'
            )
        ))
    );
}
add_action('init', 'register_tc_post_template');

// Add theme support
function tc_post_template_setup() {
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'tc_post_template_setup');
?>