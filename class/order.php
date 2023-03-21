<?php

/**
 * Classe container budget
 */
class EOrder
{

    /**
     * Constructeur permettant de créer un nouveau budget
     * @param integer $InIdBudget L'identifiant du budget
     * @param string $InNom le nom du budget
     * @param integer $InMontant le montant du budget
     */
    public function __construct($InIdOrder, $InIsConfirmed, $InOrderDate, $InIdUser)
    {

        $this->id_order = $InIdOrder;
        $this->is_confirmed = $InIsConfirmed;
        $this->order_date = $InOrderDate;
        $this->id_user = $InIdUser;
    }



    /**
     * @var integer L'identifiant du budget
     */
    public $id_order;
    /**
     * @var string nom du budget
     */
    public $is_confirmed;
    /**
     * @var double montant de la transaction
     */
    public $order_date;

    /**
     * @var double montant de la transaction
     */
    public $id_user;
}
?>