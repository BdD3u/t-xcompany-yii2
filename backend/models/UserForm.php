<?php
namespace backend\models;

use yii\base\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;
use common\models\User;

class UserForm extends Model
{
    public $password;
    public $passwordConfirm;
    public $selectedRoles;

    protected $objUser;
    protected $authManager;
    protected $roles;

    public function __construct(User $objUser, ManagerInterface $auth, array $config = [])
    {
        $this->objUser = $objUser;
        $this->authManager = $auth;

        if(!$this->objUser->isNewRecord) {
            $this->password = $this->passwordConfirm = $this->objUser->password_hash;
            $rolesCollection = $this->authManager->getRolesByUser($this->objUser->id);

            if($rolesCollection) {
                $this->selectedRoles = array_column($rolesCollection, 'name');
            }
        }

        parent::__construct($config);
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'passwordConfirm' => 'Подверждение пароля',
            'selectedRoles' => 'Роль',
        ];

    }

    public function rules()
    {
        return [
            [['password', 'passwordConfirm', 'selectedRoles'], 'required'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['selectedRoles', 'each', 'rule' => ['in', 'range' => array_keys($this->getRolesList())], 'message' => 'Заданные роли не прошли проверку...'],
        ];
    }


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->objUser;
    }

    /**
     * Return list of roles...
     * @return array|null
     */
    public function getRolesList(): ?array
    {
        if(!$this->roles) {
            $this->roles = ArrayHelper::map($this->authManager->getRoles(), 'name', 'name');
        }

        return $this->roles;
    }

    public function load($data, $formName = null)
    {
        return parent::load($data) && $this->objUser->load($data);
    }

    public function save()
    {
        $transaction = \Yii::$app->getDb()->beginTransaction();
        $complete = false;

        try {
            $this->objUser->password_hash = $this->password;

            if($this->objUser->isNewRecord) {
                $this->objUser->generateAuthKey();
            }

            $validate = $this->validate();
            $userSaveCompleted = $this->objUser->save();
            $rewritedRoles = $this->rewriteRoles();
            $complete = $validate && $userSaveCompleted && $rewritedRoles;
            //$complete = $this->validate() && $this->objUser->save() && $this->rewriteRoles();
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        $transaction->commit();
        return $complete;
    }

    protected function rewriteRoles()
    {
        $complete = false;
        if(is_array($this->selectedRoles) && !$this->objUser->isNewRecord) {
            $this->authManager->revokeAll($this->objUser->id);
            foreach($this->selectedRoles as $roleName) {
                $role = $this->authManager->getRole($roleName);
                if($role) {
                    $complete = $this->authManager->assign($role, $this->objUser->id);
                }

                if(!$complete) {
                    throw new Exception('Не удалось установить роль ' . $roleName);
                }
            }
        }
        return $complete;
    }

}