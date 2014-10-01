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
$filter  = array(
	'start_date' => null,
	'end_date'   => null,
	'author'     => null
);

$sess = $http->sessionVariable( 'git_commits_filter', array() );

$filter = is_array($sess) ? array_merge( $filter, $sess ) : $filter;

if(
	$module->isCurrentAction( 'CheckoutLocalBranch' )
	|| $module->isCurrentAction( 'CheckoutRemoteBranch' )
) {
	$branches = array_merge(
		$git->attribute( 'local_branches' ),
		$git->attribute( 'remote_branches' )
	);
	$branch = $http->postVariable( 'branch', null );
        $regenerateAutoloads = $http->postVariable( 'regenerate', false ) == 'regenerate' ? true : false;

        if( in_array( $branch, $branches ) ) {
                $output  = $git->checkout( $branch );
                $output .= "\n" . $git->pull( $branch, $regenerateAutoloads );
		$message = '"' . $branch . '" branch is checked out';
	} else {
		$error = 'Invalid "' . $branch . '" branch';
	}
} elseif( $module->isCurrentAction( 'CheckoutCommit' ) ) {
	$hash = $http->postVariable( 'hash', null );

	$output  = $git->checkoutCommit( $hash );
	$message = '"' . $hash . '" commit is checked out';
} elseif( $module->isCurrentAction( 'SetCommitsFilter' ) ) {
	$filter = array_merge( $filter, $http->postVariable( 'filter', array() ) );
}

$http->setSessionVariable( 'git_commits_filter', $filter );

$commits = $git->getCommits( $filter );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'git_manager', $git );
$tpl->setVariable( 'error', $error );
$tpl->setVariable( 'message', $message );
$tpl->setVariable( 'output',  $output );
$tpl->setVariable( 'filter',  $filter );
$tpl->setVariable( 'commits',  $commits );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:git_manager/dashboard.tpl' );
$Result['path']    = array(
	array(
		'text' => ezpI18n::tr( 'extension/git_manager', 'GIT Manager' ),
		'url'  => false
	)
);