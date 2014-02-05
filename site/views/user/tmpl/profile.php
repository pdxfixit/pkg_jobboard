<?php
/**
  @package JobBoard
  @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
  @license : GNU General Public License v2 or later
----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');  

?>

<div id="jbcnav">
  <div id="leftwrap">
      <?php echo $this->loadTemplate('tabs'); ?>
      <?php echo $this->loadTemplate('subtabs'); ?>
  </div>
  <div id="upanel">
      <?php echo $this->loadTemplate('upanel'); ?>
  </div>
</div>
<div id="jbcontent">
    <div class="ovsummary">
    User summary
    </div>
    <div class="ovsummary">
    ext summary
    </div>
</div>
<div id ="jbcsidebar">
    <?php echo $this->loadTemplate('sidebar'); ?>
</div>
