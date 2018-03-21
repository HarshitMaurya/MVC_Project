<?php

namespace Controller;

session_start();

class LinkDiscussionController {
	function get($slug1, $slug2 = 'new') {
		if ($slug2 == "new") {
			$comments = \Model\CommentsModel::new ($slug1);
		} else if ($slug2 == "best") {
			$comments = \Model\CommentsModel::best($slug1);
		} else {
			$comments = \Model\CommentsModel::new ($slug1);
		}

		$linkTemp = \Model\LinkModel::find($slug1);
		//Array of single array
		$link = \Model\LinkModel::fetchAllProperties(array($linkTemp), $_SESSION['userID']);
		//Required Array
		$link = $link[0];
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		$comments = \Model\CommentsModel::fetchAllProperties($comments, $_SESSION['userID']);

		echo \View\Loader::make()->render('templates/link_discussion.twig',
			array('link' => $link, 'comments' => $comments, 'loggedIn' => $user));
	}

	function post($slug1) {
		$comment = $_POST['comment'];
		$commenter = $_SESSION['userID'];

		\Model\CommentsModel::insert($slug1, $comment, $commenter);
		header("Location:/link/" . $slug1);
	}
}