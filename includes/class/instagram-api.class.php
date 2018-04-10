<?php 
require_once( BG_LIB_PATH . 'instagram-api/instagram.php' );
use MetzWeb\Instagram\Instagram;

require_once( BG_LIB_PATH . 'instagram-api/InstagramException.php' );
use MetzWeb\Instagram\InstagramException;

/**
 * Instagram API class
 *
 * API Documentation: http://instagram.com/developer/
 * Library: https://github.com/cosenary/Instagram-PHP-API
 *
 * @author Bears
 * @since 19.03.2018
 * @version 1.0.1
 */

if (!class_exists('InstagramAPI')) {
	
	class InstagramAPI {
		
		public function __construct() {
			$this->instagram = $this->config();
		}
		
		public function config() {
			$return_url = home_url('/');
			
			$instagram = new Instagram(array(
				'apiKey'      => '91b291275e75454ea8cbdd770d0c28c4',
				'apiSecret'   => 'ae37065add224b9c862730f3bc146a60',
				'apiCallback' => 'http://instagram-auth.bearssilver.com/?return_url=' . $return_url
			));
			/* $instagram = new Instagram(array(
				'apiKey'      => 'bb01543c554a4f95bb919a05b847b5bc',
				'apiSecret'   => 'ddbf41564a8347edb7e113d5de5bd5b3',
				'apiCallback' => 'http://instagram-auth.bearssilver.com/?return_url=' . $return_url
			)); */
			
			return $instagram;
		}
		
		public function getLoginUrl($scopes = array('basic')) {
			$login_url = $this->instagram->getLoginUrl($scopes);
			
			return $login_url;
		}
		
		public function getUser($token) {
			$this->instagram->setAccessToken($token);
			$data = $this->instagram->getUser();
			
			return $user_data = $data->data;
		}
		
		public function getUserID($token) {
			$data = $this->getUser($token);
			
			return $userID = $data->id;
		}
		
		public function getUserMedia($token, $limit = 0) {
			$id = $this->getUserID($token);
			$data = $this->instagram->getUserMedia($id, $limit);
			
			return $feed_data = $data;
		}
		
		public function getMediaComments($token, $id) {
			$data = file_get_contents('https://api.instagram.com/v1/media/'. $id .'/comments?access_token='.$token);
			
			return $comments_data = json_decode($data)->data; 
		}
		
		/* public function getMedia($token, $id) {
			$this->instagram->setAccessToken($token);
			$data = $this->instagram->getMedia($id);
			
			return $feed_data = $data;
		} */
		
		public function pagination($token, $obj, $limit = 0) {
			$this->instagram->setAccessToken($token);
			$data = $this->instagram->pagination($obj, $limit);
			
			return $results = $data;
		}
		
	}
}