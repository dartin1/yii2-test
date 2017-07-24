<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "OtherInform".
 *
 * @property integer $id
 * @property string $Telephone
 * @property string $Skype
 * @property string $Adress
 * @property integer $employer
 *
 * @property User $employer0
 */
class OtherInform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OtherInform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //  [['employer'], 'required'],
            [['employer'], 'integer'],
            [['Telephone'], 'string', 'max' => 20],
            [['Skype'], 'string', 'max' => 30],
            [['Adress'], 'string', 'max' => 50],
            [['employer'], 'unique'],
            [['employer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employer' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Telephone' => 'Телефон',
            'Skype' => 'Skype',
            'Adress' => 'Адрес',
            'employer' => 'Сотрудник',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer0()
    {
        return $this->hasOne(User::className(), ['id' => 'employer']);
    }

    /**
     * Set user other information
     *
     * @return User|null the saved model or null if saving fails
     */
    public function setNewInform()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new OtherInform();
        $user->Telephone = $this->Telephone;
        $user->Skype = $this->Skype;
        $user->Adress = $this->Adress;
        $user->employer = Yii::$app->user->id;

        $sSQL = "UPDATE OtherInform SET Telephone = '$this->Telephone', Skype = '$this->Skype',
Adress = '$this->Adress', employer = '$user->employer' WHERE employer =" . Yii::$app->user->id;

        $command = Yii::$app->db->createCommand($sSQL);
        $command->query();
        $user->save();
    }


}
