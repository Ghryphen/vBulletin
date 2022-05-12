<?php
/*
+---------------------------------------------------------------+
|       Itemstats FR Core
|
|       Yahourt
|       http://itemstats.free.fr
|       itemstats@free.fr
|
|       Thorkal
|       EU Elune / Horde
|       www.elune-imperium.com
+---------------------------------------------------------------+
*/

include_once(dirname(__FILE__) . '/itemstats.php');
if (defined(path_itemstats))
    define("path_itemstats", "./itemstats/");

function itemstats_parse($message)
{
	$item_stats = new ItemStats();
    if ($item_stats->connected == false)
        return ($message);

    $message = utf8_decode($message);

	// Search for [item] tags, and replace them with HTML for the specified item.
	while (preg_match('#\[(item)(=[0-5])?\](.+?)\[/item\]#s', $message, $match) OR preg_match('#\[(itemico)(=[0-5])?\](.+?)\[/itemico\]#s', $message, $match))
	{
		// Grab the item name.
		$item_name = $match[3];
        $icon_lsize = $match[2];
        $item_type = $match[1];

        //===   Previous processing   =========================================
        //=====================================================================

        //===   GET HTML FOR DISPLAY   ========================================
        $item_html = $item_stats->getItemForDisplay($item_name, $item_type, $icon_lsize, automatic_search);
        //=====================================================================

        //===    Next processing   ============================================
        if (defined(path_itemstats))
            $item_html = str_replace("{PATH_ITEMSTATS}", path_itemstats, $item_html);
        else
            $item_html = str_replace("{PATH_ITEMSTATS}", "/itemstats", $item_html);
        //=====================================================================

		// Finally, replace the bbcode with the html.
		$message = str_replace($match[0], $item_html, $message);
	}
    $message = utf8_encode($message);
	return $message;
}



?>