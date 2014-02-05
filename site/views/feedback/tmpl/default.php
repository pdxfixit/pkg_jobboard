<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
?>
<?php echo 'name: ' . $this->first_name . '<br />file: ' . $this->filename; ?>
    <br />
<?php echo $this->result; ?>
    <br />
<?php echo json_encode($this->post); ?>