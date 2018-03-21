<?php
namespace Model;

class FollowModel {

	public static function followToggle($followedID, $loggedIn) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM follow WHERE followerID = ? AND followedID = ?");
		$stmt->execute([$loggedIn, $followedID]);
		$row = $stmt->fetch();
		if (!$row) {
			$stmt = $db->prepare("INSERT INTO follow VALUES (?, ?)");
			$stmt->execute([$loggedIn, $followedID]);

		} else {
			$stmt = $db->prepare("DELETE FROM follow WHERE followerID = ? AND followedID = ?");
			$stmt->execute([$loggedIn, $followedID]);
		}
		$stmt = null;
	}

	public static function findFollowersOrFollowees($followID, $flag) {
		$db = \DB::get_instance();
		if ($flag) {
			$stmt = $db->prepare("SELECT * FROM follow WHERE followedID = ?");
		} else {
			$stmt = $db->prepare("SELECT * FROM follow WHERE followerID = ?");
		}
		$stmt->execute([$followID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function isFollowed($followedID, $loggedIn) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM follow WHERE followerID = ? AND followedID = ?");
		$stmt->execute([$loggedIn, $followedID]);
		$row = $stmt->fetch();
		return !empty($row);
	}

}
