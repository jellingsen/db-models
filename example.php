<?php

/**
 * Models Plugin
 * Add this to a view in your template
 */

require(MODELS_PATH . 'Options.php');
$opts = new Options();
$all_opts = $opts->find()->limit(3)->all();
$opt1 = $opts->findByPk(1);
echo "Primary Key 1: ".$opt1->option_name." => ".$opt1->option_value."<br>";
foreach($all_opts as $opt)
{
	echo $opt->option_name.'<br>';
}

?>