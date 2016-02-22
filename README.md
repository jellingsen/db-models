# db-models
Wordpress Database Model Plugin

A Yii2-like model handler for database connections in WordPress

| Function | Description |
| --- | --- |
| `$model = new TableName;` | Initiates a model instance |
| `$model->find()` | Initiator for SELECT queries |
| `$model->find()->where(['field','value'])` | Adds a where clause to the query |
| `$model->find()->cache('unique_identifier')` | Caches the query with WP transient |
| `$model->find()->limit(1)` | Adds a limit to the query |
| `$model->find()->one()` | Returns one row |
| `$model->find()->all()` | Returns several rows |

Example:

<?php

/**
 * Models Plugin Example
 * Add this to a view in your template
 */

// Require the model file
require(MODELS_PATH . 'Options.php');

// Find Example (returns array of objects)
$all_opts = Options::find()->limit(3)->cache('cacheIdentifier')->all();

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
