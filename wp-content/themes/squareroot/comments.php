<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Squareroot
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<!-- <h2 class="comments-title">
			<?php
		printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'squareroot' ),
			number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?>
		</h2> -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'squareroot' ); ?></h1>

				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'squareroot' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'squareroot' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>


		<ul id="comments">
			<?php wp_list_comments( 'style=li&&type=comment&callback=squareroot_comment' ); ?> <!-- .comment-list -->
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'squareroot' ); ?></h1>

				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'squareroot' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'squareroot' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'squareroot' ); ?></p>
	<?php endif; ?>


	<?php
	$comments_args = array(
		// change the title of send button
		'label_submit'         => 'POST COMMENT',
		'id_submit'            => 'btnComment',
		// change the title of the reply section
		'title_reply'          => 'Leave a Comment',
		// remove "Text or HTML to be displayed after the set of comment fields"
		'comment_notes_after'  => '',
		'comment_notes_before' => '<p class="comment-notes">' .
		                          __( 'Your email address will not be published.', 'squareroot' ) /* . ( $req ? $required_text : '' ) */ .
		                          '</p>',
		'fields'               => apply_filters( 'comment_form_default_fields', array(
				'author' =>
					'<div class="col-sm-6">
					<input id="author" name="author" type="text" class="txt" value="" size="30" placeholder="NAME" /></div>',
				'email'  =>
					'<div class="col-sm-6">
					 <input id="email" name="email" type="text" class="txt" value="" size="30" placeholder="EMAIL" /></div>',
				'url'    =>
					'<div class="col-sm-12">
					<input id="url" name="url" type="text" class="txt" value="" size="30" placeholder="WEBSITE" /></div>'
			)
		),
		'comment_field'        => '<div class="col-sm-12"><p class="comment-form-comment"><label>' . __( " MESSAGE", "squareroot" ) . '</label><textarea id="comment" class="text_area" name="comment" aria-required="true"></textarea></p></div>',
	);
	?>

	<div class="comment_form"><?php comment_form( $comments_args ); ?></div>

</div><!-- #comments -->
