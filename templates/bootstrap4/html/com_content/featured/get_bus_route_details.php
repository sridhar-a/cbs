<?php
defined('_JEXEC') or die;

$jinput      = JFactory::getApplication()->input;

$city        = $jinput->get('city',        'CBE', 'STR');
$source      = $jinput->get('source',      'GANAPATHY', 'STR');
$destination = $jinput->get('destination', 'AVARAMPALAYAM', 'STR');

$emptyResults = '';
$directBus = '';
$tempResults1 = NULL;
$tempResults2 = NULL;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('bus_no', 'source', 'destination', 'route')))
      ->from($db->quoteName('#__bus_routes'))
      ->where($db->quoteName('city') . ' = \''. $city . '\'')
      ->where($db->quoteName('source') . ' LIKE \'%'. $source . '%\'')
      ->where($db->quoteName('destination') . ' LIKE \'%'. $destination . '%\'')
      ->order('bus_no ASC');
$db->setQuery($query);
$results = $db->loadObjectList();
$tempResults1 = $results;

$query = $db->getQuery(true);
$query->select($db->quoteName(array('bus_no', 'source', 'destination', 'route')))
      ->from($db->quoteName('#__bus_routes'))
      ->where($db->quoteName('city') . ' = \''. $city . '\'')
      ->Where($db->quoteName('destination') . ' LIKE \'%'. $source . '%\'')
      ->where($db->quoteName('source') . ' LIKE \'%'. $destination . '%\'')
      ->order('bus_no ASC');
$db->setQuery($query);
$results = $db->loadObjectList();
$tempResults2 = $results;
$results = array_merge($tempResults1, $tempResults2);
if ( !empty($results) ) {
    $directBus = 'Direct Bus available.';
}
if ( empty($results) ) {
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('bus_no', 'route')))
          ->from($db->quoteName('#__bus_routes'))
          ->where($db->quoteName('city') . ' = \''. $city . '\'')
          ->where($db->quoteName('route') . ' LIKE \'%'. $source . '%\'')
          // ->orWhere($db->quoteName('route') . ' LIKE \'%'. $destination . '%\'')
          ->Where($db->quoteName('route') . ' LIKE \'%'. $destination . '%\'')
          ->order('bus_no ASC');
    $db->setQuery($query);
    $results = $db->loadObjectList();
}

if ( !empty($results) ) {
    $directBus = 'Direct Bus Routes available.';
}

if ( empty($results) ) {

    // source
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('bus_no', 'source', 'destination', 'route')))
          ->from($db->quoteName('#__bus_routes'))
          ->where($db->quoteName('city') . ' = \''. $city . '\'')
          ->where($db->quoteName('route') . ' LIKE \'%'. $source . '%\'')
          ->order('bus_no ASC');
    $db->setQuery($query);
    $sourceResults = $db->loadObjectList();

    // destination
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('bus_no', 'source', 'destination', 'route')))
          ->from($db->quoteName('#__bus_routes'))
          ->where($db->quoteName('city') . ' = \''. $city . '\'')
          ->where($db->quoteName('route') . ' LIKE \'%'. $destination . '%\'')
          ->order('bus_no ASC');
    $db->setQuery($query);
    $destinationResults = $db->loadObjectList();

    foreach ( $sourceResults as $i=>$sourceResult ) {
        $route = $sourceResult->route;
        $bus_no = $sourceResult->bus_no;
	$sourcePoints = explode(',', $route);
        foreach ( $destinationResults as $j=>$destinationResult ) {
            $route = $destinationResult->route;
	    $destinationPoints = explode(',', $route);
	    foreach ( $sourcePoints as $sourcePoint ) {
	        foreach ( $destinationPoints as $destinationPoint ) {
                    $swicthPoint = '';
		    if ( $sourcePoint == $destinationPoint )  {
		        $swicthPoint = $sourcePoint = $destinationPoint;
			break 4;
                    }
	        }
	    }
        }
	if ( empty($swicthPoint) ) {
	    unset($sourceResults[$i]);
	}
    }
    if ( empty($sourceResults) and !empty($destinationResults) ) {
        $destinationResults = NULL;
    }
    if ( !empty($sourceResults) and empty($destinationResults) ) {
        $sourceResults = NULL;
    }
    if ( !empty($swicthPoint) ) {
        $directBus = 'There are no Direct Buses available for your Search. You have to switch a Bus.';
        $directBus  = rtrim($directBus, '.');
        $directBus .= ' at <span style="color: orange;">' . $swicthPoint . '</span>.';
    }
}

