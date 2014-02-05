<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class JobboardViewHuman extends JView {

    function display($tpl = null) {
        $app =& JFactory::getApplication();

        $human_verif = new JobBoardHumanHelper();
        $human_verif->getImage();

    }

}

?>