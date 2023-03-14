<?php

/**
 * Classe container budget
 */
class EUser
{

    /**
     * Constructeur permettant de créer un nouveau budget
     * @param integer $InIdBudget L'identifiant du budget
     * @param string $InNom le nom du budget
     * @param integer $InMontant le montant du budget
     */
    public function __construct($InIdUser, $InUsername, $InEmail, $InPassword, $InActif, $InAdmin)
    {

        $this->id_user = $InIdUser;
        $this->username = $InUsername;
        $this->email = $InEmail;
        $this->password = $InPassword;
        $this->actif = $InActif;
        $this->admin = $InAdmin;
    }



    /**
     * @var integer L'identifiant du budget
     */
    public $id_user;
    /**
     * @var string nom du budget
     */
    public $username;
    /**
     * @var double montant de la transaction
     */
    public $email;
    /**
     * @var double montant de la transaction
     */
    public $password;

    /**
     * @var double montant de la transaction
     */
    public $actif;
    /**
     * @var double montant de la transaction
     */
    public $admin;
}
?>