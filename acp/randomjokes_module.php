<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace stoker\randomjokes\acp;

class randomjokes_module
{
    public $u_action;
    protected $action;
    protected $table;

    public function main($id, $mode)
    {
        global $config, $db, $user, $template, $request, $table_prefix;

        $this->table = $table_prefix . 'randomjokes';

        $this->tpl_name = 'acp_randomjokes';
        $this->page_title = $user->lang('RANDOMJOKES_TITLE');
        add_form_key('acp_randomjokes');

        $sql = 'SELECT *
            FROM ' . $this->table . '
            ORDER BY randomjokes_id ASC';
        $result = $db->sql_query($sql);

        $row_count = 0;
        while ($row = $db->sql_fetchrow($result)) {
            $template->assign_block_vars('randomjokes', array(
                'JOKE_ID'          	=> $row['randomjokes_id'],
                'JOKE_TEXT'        	=> $row['randomjokes_text'],
                'U_EDIT'        	=> $this->u_action . "&amp;id=" . $row['randomjokes_id'] . "&amp;action=edit",
                'U_DELETE'      	=> $this->u_action . "&amp;id=" . $row['randomjokes_id'] . "&amp;action=delete"
            ));
            $row_count++;
        }
        $db->sql_freeresult($result);

        $template->assign_vars(array(
            'S_ROW_COUNT'               		=> $row_count,
            'S_RANDOMJOKES_ENABLED'				=> $config['randomjokes_enable'],
			'S_RANDOMJOKES_ENABLED_PORTAL'		=> $config['randomjokes_portal_enable'],
			'S_RANDOMJOKES_ENABLED_SMILE'		=> $config['randomjokes_smile_enable'],
        ));

        $submit = $request->is_set_post('submit');
        $enable_submit = $request->is_set_post('enable_submit');

        $edit_id = $request->variable('edit', 0);

        $enabled_rj = $request->variable('enable_randomjokes', 0);
		$enabled_rjp = $request->variable('enable_randomjokes_portal', 0);
		$enabled_rjs = $request->variable('enable_randomjokes_smile', 0);

        if ($submit) {
            if (!check_form_key('acp_randomjokes')) {
                trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
            }

            $randomjokes_text = ($request->variable('randomjokes_text', '', true));

            if ($randomjokes_text != '' && !$edit_id) {
                $sql_array = array(
                    'randomjokes_text'		=> $randomjokes_text
                );

                $sql = 'INSERT INTO ' . $this->table . ' ' . $db->sql_build_array('INSERT', $sql_array);
                $db->sql_query($sql);
                trigger_error($user->lang['RANDOMJOKES_ADDED'] . adm_back_link($this->u_action));
            } elseif ($randomjokes_text != '' && !empty($edit_id)) {
                $sql_array = array(
                    'randomjokes_text'		=> $randomjokes_text
                );

                $sql = 'UPDATE ' . $this->table . ' SET ' . $db->sql_build_array('UPDATE', $sql_array) . ' WHERE randomjokes_id = ' . (int) $edit_id;
                $db->sql_query($sql);
                trigger_error($user->lang['RANDOMJOKES_UPDATED'] . adm_back_link($this->u_action));
            } else {
                trigger_error($user->lang['RANDOMJOKES_ERROR'] . adm_back_link($this->u_action . '&amp;action=add'), E_USER_WARNING);
            }
        }

        if ($enable_submit) {
            if (!check_form_key('acp_randomjokes')) {
                trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
            }

            $config->set('randomjokes_enable', $enabled_rj);
			$config->set('randomjokes_portal_enable', $enabled_rjp);
			$config->set('randomjokes_smile_enable', $enabled_rjs);
            trigger_error($user->lang['RANDOMJOKES_CONF_UPDATED'] . adm_back_link($this->u_action));
        }

        $action = $request->variable('action', '');
        $id_randomjokes = $request->variable('id', 0);
        if ($action && $id_randomjokes != 0) {
            switch ($action) {
                case 'edit':
                    $sql = 'SELECT *
                        FROM ' . $this->table . '
                        WHERE randomjokes_id = ' . (int) $id_randomjokes;
                    $result = $db->sql_query($sql);
                    $row = $db->sql_fetchrow($result);
                    $template->assign_vars(array(
						'JOKE_TEXT'        => $row['randomjokes_text'],
                        'JOKE_EDIT'        => $row['randomjokes_id'],
                    ));
                    $db->sql_freeresult($result);
                    break;
                case 'delete':
                    if (confirm_box(true)) {
                        $sql = 'DELETE FROM
                            ' . $this->table . '
                            WHERE randomjokes_id = ' . (int) $id_randomjokes;
                        $db->sql_query($sql);
                        redirect($this->u_action);
                    } else {
                        confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                            'action'        => $action,
                            'id'            => $id_randomjokes))
                        );
                    }
                    break;
            }
        }
    }
}
