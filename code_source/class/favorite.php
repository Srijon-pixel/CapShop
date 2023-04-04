<?php

/**
 * Classe container favorite
 */
class EFavorite
{

    /**
     * Constructeur permettant de créer une nouvelle casquette avec les valeur en paramètres :
     * @param integer $InIdFavorite L'identifiant du modèle de la casquette en favori
     * @param integer $InIdUser L'identifiant de l'utilisateur
     * @param double $InIdCap L'identifiant de la casquette
     */
    public function __construct($InIdFavorite, $InIdUser, $InIdCap)
    {
       
        $this->id_favorite = $InIdFavorite;
        $this->id_user = $InIdUser;
        $this->id_cap = $InIdCap;

    }



    /**
     * @var integer identifiant du modèle de la casquette en favori
     */
    public $id_favorite;

    /**
     * @var integer identifiant de l'utilisateur
     */
    public $id_user;

    /**
     * @var integer identifiant de la casquette
     */
    public $id_cap;


}
?>