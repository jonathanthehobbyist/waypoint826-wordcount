<?php
/**
 * Plugin Name: Wordcount
 * Description: Adds a post's wordcount to the 'All Posts' page in the Wordpress admin
 * Author: Jon Simmons
 * Version: 1.0.1
 */

	// Add new column to the posts list
	function add_word_count_column($columns) {
		// Save original title column
	    $title = $columns['title'];
	    unset($columns['title']);

	    // Rebuild the columns in your desired order
	    $new_columns = [];
	    $new_columns['title'] = $title; // Title first
	    $new_columns['word_count'] = 'Word Count'; // Then word count

	    // Add the rest of the original columns
	    foreach ($columns as $key => $value) {
	        $new_columns[$key] = $value;
	    }

	    return $new_columns;
		}

		add_filter('manage_posts_columns', 'add_word_count_column');

		// Populate the column with data
		function display_word_count_column($column, $post_id) {
		if ($column === 'word_count') {
		$content = get_post_field('post_content', $post_id);
		$word_count = str_word_count(strip_tags($content));
		echo $word_count;
		}
	}
	add_action('manage_posts_custom_column', 'display_word_count_column', 10, 2);

	function custom_word_count_column_style() {
	    echo '<style>
	        .column-word_count {
	            min-width: 100px;
	            text-align: left;
	        }

	        .column-title {
	        	min-width: 300px;
	            width: 30%;
	            text-align: left;
	        }

	        #wpfooter {
            	position: fixed !important;
            	bottom: 0;
            	left: 0;
            	width: 100%;
            	z-index: 999;
            	background: #fff;
            	border-top: 1px solid #ccc;
            	padding: 10px;
        	}
        body {
            padding-bottom: 60px; /* Make space for fixed footer */
        }
	    </style>';
	}
	add_action('admin_head', 'custom_word_count_column_style');

?>