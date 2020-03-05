<?php

use yii\db\Migration;

/**
 * Class m200303_172210_favoritos
 */
class m200303_172210_favoritos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favoritos', [
            'id' => $this->bigPrimaryKey(),
            'libro_id' => $this->bigInteger(),
            'lector_id' => $this->bigInteger(),
        ]);

        $this->addForeignKey(
            'fk_favoritos_lectores',
            'favoritos',
            'lector_id',
            'lectores',
            'id'
        );

        $this->addForeignKey(
            'fk_favoritos_libros',
            'favoritos',
            'libro_id',
            'libros',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_favoritos_libros', 'favoritos');
        $this->dropForeignKey('fk_favoritos_libros', 'favoritos');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200303_172210_favoritos cannot be reverted.\n";

        return false;
    }
    */
}
