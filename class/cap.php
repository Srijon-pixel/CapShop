<?php

/**
 * Classe container cap
 */
class ECap
{

    /**
     * Constructeur permettant de créer une nouvelle casquette avec les valeur en paramètres :
     * @param integer $InIdCap L'identifiant de la casquette
     * @param integer $InIdModel L'identifiant du modèle de la casquette
     * @param double $InPrice Le prix de la casquette
     * @param string $InIdDescription La description de la casquette
     * @param integer $InQuantity Indique la quantité de casquette que l'on possède dans la base de donnée
     * @param string $InNomModel Le modèle de la casquette
     * @param string $InNomMarque La marque de la casquette
     * @param bool $InActive Indique si la casquette existe ou non aux yeux des utilisateurs
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
     * @var integer identifiant de la casquette
     */
    public $id_cap;

    /**
     * @var integer identifiant du modèle de la casquette
     */
    public $id_model;

    /**
     * @var double montant de la casquette
     */
    public $price;

    /**
     * @var string description de la casquette
     */
    public $description;

    /**
     * @var int quantité de casquette que l'on possède dans la base de donnée
     */
    public $quantity;

    /**
     * @var string modèle de la casquette
     */
    public $nomModel;

    /**
     * @var string marque de la casquette
     */
    public $nomMarque;

    /**
     * @var bool indique si la casquette existe ou non aux yeux des utilisateurs
     */
    public $active;

}
?>