<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "t_c4h_usuario".
 *
 * @property int $id_usuario
 * @property string $nm_login
 * @property string|null $nm_email
 * @property string $vl_senha
 * @property int|null $st_admin
 * @property int|null $st_doador
 * @property int|null $st_assinante
 * @property int|null $st_colaborador
 * @property int|null $st_voluntario
 * @property string|null $nm_razao_social
 * @property string|null $nm_nome
 * @property string|null $vl_cpf
 * @property string|null $vl_cnpj
 * @property string|null $dt_nascimento
 * @property string|null $vl_url
 * @property string|null $dt_criacao
 * @property string|null $fl_foto
 *
 * @property TC4hAssinatura[] $tC4hAssinaturas
 * @property TC4hBlogEntry[] $tC4hBlogEntries
 * @property TC4hDoacao[] $tC4hDoacaos
 * @property TC4hLogradouro[] $tC4hLogradouros
 * @property TC4hRedesSociai[] $tC4hRedesSociais
 * @property TC4hTelefone[] $tC4hTelefones
 * @property TC4hToken[] $tC4hTokens
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_c4h_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nm_login', 'vl_senha'], 'required'],
            [['st_admin', 'st_doador', 'st_assinante', 'st_colaborador', 'st_voluntario'], 'integer'],
            [['dt_nascimento', 'dt_criacao'], 'safe'],
            [['fl_foto'], 'string'],
            [['nm_login'], 'string', 'max' => 30],
            [['nm_email', 'vl_senha', 'nm_razao_social', 'nm_nome', 'vl_url'], 'string', 'max' => 100],
            [['vl_cpf'], 'string', 'max' => 11],
            [['vl_cnpj'], 'string', 'max' => 14],
            [['nm_login'], 'unique'],
            [['vl_cpf'], 'unique'],
            [['vl_cnpj'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'nm_login' => 'Nm Login',
            'nm_email' => 'Nm Email',
            'vl_senha' => 'Vl Senha',
            'st_admin' => 'St Admin',
            'st_doador' => 'St Doador',
            'st_assinante' => 'St Assinante',
            'st_colaborador' => 'St Colaborador',
            'st_voluntario' => 'St Voluntario',
            'nm_razao_social' => 'Nm Razao Social',
            'nm_nome' => 'Nm Nome',
            'vl_cpf' => 'Vl Cpf',
            'vl_cnpj' => 'Vl Cnpj',
            'dt_nascimento' => 'Dt Nascimento',
            'vl_url' => 'Vl Url',
            'dt_criacao' => 'Dt Criacao',
            'fl_foto' => 'Fl Foto',
        ];
    }

    /**
     * @throws Exception
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->vl_senha = Yii::$app->getSecurity()->generatePasswordHash($this->vl_senha);
            $this->dt_criacao = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->vl_senha = '';

        parent::afterFind();
    }

    /**
     * Gets query for [[TC4hAssinaturas]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hAssinaturaQuery
     */
    public function getTC4hAssinaturas()
    {
        return $this->hasMany(TC4hAssinatura::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hBlogEntries]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hBlogEntryQuery
     */
    public function getTC4hBlogEntries()
    {
        return $this->hasMany(TC4hBlogEntry::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hDoacaos]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hDoacaoQuery
     */
    public function getTC4hDoacaos()
    {
        return $this->hasMany(TC4hDoacao::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hLogradouros]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hLogradouroQuery
     */
    public function getTC4hLogradouros()
    {
        return $this->hasMany(TC4hLogradouro::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hRedesSociais]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hRedesSociaiQuery
     */
    public function getTC4hRedesSociais()
    {
        return $this->hasMany(TC4hRedesSociai::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hTelefones]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hTelefoneQuery
     */
    public function getTC4hTelefones()
    {
        return $this->hasMany(TC4hTelefone::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TC4hTokens]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TC4hTokenQuery
     */
    public function getTC4hTokens()
    {
        return $this->hasMany(TC4hToken::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UsuarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UsuarioQuery(get_called_class());
    }
}
