<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewEducation extends JView {

    function display($tpl = null) {
        $app = JFactory::getApplication();

        $rows = $this->get('data');
        $this->assignRef('rows', $rows);
        $pagination = $this->get('pagination');
        $this->assignRef('pagination', $pagination);
        $this->assign('jb_render', JobBoardHelper::renderJobBoardx());
        $lists['order'] = $app->getUserStateFromRequest('com_jobboard.education.filterOrder', 'filter_order', 'level');
        $lists['orderDirection'] = $app->getUserStateFromRequest('com_jobboard.education.filterOrderDirection', 'filter_order_Dir', 'DESC', 'cmd');
        $lists['orderDirection'] = (strtoupper($lists['orderDirection']) == 'ASC') ? 'ASC' : 'DESC';
        $this->assignRef('lists', $lists);
        parent::display($tpl);
    }
}