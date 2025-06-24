<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace stoker\randomjokes\acp;

class randomjokes_info
{
	public function module()
	{
		return array(
			'filename'	=> '\stoker\randomjokes\acp\randomjokes_module',
			'title'		=> 'RANDOMJOKES_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'RANDOMJOKES_CONFIG',
					'auth'	=> 'ext_stoker/randomjokes && acl_a_board',
					'cat'	=> array('RANDOMJOKES_TITLE')
				),
			),
		);
	}
}
