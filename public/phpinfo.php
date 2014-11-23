<?php

function timezone_options()
{
	$zones = array(
		'Africa', 'America', 'Antarctica', 'Arctic', 'Asia',
		'Atlantatic', 'Australia', 'Europe', 'Indian', 'Pacific'
	);

	$list = timezone_identifiers_list();
	foreach ($list as $zone) {
		list($zone, $country) = explode('/', $zone);
		if (in_array($zone, $zones) && isset($country) != '') {
			$countryStr = str_replace('_', ' ', $country);
			$locations[$zone][$zone.'/'.$country] = $countryStr;
		}
	}

	return $locations;
}

var_dump(timezone_options());