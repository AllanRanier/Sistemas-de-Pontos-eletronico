<?php
loadModel('User');

class Login extends Model{

    public function validate(){
        $erros = [];
        if(!$this->email){
            $erros['email'] = 'E-mail é um compo obrigatório.';
        }
        if(!$this->password){
            $erros['password'] = 'Por favor, informe a senha.';
        }

        if(count($erros) > 0){
            throw new ValidationException($erros);
        }
    }
    public function checkLogin(){
        $this->validate();
        $user = User::getOne(['email' => $this->email]);
        if($user){
            if($user->end_date){
                throw new AppException('Usuário está desligado da empresa.');
            }
            if(password_verify($this->password, $user->password)){
                return $user;
            }
        }
        throw new AppException('Usuário e Senha inválidos.');
    }
}