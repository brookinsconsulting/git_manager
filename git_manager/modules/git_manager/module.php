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
			'CheckoutRemoteBranch' => 'CheckoutRemoteBranch'
		)
	)
);

$FunctionList = array(
	'git_manager' => array()
);