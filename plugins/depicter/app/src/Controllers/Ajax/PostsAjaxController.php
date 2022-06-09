<?php
namespace Depicter\Controllers\Ajax;

use Averta\WordPress\Utility\Sanitize;
use Psr\Http\Message\ResponseInterface;
use WPEmerge\Requests\RequestInterface;

class PostsAjaxController
{
	/**
	 * list available post types with their taxonomies
	 * @param RequestInterface $request
	 * @param                  $view
	 *
	 * @return ResponseInterface
	 */
    public function getPostTypes( RequestInterface $request, $view ) {
	    $postType = !empty( $request->query('postType') ) ? Sanitize::textfield( $request->query('postType') ) : 'all';
    	$result = \Depicter::postsService()->getPostTypes( $postType );

		return \Depicter::json([
			'hits' => $result
		])->withStatus(200);
    }

	/**
	 * List available posts for custom post type
	 * @param RequestInterface $request
	 * @param                  $view
	 *
	 * @return ResponseInterface
	 */
    public function getPosts( RequestInterface $request, $view ) {
    	$args = [
    		'postType' => !empty( $request->query('postType') ) ? Sanitize::textfield( $request->query('postType') ) : 'post',
		    'perpage' => !empty( $request->query('perpage') ) ? Sanitize::int( $request->query('perpage') ) : 40,
		    'excerptLength' => !empty( $request->query('excerptLength') ) ? Sanitize::int( $request->query('excerptLength') ) : '',
		    'offset' => !empty( $request->query('offset') ) ? Sanitize::int( $request->query('offset') ) : '',
		    'linkSlides' => !empty( $request->query('linkSlides') ) ? Sanitize::int( $request->query('linkSlides') ) : '',
		    'orderBy' => !empty( $request->query('orderBy') ) ? Sanitize::textfield( $request->query('orderBy') ) : 'date',
		    'order' => !empty( $request->query('order') ) ? Sanitize::textfield( $request->query('order') ) : 'DESC',
		    'imageSource' => !empty( $request->query('imageSource') ) ? Sanitize::textfield( $request->query('imageSource') ) : '',
		    'excludeIds' => !empty( $request->query('excludeIds') ) ? $request->query('excludeIds') : '',
		    'includeIds' => !empty( $request->query('includeIds') ) ? $request->query('includeIds') : '',
		    'excludeNonThumbnail' => !empty( $request->query('excludeNonThumbnail') ) ? $request->query('excludeNonThumbnail') : '',
		    'categories' => !empty( $request->query('categories') ) ? $request->query('categories') : '',
		    'tags' => !empty( $request->query('tags') ) ? $request->query('tags') : '',
	    ];

		$posts = \Depicter::postsService()->getPosts( $args );

	    return \Depicter::json([
	    	'hits' => $posts
	    ])->withStatus(200);
    }
}
