<?
include('blogadmin.php'); # the PSG blog/config/index file
include('psg.php');

function dump_post($post) {
	print "TITLE: ".stripslashes($post['subject'])."\n";
	print "AUTHOR: Teri\n";
	print "STATUS: publish\n";
	print "DATE: ".strftime("%D %R", $post['date'])."\n";

	# categories
	$tags = explode(',', $post['tags']);
	foreach ($tags as $tag) {
		$tag = trim($tag);
		if (!empty($tag)) {
			print "CATEGORY: {$tag}\n";
		}
	}

	print "-----\n";
	print "BODY:\n";
	print stripslashes($post['body'])."\n";

	if (!empty($post['more'])) {
		print "-----\n";
		print "EXTENDED BODY:\n";
		print stripslashes($post['more'])."\n";
	}

	# comments
	$comments = getComments($post['id']);
	if ($comments && (sizeof($comments) == 1)) {
		$comment = $comments[0];
		$comments = array(1 => $comment);
	}
	if ($comments) {
		foreach ($comments as $comment) {
			print "-----\n";
			print "COMMENT:\n";
			print "AUTHOR: {$comment['name']}\n";
			print "EMAIL: {$comment['email']}\n";
			print "URL: {$comment['url']}\n";
			print "DATE: ".strftime("%D %R", $comment['date'])."\n";
			print stripslashes($comment['body'])."\n";
		}
	}

	print "--------\n";
}

header('Content-Type: text/plain');

$archives = getArchives();
$articles = getArticles();
$posts = array_merge($archives, $articles);
$posts_sorted = array();

foreach ($posts as $post) {
	$posts_sorted[$post['id']] = $post;
}
ksort($posts_sorted);

foreach ($posts_sorted as $post) {
	dump_post($post);
}

?>
