<?php

	/*

		Plugin Name: Broadcast MU
		Version: 2.0
		
		Author: Tom Lynch
		Author URI: http://tomlynch.co.uk
		
		Description: Adds the ability to broadcast from one WordPress blog to another on the same Network installation.
		
		Network: True
		
		License: GPLv3
		
		Copyright (C) 2012 Tom Lynch

	    This program is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program.  If not, see <http://www.gnu.org/licenses/>.
		
	*/
	
	class Broadcast {
	
		// Register actions and filters on class instanation
		function __construct() {
			// Add metabox action
			add_action( 'add_meta_boxes', array( &$this, 'register_metabox' ) );
			
			// Add save post action
			add_action( 'save_post', array( &$this, 'broadcast_post' ) );
		}
		
		// Broadcast the post
		function broadcast_post( $post_id ) {
		
			// Check that I am only broadcasting once
			if ( did_action( 'save_post' ) == 1 ) {
				
				// Retrieve the post
				$post = get_post( $post_id, 'ARRAY_A' );
				
				// If user is publishing a post
				if ( $post['post_status'] == 'publish' && $post['post_type'] == 'post' ) {
				
					// And user did want to multicase
					if ( ! empty( $_POST['blogs'] ) ) {
						
						// List of data to keep in broadcasted posts
						$post_data = array( 
										'post_author',
										'post_date',
										'post_date_gmt',
										'post_content',
										'post_title',
										'post_excerpt',
										'post_status',
										'comment_status',
										'ping_status',
										'post_password',
										'post_name',
										'post_modified',
										'post_modified_gmt',
										'post_type'
									);
						
						// Create a new post array
						foreach ( $post_data as $key )
							$new_post[$key] = $post[$key];
						
						// Retrieve the post format
						$format = get_post_format( $post_id );
						
						// Retrieve the post tags
						$tags = wp_get_post_tags( $post_id );
						
						// Create a list of tags
						if ( ! empty( $tags ) )
							foreach ( $tags as $tag )
								$new_tags[] = $tag->name;
								
						// Retrieve the post categories
						$categories = wp_get_post_categories( $post_id );
						
						// Create a list of categories
						if ( ! empty( $categories ) )
							foreach ( $categories as $category ) {
								$cat = get_category( $category, 'ARRAY_A' );
								$new_categories[ $cat['slug'] ] = $cat['name'];	
							}
						
						// Go through each blog
						foreach ( $_POST['blogs'] as $blog_id => $value ) {
						
							// Check this blog isn't the current blog
							if ( ! $blog_id != get_current_blog_id() ) {
								
								// Ensure it was checked
								if ( $value == 'on' ) {
								
									// Switch WordPress to that blog
									if ( switch_to_blog( $blog_id, true ) ) {
									
										// Check the current user can publish_posts
										if ( current_user_can( 'publish_posts' ) ) {
											
											// Insert the post
											$post_id = wp_insert_post( $new_post );
											
											// Set post format
											set_post_format( $post_id, $format );
											
											// Set post tags											
											if ( ! empty( $new_tags ) )
												wp_set_post_tags( $post_id, $new_tags );
											
											// Create categories
											foreach ( $new_categories as $ $slug => $name )
												if ( is_category( $slug ) ) {
													$cat = get_object_vars( get_category_by_slug( $slug ) );
													$new_cats[] = $cat->cat_ID;
												} else {
													$new_cats[] = intval( wp_create_category( $name ) );
												}
											
											// Set Categories
											if ( ! empty( $new_cats ))
												wp_set_post_categories( $post_id, $new_cats );
											
										}
										
										// Restore back to the current blog, or die
										if ( ! restore_current_blog() )
											wp_die( "Unable to switch back to current blog." );
									}
								}
							}
						}
					}
				}
			}
		}
		
		// Get list of blogs that specified user can peform specified capability on
		function get_blogs_of_user( $user_id, $capability ) {
			
			// Get all blogs of user
			$blogs = get_blogs_of_user( $user_id );
			
			// Make sure at least one blog was returned
			if ( ! empty( $blogs ) ) {
				
				// Go through each blog
				foreach ( $blogs as $blog_id => $data ) {
				
					// Switch WordPress to that blog
					if ( switch_to_blog( $blog_id, true ) ) {
					
						// Check user can perform capability
						if ( user_can( $user_id, $capability ) )
							$validated_blogs[$blog_id] = $data;
							
						// Restore back to the current blog, or die
						if ( ! restore_current_blog() )
							wp_die( "Unable to switch back to current blog." );
					}
				}
			}
			
			// Return the validated blogs list
			return $validated_blogs;
		}
		
		// Register metabox
		function register_metabox() {
			if ( $_REQUEST['action'] != 'edit' )
				add_meta_box( 'broadcast', 'Broadcast', array( &$this, 'output_metabox' ), 'post', 'side', 'default', null );
		}
		
		// Output metabox HTML
		function output_metabox() {
			$blogs = $this->get_blogs_of_user( get_current_user_id(), 'publish_posts' );
			?>
				<small>Post to:</small>
				<?php if ( ! empty( $blogs ) ): ?>
					<ul>
						<?php foreach ( $blogs as $blog ): ?>
							<li>
								<input type="checkbox" <?php checked( $blog->userblog_id, get_current_blog_id() ) ?> <?php disabled( $blog->userblog_id, get_current_blog_id() ) ?> name="blogs[<?php echo $blog->userblog_id ?>]" id="blog_<?php echo $blog->userblog_id ?>" />
								<label for="blog_<?php echo $blog->userblog_id ?>"><?php echo $blog->blogname ?></label>
							</li>						
						<?php endforeach ?>
					</ul>
				<?php else: ?>
					<p>There are no other blogs.</p>
				<?php endif ?>
			<?php
		}
	}
	
	// Instanate Broadcast class	
	$Broadcast = new Broadcast();
	
?>