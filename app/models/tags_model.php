<?php
namespace Model;

class TagsModel {

	public static function tag($linkID, $tag) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO tags VALUES (?, ?)");
		$stmt->execute([$linkID, $tag]);
		$stmt = null;
	}

	public static function linksByTag($tag) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM tags WHERE tag = ?");
		$stmt->execute([$tag]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

	public static function tagsByLink($linkID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM tags WHERE linkID = ?");
		$stmt->execute([$linkID]);
		$rows = $stmt->fetchAll();
		$stmt = null;
		return $rows;
	}

}
