<?php
header('Content-type: text/html; charset=UTF-8');

require 'vendor/autoload.php';
require 'classes/issue.php';
require 'classes/github_api.php';

$app = new \Slim\Slim();

include 'config.php';

$app->get('/', function() use ($app) {
    $gha = new GithubApi($app);
	$issues = $gha->parseToTestIssues();
	$closed_issues = $gha->parseClosedBugs();
    
    
    $app->render('../views/issues.php', array('issues' => $issues));
});
$app->get('/books/:id', function ($id) {
    echo $id;
});

$app->get('books', function ($id) {
    echo "books";
});

$app->run();