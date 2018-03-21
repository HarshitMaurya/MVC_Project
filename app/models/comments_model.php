<?php
namespace Model;

class CommentsModel {
	public static function new ($linkID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM comments WHERE linkID = ? ORDER BY id DESC");
		$stmt->execute([$linkID]);
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public static function best($linkID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM comments WHERE linkID = ? ORDER BY upvotes DESC, id DESC");
		$stmt->execute([$linkID]);
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public static function findByUser($userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM comments WHERE commenter = ?");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public static function find($commentID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM comments WHERE id = ?");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public static function insert($linkID, $comment, $commenter) {
		$upvotes = 0;
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO comments VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->execute([NULL, $linkID, $comment, $commenter, $upvotes, NULL]);
		$stmt = null;

		$stmt = $db->prepare("UPDATE links SET numberOfComments = numberOfComments+1 WHERE id = ?");
		$stmt->execute([$linkID]);
		$stmt = null;
	}

	public static function fetchAllProperties($comments, $loggedIn) {
		$db = \DB::get_instance();
		$extendedComments = array();
		for ($i = 0; $i < sizeof($comments); $i += 1) {
			array_push($extendedComments, $comments[$i]);
			$userInfo = \Model\UserModel::findByID($comments[$i]['commenter']);
			$isUpvoted = \Model\CommentUpvoteModel::isUpvoted($comments[$i]['id'], $loggedIn);
			$extendedComments[$i]['isUpvoted'] = $isUpvoted;
			array_push($extendedComments[$i], $isUpvoted);
			$extendedComments[$i]['username'] = $userInfo['username'];
			array_push($extendedComments[$i], $userInfo['username']);
		}
		return $extendedComments;
	}
}
