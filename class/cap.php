<?php

/**
 * Classe container budget
 */
class ECap
{

    /**
     * Constructeur permettant de créer un nouveau budget
     * @param integer $InIdBudget L'identifiant du budget
     * @param string $InNom le nom du budget
     * @param integer $InMontant le montant du budget
     */
    public function __construct($InIdCap, $InIdModel, $InPrice, $InIdDescription, $InQuantity, $InNomModel, $InNomMarque, $InActive)
    {
       
        $this->id_cap = $InIdCap;
        $this->id_model = $InIdModel;
        $this->price = $InPrice;
        $this->description = $InIdDescription;
        $this->quantity = $InQuantity;
        $this->nomModel = $InNomModel;
        $this->nomMarque = $InNomMarque;
        $this->active = $InActive;

    }



    /**
     * @var integer L'identifiant du budget
     */
    public $id_cap;
    /**
     * @var string nom du budget
     */
    public $id_model;
    /**
     * @var double montant de la transaction
     */
    public $price;
    public $description;
    public $quantity;
    public $nomModel;
    public $nomMarque;
    public $active;

}
?>