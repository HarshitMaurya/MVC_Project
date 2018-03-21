<?php
namespace Controller;

session_start();

class AllTimeHighController {
	public function get() {
		$linksAll = \Model\LinkModel::best();
		$links = \Model\LinkModel::fetchAllProperties($linksAll, $_SESSION['userID']);
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		echo \View\Loader::make()->render('templates/best.twig',
			array('links' => $links, 'loggedIn' => $user)
		);
	}

}
