<?php
namespace Controller;

session_start();

class AuthController {

	public static function get() {
		if (isset($_SESSION['userID'])) {
			header("Location:/");
		} else {
			echo \View\Loader::make()->render('templates/auth.twig');
		}
	}

	public function post() {

		if (isset($_POST['login'])) {
			$user = \Model\UserModel::findByUser($_POST['username']);
			if (!$user) {
				echo "User not found. Please make a new account";
			} else {
				$password = sha1($_POST['password']);
				if ($password == $user['password']) {
					$_SESSION['userID'] = $user['id'];
					header("Location:/");
				} else {
					echo "Wrong Password";
				}
			}
		}

		if (isset($_POST['register'])) {

			$name = $_POST['name'];
			$username = $_POST['username'];
			$password = sha1($_POST['password']);
			$user = \Model\UserModel::findByUser($username);
			if (!$user) {
				\Model\UserModel::insert($name, $username, $password);
				$_SESSION['userID'] = \Model\UserModel::findByUser($username)['id'];
				header("Location:/");
			} else {
				echo "Username exists";

				header("Location:/login");
			}

		}
	}
}
