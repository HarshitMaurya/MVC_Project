<?php
namespace Controller;

session_start();

class HomeController {
	public function get() {
		$linksAll = \Model\LinkModel::trending();
		$links = \Model\LinkModel::fetchAllProperties($linksAll, $_SESSION['userID']);
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		echo \View\Loader::make()->render('templates/home.twig',
			array('links' => $links, 'loggedIn' => $user)
		);

	}

}
