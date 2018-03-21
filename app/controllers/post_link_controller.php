<?php

namespace Controller;

session_start();

class PostLinkController {
	public function get() {
		if (isset($_SESSION['userID'])) {
			$user = \Model\UserModel::findByID($_SESSION['userID']);
			echo \View\Loader::make()->render('templates/post_link.twig',
				array('loggedIn' => $user));
		} else {
			header("Location:/login");
		}
	}

	public function post() {
		if (isset($_POST['submit-link-button'])) {

			$title = $_POST['title'];
			$content = $_POST['content'];
			$userID = $_SESSION['userID'];

			$linkID = \Model\LinkModel::insert($title, $content, $userID);
			if (strlen($_POST['tag1'])) {
				\Model\TagsModel::tag($linkID, $_POST['tag1']);
			}
			if (strlen($_POST['tag2']) && $_POST['tag2'] != $_POST['tag1']) {
				\Model\TagsModel::tag($linkID, $_POST['tag2']);
			}
			if (strlen($_POST['tag3']) && $_POST['tag3'] != $_POST['tag1'] && $_POST['tag3'] != $_POST['tag2']) {
				\Model\TagsModel::tag($linkID, $_POST['tag3']);
			}
			header("Location:/");

		}

	}
}
