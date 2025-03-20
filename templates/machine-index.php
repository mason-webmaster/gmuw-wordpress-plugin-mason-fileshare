<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo get_bloginfo('name') ?>: Machine Index</title>
</head>

<body>

	<?php echo '<h1>' . get_bloginfo('name') . '</h1>'; ?>
	<h2>Machine Index</h2>
	
	<?php 

    //set up query arguments
    $get_posts_args = array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'post_parent'    => null,
        'order'          => 'ASC',
        'orderby'        => 'ID',
    );

    //get attachments
    $posts = get_posts($get_posts_args);

    //if we have posts
	if ($posts) {

		echo '<ul>';

		foreach ($posts as $post) {

			echo '<li>';

			//title/link
			echo '<a href="'.wp_get_attachment_url($post->ID).'" target="_blank">'.wp_get_attachment_url($post->ID).'</a> ('. $post->ID .')';

			echo '</li>';

		}

		echo '</ul>';

	}   	

	?>

</body>

</html>
