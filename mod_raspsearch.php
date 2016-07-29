<?php
defined('_JEXEC') or die('');
$doc =& JFactory::getDocument();
$jinput = JFactory::getApplication()->input;
$doc->addScript(JURI::base().'media/mod_raspSearch/js/stations.js');
$doc->addStyleSheet(JURI::base().'media/mod_raspSearch/css/search.css');
$from_id = $jinput->getString('from_id', '');
$to_id = $jinput->getString('to_id', '');
$from = $jinput->getString('from', '');
$to = $jinput->getString('to', '');
$date = $jinput->getString('date', '');
if (!empty($from_id) && !empty($to_id) && !empty($from) && !empty($to) && !empty($date)) $need = true; else $need = false;
?>
<div style="width: 100%;">
 <form action="/rasp/search/" method="get">
 <input type="hidden" name="from_id" id="from_id" value="<?php if ($need) echo $from_id; ?>" />
 <input type="hidden" name="to_id" id="to_id" value="<?php if ($need) echo $to_id; ?>" />
 <table style="width: 100%;">
  <tr><td>
   <input type="text" id="rasp_from" name="from" value="<?php if ($need) echo $from; ?>" placeholder="Откуда едем" autocomplete="off" onkeyup="station_search(this.value, 'from')" />
   <div id="div_from" class="div_station_search">
    <ul id="ul_from" class="ul_station"></ul>
   </div>
  </td></tr>
  <tr><td>
   <input type="text" id="rasp_to" name="to" value="<?php if ($need) echo $to; ?>" placeholder="Куда едем" autocomplete="off" onkeyup="station_search(this.value, 'to')" />
  </td></tr>
  <tr><td>
   <input type="date" name="date" value="<?php if ($need) echo $date; else echo date("Y-m-d"); ?>" />
   <div id="div_to" class="div_station_search">
    <ul id="ul_to" class="ul_station"></ul>
   </div>
  </td></tr>
  <tr><td>
   <input type="submit" value="Поехали!" />
  </td></tr>
 </table>
 </form>
</div>