<?php
require '../vendor/autoload.php';
Toro::serve(array(
	"/" => "\Controller\HomeController",
	"/link/:number" => "\Controller\LinkDiscussionController",
	"/link/:number/:alpha" => "\Controller\LinkDiscussionController",
	"/profile/:number" => "\Controller\ProfileController",
	"/new" => "\Controller\NewLinksController",
	"/best" => "\Controller\AllTimeHighController",
	"/following" => "\Controller\FollowingController",
	"/login" => "\Controller\AuthController",
	"/logout" => "\Controller\LogoutController",
	"/upvote/link" => "\Controller\LinkUpvoteController",
	"/upvote/comment" => "\Controller\CommentUpvoteController",
	"/follow" => "\Controller\FollowController",
	"/following" => "\Controller\FollowingController",
	"/post" => "\Controller\PostLinkController",
	"/tag/:alpha" => "\Controller\TagController",

));
