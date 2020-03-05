<?php

use app\models\Lectores;
use yii\db\Migration;
use yii\db\Query;
use yii\db\Schema;

/**
 * Class m200225_172912_create_codpostales.
 */
class m200225_172912_create_codpostales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function sssssafeUp()
    {
        $this->createTable('codpostales', [
            'id' => $this->bigPrimaryKey(),
            'codpostal' => $this->decimal(5)->notNull()->unique(),
            'poblacion_id' => $this->bigInteger(),
        ]);
        $this->createTable('poblaciones', [
            'id' => $this->bigPrimaryKey(),
            'nombre' => $this->string(),
            'provincia_id' => $this->bigInteger(),
        ]);
        $this->createTable('provincias', [
            'id' => $this->bigPrimaryKey(),
            'nombre' => $this->string(),
        ]);
        $this->addForeignKey(
            'fk_codpostales_poblaciones',
            'codpostales',
            'poblacion_id',
            'poblaciones',
            'id'
        );
        $this->addForeignKey(
            'fk_poblaciones_provincias',
            'poblaciones',
            'provincia_id',
            'provincias',
            'id'
        );
        $this->addColumn('lectores', 'codpostal_id', Schema::TYPE_BIGINT);

        foreach (Lectores::find()->each() as $lector) {
            $codpostal = $lector->cod_postal;
            $query = (new Query())
                ->from('codpostales')
                ->where(['codpostal' => $codpostal]);
            if ($query->exists()) {
                $codpostal_id = ($query->one())['id'];
            } else {
                Yii::$app->db->createCommand()->insert('codpostales', [
                    'codpostal' => $codpostal,
                ])->execute();
                $codpostal_id = Yii::$app->db->getLastInsertID();
            }
            $lector->codpostal_id = $codpostal_id;
            $lector->save();
        }

        $this->addForeignKey('fk_lectores_codpostales', 'lectores', 'codpostal_id', 'codpostales', 'id');
        $this->dropColumn('lectores', 'cod_postal');
    }

    /**
     * {@inheritdoc}
     */
    public function ssssssafeDown()
    {
        $this->addColumn('lectores', 'cod_postal', 'NUMERIC(5)');
        $this->execute('UPDATE lectores
                           SET cod_postal = (SELECT codpostal
                                               FROM codpostales
                                              WHERE lectores.codpostal_id = codpostales.id)');
        $this->dropForeignKey('fk_lectores_codpostales', 'lectores');
        $this->dropColumn('lectores', 'codpostal_id');
        $this->dropTable('codpostales');
        $this->dropTable('poblaciones');
        $this->dropTable('provincias');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200225_172912_create_codpostales cannot be reverted.\n";

        return false;
    }
    */
}
