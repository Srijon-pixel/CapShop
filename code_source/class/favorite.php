<?php

/**
 * Classe container favori
 */
class EFavorite
{

    /**
     * Constructeur permettant de créer une nouvelle casquette avec les valeur en paramètres :
     * @param integer $InIdCap L'identifiant de la casquette
     * @param integer $InIdModel L'identifiant du modèle de la casquette
     * @param double $InPrice Le prix de la casquette
     */
    public function __construct($InIdFavorite, $InIdUser, $InIdCap)
    {
       
        $this->id_favorite = $InIdFavorite;
        $this->id_user = $InIdUser;
        $this->id_cap = $InIdCap;

    }



    /**
     * @var integer identifiant de la casquette
     */
    public $id_favorite;

    /**
     * @var integer identifiant du modèle de la casquette
     */
    public $id_user;

    /**
     * @var double montant de la casquette
     */
    public $id_cap;


}
?>