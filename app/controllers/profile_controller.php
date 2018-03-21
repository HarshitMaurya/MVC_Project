<?php

namespace Controller;

session_start();

class ProfileController {
	public function get($slug) {
		$linksUser = \Model\LinkModel::findByUser($slug);
		$links = \Model\LinkModel::fetchAllProperties($linksUser, $_SESSION['userID']);

		$commentsUser = \Model\CommentsModel::findByUser($slug);
		$comments = \Model\LinkModel::fetchAllProperties($commentsUser, $_SESSION['userID']);

		$user = \Model\UserModel::findByID($slug);
		$loggedIn = \Model\UserModel::findByID($_SESSION['userID']);

		$linkUpvotes = $commentUpvotes = 0;
		foreach ($linksUser as $value) {
			$linkUpvotes += $value['upvotes'];
		}
		foreach ($commentsUser as $value) {
			$commentUpvotes += $value['upvotes'];
		}
		$karma = 10 * $linkUpvotes + $commentUpvotes;

		$followers = sizeof(\Model\FollowModel::findFollowersOrFollowees($slug, true));
		$followees = sizeof(\Model\FollowModel::findFollowersOrFollowees($slug, false));
		$followData = array('followers' => $followers, 'followees' => $followees);

		$isFollowed = \Model\FollowModel::isFollowed($slug, $_SESSION['userID']);

		echo \View\Loader::make()->render('templates/profile.twig',
			array(
				'links' => $links,
				'comments' => $comments,
				'user' => $user,
				'karma' => $karma,
				'isFollowed' => $isFollowed,
				'followData' => $followData,
				'loggedIn' => $loggedIn));
	}
}