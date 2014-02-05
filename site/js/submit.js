
/**
  @package JobBoard
  @copyright Copyright (c)2010-2012 Tandolin
  @license : GNU General Public License v2 or later
----------------------------------------------------------------------- */

window.addEvent("domready",function(){$("submit_application").addEvent("click",function(a){a.stop();this.disabled=1;$("loadr").removeClass("hidel");this.setStyles({background:"#ccc",color:"#ccc","border-color":"#ddd"});this.form.submit()})});