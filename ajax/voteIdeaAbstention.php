<?php

require("../config.php");

$id=$_GET["id"];

if (isset($_SESSION['user']) && $_SESSION['user'] == $db->getUsername($_SESSION["userid"])) {

	if ($db->isIdeaOpen($id) == 1) {
		echo '<script>alert("'. _('This idea is closed') .'")</script>';
	} else {
		$voted = $db->userVotedIdea($id, $_SESSION["userid"]);
		if ($voted == false) {
			$db->voteIdeaAbstention($id);
			echo '<script>$("#'. $id .' .ideaAbstention").html("'. $db->getIdeaAbstentionVotes($id) .'");</script>';
		} else {
			echo '<script>alert("'. _('You can vote only one time!') .'")</script>';
		}
	}
}
else
{
echo '<script>alert("'. _('You must be registered to vote') .'")</script>';
}
?>