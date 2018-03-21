<?php

namespace Controller;

session_start();

class FollowController {

	function post() {
		$followed = $_POST['follow-button'];
		$loggedInUser = $_SESSION['userID'];
		\Model\FollowModel::followToggle($followed, $loggedInUser);
		echo "<script>window.history.back();</script>";
	}

}