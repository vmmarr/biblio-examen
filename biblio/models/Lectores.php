<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lectores".
 *
 * @property int $id
 * @property string $numero
 * @property string $nombre
 * @property string|null $direccion
 * @property string|null $poblacion
 * @property string|null $provincia
 * @property float|null $cod_postal
 * @property string|null $fecha_nac
 * @property string $created_at
 * 
 * @property Prestamos[] $prestamos
 * @property Libros[] $libros
 */
class Lectores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lectores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero', 'nombre', 'poblacion', 'provincia'], 'required'],
            [['cod_postal'], 'number'],
            [['fecha_nac', 'created_at'], 'safe'],
            [['numero'], 'string', 'max' => 9],
            [['nombre', 'direccion', 'poblacion', 'provincia'], 'string', 'max' => 255],
            [['numero'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Numero',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'poblacion' => 'Poblacion',
            'provincia' => 'Provincia',
            'cod_postal' => 'Cod Postal',
            'fecha_nac' => 'Fecha Nac',
            'created_at' => 'Created At',
        ];
    }

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getPrestamos() 
    {
        return $this->hasMany(Prestamos::className(), ['lector_id' => 'id'])->inverseOf('lector');
    }

    public function getLibros()
    {
        return $this->hasMany(Libros::class, ['id' => 'libro_id'])->via('prestamos');
    }

    public function getPrestados()
    {
        return $this->getLibros()
            ->via('prestamos', function ($query) {
                $query->andWhere(['devolucion' => null]);
            });
    }

    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['lector_id' => 'id']);
    }
}
