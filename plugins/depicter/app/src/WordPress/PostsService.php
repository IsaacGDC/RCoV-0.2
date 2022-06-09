<?php
namespace Depicter\WordPress;

class PostsService
{

	/**
	 * Get All Post Types info
	 * @return array
	 */
    public function getPostTypes( $postType = 'all' ) {
    	if ( $postType == 'all' ) {
		    $availablePostType = array(
			    'post' => get_post_type_object('post'),
			    'page' => get_post_type_object('page')
		    );
		    $postTypes = get_post_types(
			    array(
				    'public'    => true,
				    '_builtin'  => false
			    ),
			    'objects'
		    );

		    $postTypes = array_merge( $availablePostType, $postTypes );
	    } else {
		    if ( !post_type_exists( $postType ) ) {
			    return [];
		    }
    		$postTypes = [ $postType => get_post_type_object( $postType ) ];
	    }

        $result = [];
        foreach( $postTypes as $id => $providedPostType ) {

	        $postTypeInfo = [
		        'id' => $id,
		        'label' => $providedPostType->label
	        ];

	        $taxonomies = get_object_taxonomies( $id );
	        foreach( $taxonomies as $taxonomy ) {
	        	$terms = get_terms([
	        		'taxonomy' => $taxonomy,
			        'hide_empty' => true
		        ]);
	        	$postTypeInfo[ $taxonomy ] = [];
	        	if ( !empty( $terms ) ) {
	        		foreach( $terms as $term ) {
	        			$postTypeInfo[ $taxonomy ][] = [
	        				'id' => $term->term_id,
					        'value' => $term->slug,
					        'label' => $term->name
				        ];
			        }
		        }
	        }

	        $result[] = $postTypeInfo;
        }

        return $result;
    }

	/**
	 * Lists available posts for provided post type
	 *
	 * @param string $postType
	 *
	 * @return array
	 */
    public function getPosts( $args ) {
    	$queryArgs = [
		    'post_type' => $args['postType'],
		    'numberposts'  => $args['perpage'],
		    'order' => $args['order'],
		    'orderBy' => $args['orderBy'],
		    'offset' => $args['offset'],
		    'include' => $args['includeIds'],
		    'exclude' => $args['excludeIds'],
		    'tax_query' => []
	    ];

    	if ( !empty( $args['categories'] ) ) {
		    $queryArgs['tax_query'][] = [
		    	'taxonomy' => 'category',
			    'field' => 'slug',
			    'terms' => $args['categories']
		    ];
	    }

	    if ( !empty( $args['tags'] ) ) {
	    	$queryArgs['tax_query'][] = [
	    		'taxonomy' => 'post_tag',
			    'field' => 'slug',
			    'terms' => $args['tags']
		    ];
	    }

	    if ( !empty( $args['excerptLength'] ) ) {
	    	add_filter( 'excerpt_length', function () use ($args) {
	    		return $args['excerptLength'];
		    } );
	    }

		$availablePosts = get_posts( $queryArgs );

		$posts = [];
		if ( !empty( $availablePosts ) ) {
			$taxonomies = get_object_taxonomies( $args['postType'] );
			foreach( $availablePosts as $post ) {
				if ( !empty( $args['excludeNonThumbnail'] ) && !has_post_thumbnail( $post->ID ) ) {
					continue;
				}
				$postInfo = [
					'id' => $post->ID,
					'title' => $post->post_title,
					'url' => get_permalink( $post->ID ),
					'featuredImage' => has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] : '',
					'date' => $post->post_date,
					'excerpt' => get_the_excerpt( $post->ID ),
					'author' => [
						'name' => get_the_author_meta( 'display_name', $post->post_author ),
						'page' => get_author_posts_url( $post->post_author ),
					],
					'content' => $post->post_content
				];

				if ( !empty( $taxonomies ) ) {
					foreach( $taxonomies as $taxonomy ) {
						$postInfo[ $taxonomy ] = [];
						$terms = wp_get_post_terms( $post->ID, $taxonomy );
						if ( !empty( $terms ) ) {
							foreach( $terms as $term ) {
								$postInfo[ $taxonomy ][] = [
									'link' => get_term_link( $term->term_id ),
									'label' => $term->name
								];
							}
						}
					}
				}
				$posts[] = $postInfo;
			}
		}

		return $posts;
    }
}
