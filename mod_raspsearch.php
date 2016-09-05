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
$serverDate = date("Y-m-d", mktime(date("H")-1));
if (!empty($from_id) && !empty($to_id) && !empty($from) && !empty($to) && !empty($date)) $need = true; else $need = false;
$user = JFactory::getUser();
if (!$user->guest) {
  $db = JFactory::getDbo();
   $query = "SELECT DISTINCT `h`.*, `s1`.`name` as `from`, `s1`.`popularName` as `popularFrom`, `s2`.`name` as `to`, `s2`.`popularName` as `popularTo`
				FROM `#__rasp_search_history` as `h`
				LEFT JOIN `#__station_list` as `s1` ON (`h`.`from_id`=`s1`.`id`)
				LEFT JOIN `#__station_list` as `s2` ON (`h`.`to_id`=`s2`.`id`)
				WHERE `h`.`uid`=".$db->quote($user->id)."
				ORDER BY `h`.`counter` DESC
				LIMIT 3";
   $db->setQuery($query);
   $lastSearch = $db->loadObjectList();
}
?>
<div style="width: 100%;">
 <form action="/rasp/search/" method="get">
 <input type="hidden" name="from_id" id="from_id" value="<?php if ($need) echo $from_id; ?>" />
 <input type="hidden" name="to_id" id="to_id" value="<?php if ($need) echo $to_id; ?>" />
 <table class="rasp_form_search">
  <tr><td class="rasp_form_search_td">
   <input type="text" id="rasp_from" name="from" value="<?php if ($need) echo $from; ?>" placeholder="Откуда едем" autocomplete="off" onkeyup="station_search(this.value, 'from')" />
   <div id="div_from" class="div_station_search">
    <ul id="ul_from" class="ul_station"></ul>
   </div>
  </td></tr>
  <tr><td class="rasp_form_search_td">
   <input type="text" id="rasp_to" name="to" value="<?php if ($need) echo $to; ?>" placeholder="Куда едем" autocomplete="off" onkeyup="station_search(this.value, 'to')" />
  </td></tr>
  <tr><td class="rasp_form_search_td">
   <input type="date" name="date" value="<?php if ($need) echo $date; else echo $serverDate; ?>" min="<?=$serverDate?>" />
    <span class="obratno" onclick="obratno()">Обратно</span>
   <div id="div_to" class="div_station_search">
    <ul id="ul_to" class="ul_station"></ul>
   </div>
  </td></tr>
  <tr>
   <td class="rasp_form_search_td">
     <?php if (!$user->guest && !empty($lastSearch[0])) {
      ?> <ul> <?php
      foreach ($lastSearch as $popular) {
       $from = $popular->popularFrom == null ? $popular->from : $popular->popularFrom;
       $to = $popular->popularTo == null ? $popular->to : $popular->popularTo;
       $url = JRoute::_("index.php?option=com_rasp&view=search&from_id=".$popular->from_id."&to_id=".$popular->to_id."&from=".$from."&to=".$to."&date=".$serverDate);
       ?>
       <li class="historySearchLi"><a href="<?=$url?>" target="_blank" class="historySearchLink"><?=$from.' - '.$to?></a></li>
       <?php
      }
      ?></ul><?php
     } if ($user->guest) {
        echo 'История поиска сохряняется только у зарегистрированных пользователей. Зарегистрируйтесь для того, чтобы получить все преимущества нашего сервиса.';
     }
     elseif (empty($lastSearch[0])) {
        echo 'Вы ещё ничего не искали';
     }
     ?>
   </td>
  </tr>
  <tr><td class="rasp_form_search_td">
   <input type="submit" value="Поехали!" />
  </td></tr>
 </table>
 </form>
</div>