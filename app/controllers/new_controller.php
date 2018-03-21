<?php

namespace Controller;

session_start();

class NewLinksController {
	public function get() {
		$linksAll = \Model\LinkModel::new ();
		$links = \Model\LinkModel::fetchAllProperties($linksAll, $_SESSION['userID']);
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		echo \View\Loader::make()->render('templates/new.twig',
			array('links' => $links, 'loggedIn' => $user)
		);
	}
}
