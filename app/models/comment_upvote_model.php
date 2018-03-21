<?php
namespace Model;

class CommentUpvoteModel {

	public static function upvoteToggle($commentID, $userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentUpvotes WHERE commentID = $commentID AND userID = $userID");
		$stmt->execute();
		$row = $stmt->fetch();
		if (!$row) {
			$stmt = $db->prepare("INSERT INTO commentUpvotes VALUES (?, ?)");
			$stmt->execute([$commentID, $userID]);

			$stmt = $db->prepare("UPDATE comments SET upvotes = upvotes+1 WHERE id = ?");
			$stmt->execute([$commentID]);
		} else {
			$stmt = $db->prepare("DELETE FROM commentUpvotes WHERE commentID = $commentID AND userID = $userID");
			$stmt->execute([null, $commentID, $userID]);

			$stmt = $db->prepare("UPDATE comments SET upvotes = upvotes-1 WHERE id = ?");
			$stmt->execute([$commentID]);
		}
		$stmt = null;
	}

	public static function isUpvoted($commentID, $userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentUpvotes WHERE commentID = ? AND userID = ?");
		$stmt->execute([$commentID, $userID]);
		$row = $stmt->fetch();
		return !empty($row);
	}

	public static function upvotesByUser($userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentUpvotes WHERE userID = ?");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function upvotesByComment($commentID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentUpvotes WHERE commentID = ?");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}
}
