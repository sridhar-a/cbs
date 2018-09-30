<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$default = 'CBE';
// $cities = array('CBE' => 'Coimbatore', 'CHN' => 'Chennai');
$cities = array('CBE' => 'Coimbatore');
$options = array();
foreach($cities as $key=>$value) :
    $options[] = JHTML::_('select.option', $key, $value);
endforeach;
$city = JHTML::_('select.genericlist', $options, 'city', 'class="inputbox"', 'value', 'text', $default);
?>
<div class="custom search module-<?=$module->id?> <?php echo $moduleclass_sfx; ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="" method="post" class="form-search">
                    <div class="form-group">
                        <label for="city">City:</label>
            	        <?=$city?>
                    </div>
                    <div class="form-group form-group-source">
                        <label for="source">Source:</label>
                        <input type="text" class="form-control required" id="source" placeholder="Where you are now ?" style="color: blue;">
                    </div>
                    <div class="form-group text-center form-group-swap">
		        <a href="#" class="swap"><img src="images/icons/double-arrow.png" /></a>
                    </div>
                    <div class="form-group form-group-destination">
                        <label for="destination">Destination:</label>
                        <input type="text" class="form-control required" id="destination" placeholder="Where you have to go ?" style="color: green;">
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Search" />
                </form>
		<div id="bus_route_search_results"></div>
            </div>
        </div>
    </div>
</div>
