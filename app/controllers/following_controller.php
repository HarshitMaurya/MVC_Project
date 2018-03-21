<?php
namespace Controller;

session_start();

class FollowingController {
	public function get() {
		$followees = \Model\FollowModel::findFollowersOrFollowees($_SESSION['userID'], false);
		$links = array();
		foreach ($followees as $value) {
			$links = array_merge($links, \Model\LinkModel::findByUser($value['followedID']));
		}
		$links = \Model\LinkModel::fetchAllProperties($links, $_SESSION['userID']);
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		echo \View\Loader::make()->render('templates/home.twig',
			array('links' => $links, 'loggedIn' => $user)
		);

	}

}
