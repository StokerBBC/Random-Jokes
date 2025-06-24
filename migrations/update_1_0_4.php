<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace stoker\randomjokes\migrations;

class update_1_0_4 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\stoker\randomjokes\migrations\update_1_0_3');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('randomjokes_smile_enable', 0)),
		);
	}
}
