<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewCareerlevels extends JView {

    function display($tpl = null) {
        $app = JFactory::getApplication();

        $rows = $this->get('data');
        $pagination = $this->get('pagination');
        $this->assignRef('rows', $rows);
        $this->assignRef('pagination', $pagination);
        $this->assign('jb_render', JobBoardHelper::renderJobBoardx());
        $lists['order'] = $app->getUserStateFromRequest('com_jobboard.careerlevels.filterOrder', 'filter_order', 'description', 'word');
        $lists['orderDirection'] = $app->getUserStateFromRequest('com_jobboard.careerlevels.filterOrderDirection', 'filter_order_Dir', 'ASC', 'cmd');
        $lists['orderDirection'] = (strtoupper($lists['orderDirection']) == 'ASC') ? 'ASC' : 'DESC';
        $this->assignRef('lists', $lists);
        parent::display($tpl);
    }
}