if ( empty($results) ) {
    $emptyResults = 'There are no Bus Route Details available for your Search.<br />Please refine your Search.';
}
?>
<div id="bus_route_details">
    <div class="table-responsive">
    <p class="direct-bus"><?=$directBus?></p>
    <?php
    if ( !empty($results) ) {
        echo "<p>Source: <span style='color: blue;'>$source</span><br />";
        echo "   Destination: <span style='color: green;'>$destination</span></p>";
        echo '<table class="table table-striped">';
        echo '<tr>';
        echo '<th>Route No</th>';
        echo '<th>Source</th>';
        echo '<th>Destination</th>';
        echo '<th>Route Details</th>';
        echo '</tr>';
        foreach ($results as $result) {
            $bus_no = $result->bus_no;
            $route  = $result->route;
            $source = $result->source;
            $destination = $result->destination;
	    if ( empty($route) ) {
		$route = 'NA';
	    }
            echo '<tr>';
            echo '<td>'.$bus_no.'</th>';
            echo '<td>'.$source.'</th>';
            echo '<td>'.$destination.'</th>';
            echo '<td>'.$route.'</th>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        if ( !empty($sourceResults) ) {
	    if ( !empty($swicthPoint) ) {
                echo "<p>Source: <span style='color: blue;'>$source</span><br />";
	        echo "   Intermediate stop: <span style='color: orange;'>$swicthPoint</span></p>";
	    }
            echo '<table class="table table-striped">';
            echo '<tr>';
            echo '<th width="5%">Route No</th>';
            echo '<th width="25%">Source</th>';
            echo '<th width="25%">Destination</th>';
            echo '<th width="40%">Route Details</th>';
            echo '</tr>';
            foreach ($sourceResults as $result) {
                $bus_no = $result->bus_no;
                $route  = $result->route;
                $source = $result->source;
                $sdestination = $result->destination;
                echo '<tr>';
                echo '<td>'.$bus_no.'</th>';
                echo '<td>'.$source.'</th>';
                echo '<td>'.$sdestination.'</th>';
                echo '<td>'.$route.'</th>';
                echo '</tr>';
            }
            echo '</table>';
	}
	echo '<br />';
        if ( !empty($destinationResults) ) {
	    if ( !empty($swicthPoint) ) {
	        echo "<p>Intermediate stop: <span style='color: orange;'>$swicthPoint</span><br />";
	        echo "   Destination: <span style='color: green;'>$destination</span></p>";
	    }
            echo '<table class="table table-striped">';
            echo '<tr>';
            echo '<th width="5%">Route No</th>';
            echo '<th width="25%">Source</th>';
            echo '<th width="25%">Destination</th>';
            echo '<th width="40%">Route Details</th>';
            echo '</tr>';
            foreach ($destinationResults as $result) {
                $bus_no = $result->bus_no;
                $route  = $result->route;
                $source = $result->source;
                $destination = $result->destination;
                echo '<tr>';
                echo '<td>'.$bus_no.'</th>';
                echo '<td>'.$source.'</th>';
                echo '<td>'.$destination.'</th>';
                echo '<td>'.$route.'</th>';
                echo '</tr>';
            }
            echo '</table>';
	}
        if ( empty($results) and empty($sourceResults) and empty($destinationResults) ) {
            echo '<p class="no-results">' . $emptyResults . '</p>';
	}
    }
    ?>
    </div>
</div>
