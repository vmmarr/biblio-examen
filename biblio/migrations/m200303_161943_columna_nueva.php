<?php

use yii\db\Migration;

/**
 * Class m200303_161943_columna_nueva
 */
class m200303_161943_columna_nueva extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'lector_id', 'bigserial');

        $this->addForeignKey(
            'fk_usuarios_lectores',
            'usuarios',
            'lector_id',
            'lectores',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_usuarios_lectores', 'usuarios');

        $this->dropColumn('usuarios', 'lector_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200303_161943_columna_nueva cannot be reverted.\n";

        return false;
    }
    */
}
