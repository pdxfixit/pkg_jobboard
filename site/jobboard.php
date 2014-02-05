<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted Access');
require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'jobboard.php');

JRequest::setVar('view', JRequest::getCmd('view', 'jobboard'));
JRequest::setVar('cont', JRequest::getCmd('view', 'jobboard'));
JRequest::setVar('task', JRequest::getCmd('task', 'display'));

jimport('joomla.filesystem.file');

$cont = JRequest::getCmd('cont', 'jobboard');
$task = JRequest::getCmd('task', 'display');
$path = JPATH_COMPONENT . DS . 'controllers' . DS . $cont . '.php';
if (JFile::exists($path)) {
    require_once($path);
} else {
    JError::raiseError('500', JText::_('Unknown controller' . $path));
}

?>