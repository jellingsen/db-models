<?php

/**
 * Models Plugin Example
 * Add this to a view in your template
 */

// Require the model file
require(MODELS_PATH . 'Options.php');

// Find Example with cache (returns array of objects)
$all_opts = Options::find()->cache('cacheIdentifier')->all();

// Find Example with select
$three_opts = Options::find()->limit(3)->orderBy('option_id DESC')->all();

// FindByPk Example (returns Object)
$opt1 = Options::findByPk(1);

// Print out the record with Pk = 1
echo '<h2>Row found by Primary Key</h2>';
echo "Primary Key 1: ".$opt1->option_name." => ".$opt1->option_value."<br>";

// Print out the three first rows in Options
echo '<h2>Three last rows with select</h2>';
foreach($three_opts as $opt)
{
	echo $opt->option_name.'<br>';
}
// Print all rows in Options (cached)
echo '<h2>All rows (Cached)</h2>';
foreach($all_opts as $opt)
{
	echo $opt->option_name.'<br>';
}

?>