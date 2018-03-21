<?php
namespace Model;

class LinkModel {
	public static function all() {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links ORDER BY id desc");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function trending() {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links ORDER BY upvotes DESC, numberOfComments DESC, id DESC");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function new () {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links ORDER BY id desc");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function best() {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links ORDER BY upvotes desc, id DESC");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function find($linkID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links WHERE id = ?");
		$stmt->execute([$linkID]);
		$row = $stmt->fetch();
		return $row;
	}
	public static function findByUser($userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM links WHERE userID = ? ORDER BY id DESC");
		$stmt->execute([$userID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function insert($title, $content, $userID) {
		$db = \DB::get_instance();
		$zeroUpvotes = $zeroComments = 0;
		$stmt = $db->prepare("INSERT INTO links VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->execute([null, $userID, $title, $content, $zeroUpvotes, $zeroComments, null]);
		$last_id = $db->lastInsertId();
		$stmt = null;
		return $last_id;
	}

	public static function fetchAllProperties($links, $loggedIn) {
		$db = \DB::get_instance();
		$extendedLinks = array();
		for ($i = 0; $i < sizeof($links); $i += 1) {
			array_push($extendedLinks, $links[$i]);
			$userInfo = \Model\UserModel::findByID($links[$i]['userID']);
			$isUpvoted = \Model\LinkUpvoteModel::isUpvoted($links[$i]['id'], $loggedIn);
			$tagsOnLink = \Model\TagsModel::tagsByLink($links[$i]['id']);
			$tags = array();
			for ($j = 0; $j < sizeof($tagsOnLink); $j += 1) {
				array_push($tags, $tagsOnLink[$j]['tag']);
			}
			//Appending upvote status of logged in user
			$extendedLinks[$i]['isUpvoted'] = $isUpvoted;
			array_push($extendedLinks[$i], $isUpvoted);
			//Appending username
			$extendedLinks[$i]['username'] = $userInfo['username'];
			array_push($extendedLinks[$i], $userInfo['username']);
			//Appending tags
			$extendedLinks[$i]['tags'] = $tags;
			array_push($extendedLinks[$i], $tags);
		}
		return $extendedLinks;
	}

}
