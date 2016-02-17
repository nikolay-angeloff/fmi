<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $email
 * @property string $password
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username', 'email', 'password'], 'required'],
            [['first_name', 'last_name', 'username', 'email', 'password'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetAttribute' => ['username'], 'message' => 'The User Name is already taken.'],
        	[['email'], 'unique', 'targetAttribute' => ['email'], 'message' => 'The email is already taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
    
    public function findByUsername($username) {
    	$model = Admin::findOne(['username' => $username]);
    	if($model == null) {
    		$model = Admin::findOne(['email' => $username]);
    	}
    	return $model;
    }
    
    public function validatePassword($username, $password) {
    	$model = Admin::findOne(['username' => $username]);
    	if($model == null) {
    		$model = Admin::findOne(['email' => $username]);
    	}
    	
    	if(md5($password) == $model->password) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
		return static::findOne($id);	
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.'); 	
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
		return $this->getPrimaryKey(); 	
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
//     	if(defined($this->$authKey)) {
// 			return $this->$authKey;  	
//     	}
    	return null;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
		return $this->getAuthKey() === $authKey;	
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
    	$this->$authKey = Security::generateRandomKey();
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
    	$this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
    	$this->password_reset_token = null;
    }
    
}
