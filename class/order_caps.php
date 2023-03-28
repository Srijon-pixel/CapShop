<?php

/**
 * Classe container order
 */
class EOrderCaps
{

    /**
     * Constructeur permettant de créer une nouvelle commande
     * @param integer $InIdOrder L'identifiant de la commande
     * @param bool $InIsConfirmed Indique si la commande a été confirmé ou non par l'utilisateur
     * @param string $InOrderDate Le jour où la commande a été effectué
     * @param integer $InIdUser L'identifiant de l'utilisateur
     */
    public function __construct($InIdOrderCaps, $InIdOrder, $InIdCap, $InQuantity, $InUnitPrice)
    {
        $this->id_order_caps = $InIdOrderCaps;
        $this->id_order = $InIdOrder;
        $this->id_cap = $InIdCap;
        $this->quantity = $InQuantity;
        $this->unit_price = $InUnitPrice;
    }


    /**
     * @var integer L'identifiant de la commande
     */
    public $id_order_caps;
    /**
     * @var integer L'identifiant de la commande
     */
    public $id_order;
    /**
     * @var integer Indique si la commande a été confirmé ou non par l'utilisateur
     */
    public $id_cap;
    /**
     * @var integer jour où la commande a été effectué
     */
    public $quantity;

    /**
     * @var double identifiant de l'utilisateur
     */
    public $unit_price;
}
