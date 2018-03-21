<?php
namespace Model;

class LinkUpvoteModel {

	public static function upvoteToggle($linkID, $userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM linkUpvotes WHERE linkID = $linkID AND userID = $userID");
		$stmt->execute();
		$row = $stmt->fetch();
		if (!$row) {
			$stmt = $db->prepare("INSERT INTO linkUpvotes VALUES (?, ?, ?)");
			$stmt->execute([null, $linkID, $userID]);

			$stmt = $db->prepare("UPDATE links SET upvotes = upvotes+1 WHERE id = ?");
			$stmt->execute([$linkID]);
		} else {
			$stmt = $db->prepare("DELETE FROM linkUpvotes WHERE linkID = $linkID AND userID = $userID");
			$stmt->execute([null, $linkID, $userID]);

			$stmt = $db->prepare("UPDATE links SET upvotes = upvotes-1 WHERE id = ?");
			$stmt->execute([$linkID]);
		}
		$stmt = null;
	}

	public static function upvotesByLink($linkID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM linkUpvotes WHERE linkID = ?");
		$stmt->execute([$linkID]);
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public static function upvotesByUser($userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM linkUpvotes WHERE userID = ?");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function isUpvoted($linkID, $userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM linkUpvotes WHERE linkID = ? AND userID = ?");
		$stmt->execute([$linkID, $userID]);
		$row = $stmt->fetch();
		return !empty($row);
	}

}
