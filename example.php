<?php

/**
 * Models Plugin Example
 * Add this to a view in your template
 */

// Require the model file
require(MODELS_PATH . 'Options.php');

// Find Example (returns array of objects)
$all_opts = Options::find()->limit(3)->all();

// FindByPk Example (returns Object)
$opt1 = Options::findByPk(1);

// Print out the record with Pk = 1
echo "Primary Key 1: ".$opt1->option_name." => ".$opt1->option_value."<br>";

// Print out the three first rows in Options
foreach($all_opts as $opt)
{
	echo $opt->option_name.'<br>';
}

?>