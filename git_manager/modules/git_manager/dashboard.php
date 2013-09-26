<?php
/**
 * @package GitManager
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    26 Sep 2013
 **/


$http    = eZHTTPTool::instance();
$module  = $Params['Module'];
$git     = GitManager::getInstance();
$error   = null;
$message = null;
$output  = null;

if(
	$module->isCurrentAction( 'CheckoutLocalBranch' )
	|| $module->isCurrentAction( 'CheckoutRemoteBranch' )
) {
	$branches = array_merge(
		$git->attribute( 'local_branches' ),
		$git->attribute( 'remote_branches' )
	);
	$branch = $http->postVariable( 'branch' );
	
	if( in_array( $branch, $branches ) ) {
		$output  = $git->checkout( $branch );
		$output .= "\n" . $git->pull( $branch );
		$message = '"' . $branch . '" branch is checked out';
		var_dump( $output );
	} else {
		$error = 'Invalid "' . $branch . '" branch';
	}
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'git_manager', $git );
$tpl->setVariable( 'error', $error );
$tpl->setVariable( 'message', $message );
$tpl->setVariable( 'output',  $output );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:git_manager/dashboard.tpl' );
$Result['path']    = array(
	array(
		'text' => ezpI18n::tr( 'extension/git_manager', 'GIT Manager' ),
		'url'  => false
	)
);