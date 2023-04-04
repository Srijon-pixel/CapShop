<?php

/**
 * Classe container order
 */
class EOrder
{

    /**
     * Constructeur permettant de créer une nouvelle commande
     * @param integer $InIdOrder L'identifiant de la commande
     * @param bool $InIsConfirmed Indique si la commande a été confirmé ou non par l'utilisateur
     * @param string $InOrderDate Le jour où la commande a été effectué
     * @param integer $InIdUser L'identifiant de l'utilisateur
     */
    public function __construct($InIdOrder, $InIsConfirmed, $InOrderDate, $InIdUser)
    {

        $this->id_order = $InIdOrder;
        $this->is_confirmed = $InIsConfirmed;
        $this->order_date = $InOrderDate;
        $this->id_user = $InIdUser;
    }



    /**
     * @var integer L'identifiant de la commande
     */
    public $id_order;
    /**
     * @var bool Indique si la commande a été confirmé ou non par l'utilisateur
     */
    public $is_confirmed;
    /**
     * @var string jour où la commande a été effectué
     */
    public $order_date;

    /**
     * @var integer identifiant de l'utilisateur
     */
    public $id_user;
}
