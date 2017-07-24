<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employer".
 *
 * @property integer $id
 * @property string $FIO
 * @property string $Position
 * @property integer $Chief
 * @property integer $BestEmployer
 *
 */
class Employer extends \yii\db\ActiveRecord
{

    /**
     * array for employers id
     */
    public static $data = array();

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FIO'], 'string', 'max' => 50],
            [['Position'], 'string', 'max' => 30],
            [['Chief'], 'integer'],
            [['BestEmployer'], 'integer', 'max' => 1, 'min' => 0],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FIO' => 'ФИО',
            'Position' => 'Должность',
            'Chief' => 'Начальник',
            'BestEmployer' => 'Лучший сотрудник',
        ];
    }

    /**
     * Get list of chiefs for DropDownList
     *
     * @return array
     */
    public function getParentsList()
    {
        $findName = User::findIdentity(Yii::$app->user->id);
        $findEmployer = Employer::findOne(['id' => $findName->employer]);
        Employer::findEmployers($findEmployer->id);
        $query = Employer::find()->where(['id' => Employer::$data]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Chief', $this->Chief]);

        return ArrayHelper::map($dataProvider->models, 'id', 'FIO');
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get chief name
     *
     * @param integer $chief
     *
     * @return string
     */
    public static function getParentName($chief)
    {
        $param = Employer::findOne($chief);
        return $param->FIO;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Employer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Chief', $this->Chief]);

        return $dataProvider;
    }

    /**
     * Recursive function for find director employers
     *
     * @param integer $ParentID
     *
     */
    public function findEmployers($ParentID)
    {

        $sSQL = "SELECT id,FIO,Position,Chief,BestEmployer FROM Employer WHERE Chief=" . $ParentID;
        $result = new SqlDataProvider(['sql' => $sSQL]);
        $command = Yii::$app->db->createCommand($sSQL);
        $array = $command->query();
        if ($result->count > 0) {
            while (($row = $array->read()) !== false) {
                $ID1 = $row["id"];
                Employer::$data[] = $row["id"];
                Employer::findEmployers($ID1);
            }
        }

    }

    /**
     * Build tree
     *
     * @param integer $id
     *
     * @return ActiveDataProvider
     */
    public function findTree($id)
    {
        $arr = array();
        //текущий элемент
        $sSQL = "SELECT id,FIO,Chief FROM Employer WHERE id=$id";
        $command = Yii::$app->db->createCommand($sSQL);
        $array = $command->query();
        $row = $array->read();

        //глубина вложенности
        while ($row["Chief"] != 0) {
            $sSQL = "SELECT id,FIO,Chief FROM Employer WHERE id=" . $row["Chief"];
            $command = Yii::$app->db->createCommand($sSQL);
            $array = $command->query();
            $row = $array->read();
            $arr[] = $row["id"];
        }
        sort($arr);
        //до выбранного элемента
        $first = Employer::find()->where('id<' . $id)->andWhere('Chief=0');
        //родительские элементы
        $second = Employer::find()->where(['id' => $arr]);
        //текущий элемент
        $third = Employer::find()->where(['id' => $id]);
        //дочерние элементы
        $fourth = Employer::find()->where(['Chief' => $id]);
        //после выбранного id
        $fifth = Employer::find()->where('id>' . $id)->andWhere('Chief=0');
        $u = $first->union($second)->union($third)->union($fourth)->union($fifth);

        $dataProvider = new ActiveDataProvider([
            'query' => $u,
        ]);

        return $dataProvider;
    }

    /**
     * SQL querry for filling data base 'Employer'
     *
     */
    public function SQL()
    {
        $fam = array('Иванов', 'Васильев', 'Петров', 'Смирнов', 'Соколов', 'Попов', 'Алексеев',
            'Павлов', 'Егоров', 'Федоров', 'Волков', 'Лебедев', 'Яковлев', 'Андропов', 'Есенин');
        $imya = array('Иван', 'Александр', 'Павел', 'Дмитрий', 'Николай', 'Алексей', 'Константин',
            'Егор', 'Федор', 'Василий', 'Антон', 'Сергей', 'Артем', 'Евгений', 'Георгий');
        $otch = array('Иванович', 'Петрович', 'Сидорович', 'Ильич', 'Павлович', 'Сергеевич', 'Анатольевич',
            'Александрович', 'Егорович', 'Николаевич', 'Владимирович', 'Олегович', 'Георгиевич', 'Евгениевич', 'Константинович');
        $pos = array('Директор', 'Начальник', 'Бухгалтер', 'Рабочий');
        $n = 0;
        $m = 1;
        for ($i = 0; $i < 15; $i++) {
            for ($j = 0; $j < 15; $j++) {
                for ($k = 0; $k < 15; $k++) {
                    if ($n == 4) $n = 0;
                    if ($n == 0) $p = rand(1, 3);
                    if ($n == 0) {
                        $sSQL = "INSERT INTO Employer(id,FIO,Position,Chief,BestEmployer) VALUES
                    ($m,'$fam[$i] $imya[$j] $otch[$k]','$pos[$n]',NULL,0)";
                    } else if ($n == $p)
                        $sSQL = "INSERT INTO Employer(id,FIO,Position,Chief,BestEmployer) VALUES
                    ($m,'$fam[$i] $imya[$j] $otch[$k]','$pos[$n]',$m-1,1)";
                    else
                        $sSQL = "INSERT INTO Employer(id,FIO,Position,Chief,BestEmployer) VALUES
                    ($m,'$fam[$i] $imya[$j] $otch[$k]','$pos[$n]',$m-1,0)";
                    $command = Yii::$app->db->createCommand($sSQL);
                    $command->query();
                    $n++;
                    $m++;
                }
            }
        }

    }

    /**
     * Recursive function for choosing best employer
     *
     * @param integer $ParentID
     * @param integer $id
     *
     */
    public function ChooseBestEmployer($ParentID, $id)
    {

        $sSQL = "SELECT id,FIO,Position,Chief,BestEmployer FROM Employer WHERE Chief=" . $ParentID;
        $result = new SqlDataProvider(['sql' => $sSQL]);
        $command = Yii::$app->db->createCommand($sSQL);
        $array = $command->query();
        if ($result->count > 0) {
            while (($row = $array->read()) !== false) {
                $ID1 = $row["id"];
                if ($ID1 == $id) {
                    $sSQL = "UPDATE Employer SET BestEmployer = 1 WHERE id =$ID1";
                    $command = Yii::$app->db->createCommand($sSQL);
                    $command->query();
                } else {
                    $sSQL = "UPDATE Employer SET BestEmployer = 0 WHERE id =$ID1";
                    $command = Yii::$app->db->createCommand($sSQL);
                    $command->query();
                }
                Employer::ChooseBestEmployer($ID1, $id);
            }
        }

    }

    /**
     * Set best employer in your department
     *
     * @param integer $id
     *
     * @return ArrayDataProvider
     */
    public function setBestEmployer($id)
    {
        $findName = User::findIdentity(Yii::$app->user->id);
        $findEmployer = Employer::findOne(['id' => $findName->employer]);
        Employer::ChooseBestEmployer($findEmployer->id, $id);
        $dataProvider = Employer::employerList();

        return $dataProvider;

    }

    /**
     * Find all best employers
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function findBest($params)
    {
        $query = Employer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;

        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere([
            'BestEmployer' => '1',
        ]);

        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Chief', $this->Chief]);


        return $dataProvider;
    }

    /**
     * Find director employers
     *
     * @return ArrayDataProvider
     */
    public function employerList()
    {
        $findName = User::findIdentity(Yii::$app->user->id);
        $findEmployer = Employer::findOne(['id' => $findName->employer]);
        Employer::findEmployers($findEmployer->id);
        $data1 = Employer::$data;
        $query = Employer::find()->where(['id' => $data1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Chief', $this->Chief]);


        return $dataProvider;
    }

}
