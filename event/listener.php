<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace stoker\randomjokes\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
    protected $db;
    protected $user;
    protected $config;
    protected $template;
    protected $table;

    public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\template\template $template, $randomjokes)
    {
        $this->db = $db;
        $this->user = $user;
        $this->config = $config;
        $this->template = $template;
        $this->table = $randomjokes;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'core.permissions'	=> 'add_permission',
			'core.user_setup' 	=> 'load_language_on_setup',
            'core.index_modify_page_title'	=> 'display_randomjokes',
			'stoker.portal.main_controller_render_template_before' 	=> 'display_randomjokes',
        );
    }

    public function add_permission($event)
    {
        $permissions = $event['permissions'];
        $permissions['a_rqs'] = array('lang' => 'ACL_A_RANDOMJOKES', 'cat' => 'misc');
        $event['permissions'] = $permissions;
    }
	
	public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'stoker/randomjokes',
            'lang_set' => 'common',
        );
        $event['lang_set_ext'] = $lang_set_ext;
    }

    public function display_randomjokes($event)
    {
        if (!empty($this->config['randomjokes_enable']) || !empty($this->config['randomjokes_portal_enable']))
		{
			switch ($this->db->get_sql_layer())
			{
				case 'postgres':
					$random = 'RANDOM()';
					break;

				case 'mssql':
				case 'mssql_odbc':
					$random = 'NEWID()';
					break;

				default:
					$random = 'RAND()';
					break;
			}

			$sql = "SELECT * FROM " . $this->table . " ORDER BY $random";
			$result_joke = $this->db->sql_query_limit($sql, 1);

			while ($row_joke = $this->db->sql_fetchrow($result_joke))
			{
				$this->template->assign_block_vars('randomjokes', array(
					'JOKES_TEXT'    => html_entity_decode($row_joke['randomjokes_text']),
				));
			}

			$this->db->sql_freeresult($result_joke);
		
			$this->template->assign_vars(array(
				'S_RANDOMJOKES_ENABLED' => !empty($this->config['randomjokes_enable']),
				'S_RANDOMJOKES_ENABLED_PORTAL' => !empty($this->config['randomjokes_portal_enable']),
				'S_RANDOMJOKES_ENABLED_SMILE' => !empty($this->config['randomjokes_smile_enable']),
			));
		}
    }
}
