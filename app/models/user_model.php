<?php

namespace Model;

class UserModel {

	public static function insert($name, $username, $password) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO users VALUES (?, ?, ?, ?)");
		$stmt->execute([NULL, $name, $username, $password]);
		$stmt = null;
	}

	public static function findByUser($user) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->execute([$user]);
		$row = $stmt->fetch();
		return $row;
	}

	public static function findByID($userID) {
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
		$stmt->execute([$userID]);
		$row = $stmt->fetch();
		return $row;
	}

}
