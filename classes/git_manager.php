<?php
/**
 * @package GitManager
 * @class   GitManager
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    26 Sep 2013
 **/

class GitManager
{
	private static $path = './';
	private static $instance = null;

	private $callbackAttributes = array(
		'current_branch'  => 'getCurrentBranch',
		'current_commit'  => 'getCurrentCommit',
		'local_branches'  => 'getLocalBranches',
		'remote_branches' => 'getRemoteBranches'
	);

	private function __construct() {}

	public static function getInstance() {
		if( self::$instance === null ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	public function attributes() {
		return array_keys( $this->callbackAttributes );
	}

	public function hasAttribute( $attr ) {
		return isset( $this->callbackAttributes[ $attr ] );
	}

	public function attribute( $attr ) {
		if( isset( $this->callbackAttributes[ $attr ] ) === false ) {
			throw new Exception( 'Undefined "' . $attr . '" attribute' );
		}

		$callback = array(
			$this,
			$this->callbackAttributes[ $attr ]
		);
		return call_user_func( $callback );
	}

	private function getCurrentBranch() {
		return $this->cli( 'rev-parse --abbrev-ref HEAD' );
	}

	private function getCurrentCommit() {
		return $this->cli( 'rev-parse --verify HEAD' );
	}

	private function getLocalBranches() {
		$branches = $this->cli( 'branch', false, true );
		foreach( $branches as $key => $branch )  {
			$branches[ $key ] = trim( $branch, '* ' );
		}

		return $branches;
	}

	private function getRemoteBranches() {
		$branches = $this->cli( 'branch -r', false, true );
		foreach( $branches as $key => $branch ) {
			if( strpos( $branch, 'origin/HEAD' ) !== false ) {
				unset( $branches[ $key ] );
				continue;
			}

			$branches[ $key ] = str_replace( 'origin/', '', $branch );
		}
		return $branches;
	}

	public function getCommits( array $params = null ) {
		$separator = ',|.';
		$filter    = null;
		$limit     = 50;
		
		if( is_array(  $params ) ) {
			if( isset( $params['author'] ) ) {
				$limit .= ' --author=' . $params['author'];
			}
			if( isset( $params['start_date'] ) ) {
				$limit .= ' --since=' . $params['start_date'];
			}
			if( isset( $params['end_date'] ) ) {
				$limit .= ' --until=' . $params['end_date'];
			}
		}
		
		$commits = $this->cli(
			'log -' . $limit . $filter . ' --pretty=format:"%H' . $separator . '%an' . $separator . '%cD' . $separator . '%s"',
                        false,
			true
		);
	
		$return = array();
		foreach( $commits as $commit ) {
			$commit = explode( $separator, $commit );
			if( count( $commit ) !== 4 ) {
				continue;
			}

			$return[] = array(
				'hash'   => $commit[0],
				'author' => $commit[1],
				'date'   => $commit[2],
				'title'  => $commit[3]
			);
		}

		return $return;
	}

	public function checkout( $branch ) {
		return $this->cli( 'checkout ' . $branch );
	}

        public function pull( $branch, $regenerateAutoloads = false ) {
                return $this->cli( 'pull origin ' . $branch, false, $regenerateAutoloads );
        }

	public function commitInfo( $hash ) {
		return $this->cli( 'log -1 -p ' . escapeshellcmd( $hash ) );
	}

	public function checkoutCommit( $hash ) {
		return $this->cli( 'checkout ' . escapeshellcmd( $hash ) );
	}

	public function updateSubmodules() {
                $result = $this->cli( 'submodule update --init --recursive', false );

                if( strpos( $result, 'You need to run this command from the toplevel of the working tree') !== false )
                {
                    $result = $this->cli( 'submodule update --init --recursive', '..' );
                }

		return $result;
	}

	private function cli( $command, $path = false, $explodeLines = false ) {
                if( $path === false )
                {
                    $cdCmd = 'cd ' . self::$path;
                }
                else
                {
                    $cdCmd = 'cd ' . $path;
                }

		$cmd    = $cdCmd . ' && git ' . $command . ' 2>&1';
		$result = trim( shell_exec( $cmd ) );

                if( $regenerateAutoloads === true )
                {
                    $result .= trim( shell_exec( $cdCmd . ' && ./bin/php/ezpgenerateautoloads.php 2>&1' ) );
                    // clean up results for display within the browser for easy readability
                    $result = str_replace( '[0m', '', str_replace( '[31m', '', str_replace( "of them to the autoload array.\n", 'of them to the autoload array.', str_replace('Scanning for PHP-files', "\n\nScanning for PHP-files", $result ) ) ) );
                }

		if( $explodeLines ) {
			$result = explode( "\n", $result );
		}

		return $result;
	}
}