<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Libros Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favoritos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'libro_id',
        ],
    ]); ?>


</div>