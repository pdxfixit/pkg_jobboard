<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'tables');

jimport('joomla.application.component.view');

class JobboardViewEducationedit extends JView {

    function display($tpl = null) {
        $task = JRequest::getVar('task', '');
        $row =& JTable::getInstance('Education', 'Table');
        $this->assign('jb_render', JobBoardHelper::renderJobBoardx());
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = intval($cid[0]);
        $row->load($id);
        $this->assignRef('row', $row);
        parent::display($tpl);
    }
}