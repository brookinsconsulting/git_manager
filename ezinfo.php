<?php
/**
 * @package GitManager
 * @class   git_managerInfo
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    26 Sep 2013
 **/

class git_managerInfo
{
	public static function info() {
		return array(
			'Name'      => 'NXC Varnish',
			'Version'   => '1.0',
			'Author'    => 'Serhey Dolgushev',
			'Copyright' => 'Copyright &copy; ' . date( 'Y' ) . ' <a href="http://ua.linkedin.com/in/serheydolgushev" target="blank">Serhey Dolgushev</a>'
		);
	}
}