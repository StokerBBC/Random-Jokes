<?php
/**
*
* @package phpBB Extension - Random Jokes
* @copyright (c) 2025 Stoker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'RANDOMJOKES_TITLE'							=> 'Random Jokes',
    'RANDOMJOKES_CONFIG'						=> 'Configuration',
	'RANDOMJOKES_EDIT'							=> 'Edit joke',
	'RANDOMJOKES_ADD'							=> 'Add joke',
	'RANDOMJOKES_NAME'							=> 'Author',
	'RANDOMJOKES_NAME_EXPLAIN'					=> 'Name of the joke author. (MAX 250 characters)',
	'RANDOMJOKES_TEXT'							=> 'Joke',
	'RANDOMJOKES_TEXT_EXPLAIN'					=> 'Joke text. (MAX 2500 characters - HTML allowed)',
	'RANDOMJOKES_NAME_NAME'						=> 'Name of the joke author',
	'RANDOMJOKES_TEXT_TEXT'						=> 'Joke text',
	'RANDOMJOKES_ADDED'					        => 'New joke has been added!',
	'RANDOMJOKES_UPDATED'						=> 'Joke has been updated!',
	'RANDOMJOKES_ENABLE'						=> 'Random Jokes on Index',
	'RANDOMJOKES_ENABLE_EXPLAIN'				=> 'Enable Random Jokes on forum index.',
	'RANDOMJOKES_ENABLE_PORTAL'					=> 'Random Jokes on Portal',
	'RANDOMJOKES_ENABLE_PORTAL_EXPLAIN'			=> 'Enable Random Jokes on Simple Portal.',
	'RANDOMJOKES_ENABLE_SMILE'					=> 'Smiley Image',
	'RANDOMJOKES_ENABLE_SMILE_EXPLAIN'			=> 'Enable smiley background image in jokes',
	'RANDOMJOKES_CONF_UPDATED'				    => 'Random Jokes configuration was succesfully updated.',
	'RANDOMJOKES_ERROR'				            => 'Random Jokes setting error.',
    'ACP_NO_RANDOMJOKES'						=> 'There are no jokes yet.',
	'ACL_A_RANDOMJOKES'							=> 'Can manage Random Jokes',
	'ACP_RANDOMJOKES_BADGE'						=> 'Random Jokes-1.0.4',
	'ACP_RANDOMJOKES_SETTINGS_EXPLAIN'			=> 'If you like this extension, please consider following',
	'ACP_RANDOMJOKES_DONATION'					=> 'Make a Donation',
	'ACP_RANDOMJOKES_MEMBER'					=> 'Become an active member of my Community',
	'ACP_RANDOMJOKES_SUPPORT'					=> 'Extension support or feedback',
));