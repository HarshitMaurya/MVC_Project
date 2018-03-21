<?php

namespace Controller;

session_start();

class CommentUpvoteController {

	function post() {
		$commentID = $_POST['upvote-button'];
		$loggedInUser = $_SESSION['userID'];
		\Model\CommentUpvoteModel::upvoteToggle($commentID, $loggedInUser);
		echo "<script>window.history.back();</script>";
	}
}