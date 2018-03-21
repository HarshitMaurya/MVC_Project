<?php

namespace Controller;

session_start();

class TagController {
	public function get($slug) {
		$tagged = \Model\TagsModel::linksByTag($slug);
		$linksAll = array();
		for ($i = 0; $i < sizeof($tagged); $i += 1) {
			array_push($linksAll, \Model\LinkModel::find($tagged[$i]['linkID']));
		}
		$links = \Model\LinkModel::fetchAllProperties($linksAll, $_SESSION['userID']);
		$user = \Model\UserModel::findByID($_SESSION['userID']);
		echo \View\Loader::make()->render('templates/tag.twig',
			array('links' => $links, 'loggedIn' => $user, 'tag' => $slug)
		);
	}
}
