<?php
/*
Plugin Name: Oktopost Future Posts
Version: 1.1
Description: Allow Oktopost to access future posts 
Author: Liad Guez
Author URI: http://www.oktopost.com
*/

class Oktopost_Future_Posts {

	const EMBEDLY_AGENT		= 'Embedly';
	const IFRAMELY_AGENT	= 'Iframely';


	public static function allow_future_posts() {
		if (self::is_allowed()) {
			self::register_status();
		}
	}


	private static function is_allowed() {
		$userAgent = self::get_user_agent();

		return (strpos($userAgent, self::EMBEDLY_AGENT) !== false || 
				strpos($userAgent, self::IFRAMELY_AGENT) !== false) && is_single();
	}

	private static function get_user_agent() {
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}

	private static function register_status() {
		register_post_status('future', array(
			'label'       => _x('Scheduled', 'post'),
			'protected'   => false,
			'public' 	  => true,
			'_builtin'    => true,
			'label_count' => _n_noop(
				'Scheduled <span class="count">(%s)</span>', 
				'Scheduled <span class="count">(%s)</span>' 
			),
		));
	}
}

add_action('pre_get_posts', 'Oktopost_Future_Posts::allow_future_posts', 1);