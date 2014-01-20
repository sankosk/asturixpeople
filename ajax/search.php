<?php

require("../config.php");

$text=$_GET["text"];
$page=$_GET["page"];

// user inputs are devil!
echo '<h1>'. _('Search results for ') .'"'.htmlentities($text).'"</h1>';

$ideas = $db->search($text, $page);

$numIdeas = 0;

while ($idea = $ideas->fetch_array(MYSQLI_ASSOC)) 
{
$ui->idea($idea, true);
$numIdeas = 1;
}
if ($numIdeas == 0) {
echo '<h2>'. _('No results for ideas') .'</h2>';
} else {
echo '<script>$("#content").highlight("'.$text.'", "highlight");</script>';
}

//another xss searching an user account (if the name of the acc is changed to <htmltags>)
$users = $db->searchAccounts(htmlentities($text), $page);

$numAccounts = 0;

while ($user = $users->fetch_array(MYSQLI_ASSOC)) 
{
$ui->user($user);
$numAccounts = 1;
}
if ($numAccounts == 0) {
echo '<h2>'. _('No results for accounts') .'</h2>';
} else {
echo '<script>$("#content").highlight("'.$text.'", "highlight");</script>';
}

$ideasNum = $db->getNumberOfSearchResults($text);
$pages = ceil($ideasNum/ITEMS);

echo '<div class="pagination">';

for ($i=1; $i<=$pages; $i++)
{
echo '<button onclick="search(\''.$text.'\','.$i.')"';
if ($i == $page) {
echo 'class="currentPage"';
}
echo '>'.$i.'</button>';
}

echo '</div>';

?>
