# db-models
Wordpress Database Model Plugin

A Yii2-like model handler for database connections in WordPress

| Function | Description |
| --- | --- |
| `$model = new TableName;` | Initiates a model instance |
| `$model->find()` | Initiator for SELECT queries |
| `$model->find()->where(['field','value'])` | Adds a where clause to the query |
| `$model->find()->limit(1)` | Adds a limit to the query |
| `$model->find()->one()` | Returns one row |
| `$model->find()->all()` | Returns several rows |
