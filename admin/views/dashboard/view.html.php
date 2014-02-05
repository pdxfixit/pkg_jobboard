<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewDashboard extends JView {

    function display($tpl = null) {
        if (version_compare(JVERSION, '1.7.0', 'ge')) {
            // Options button.
            if (JFactory::getUser()->authorise('core.admin', 'com_jobboard')) {
                JToolBarHelper::preferences('com_jobboard');
            }
        }
        $this->assign('jb_render', JobBoardHelper::renderJobBoardx());;
        parent::display($tpl);
    }

}

?>