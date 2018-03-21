<?php

namespace Controller;

session_start();

class LinkUpvoteController {

	function post() {
		$linkID = $_POST['upvote-button'];
		$loggedInUser = $_SESSION['userID'];
		\Model\LinkUpvoteModel::upvoteToggle($linkID, $loggedInUser);
		echo "<script>window.history.back();</script>";
	}
}