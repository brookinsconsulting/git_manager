<?php
/**
 * @package GitManager
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    26 Sep 2013
 **/

$Module = array(
	'name'      => 'Git Manager',
	'functions' => array()
);

$ViewList = array(
	'dashboard' => array(
		'script'                  => 'dashboard.php',
		'functions'               => array( 'git_manager' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart',
		'single_post_actions'     => array(
			'CheckoutLocalBranch'  => 'CheckoutLocalBranch',
			'CheckoutRemoteBranch' => 'CheckoutRemoteBranch',
			'SetCommitsFilter'     => 'SetCommitsFilter',
			'CheckoutCommit'       => 'CheckoutCommit'
		)
	),
	'commit_details' => array(
		'script'                  => 'commit_details.php',
		'functions'               => array( 'git_manager' ),
		'params'                  => array( 'Hash' ),
		'default_navigation_part' => 'ezsetupnavigationpart'
	),
	'dump' => array(
		'script'                  => 'dump.php',
		'functions'               => array( 'dump' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart'
	)
);

$FunctionList = array(
	'git_manager' => array(),
	'dump' => array()
);