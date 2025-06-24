<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace stoker\randomjokes\migrations;

class install_randomjokes extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}
	
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'randomjokes'	=> array(
					'COLUMNS'	=> array(
						'randomjokes_id'			=> array('TINT:8', null, 'auto_increment'),
						'randomjokes_text'			=> array('VCHAR:2550', ''),
					),
					'PRIMARY_KEY'	=> 'randomjokes_id',
				),
			),
		);
	}
	
	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'randomjokes',
			),
		);
	}

	public function update_data()
	{
		return array(

			// Add configs
			array('config.add', array('randomjokes_enable', 0)),
			array('config.add', array('randomjokes_portal_enable', 0)),
			array('config.add', array('randomjokes_version', '1.0.2')),
			// Add permission
			array('permission.add', array('a_rqs', true)),
			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_rqs')),
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'RANDOMJOKES_TITLE'
			)),
			array('module.add', array(
				'acp',
				'RANDOMJOKES_TITLE',
				array(
					'module_basename'	=> '\stoker\randomjokes\acp\randomjokes_module',
					'modes' => array('settings'),
				),
			)),		
		);
	}	
}
