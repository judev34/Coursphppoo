<?php

require_once "models/LivreManager.class.php";

class LivresController{
    private $_livreManager;

    public function __construct()
    {
       
        $this->_livreManager = new LivreManager;
        $this->_livreManager->chargementLivres();
    }

    public function afficherLivres()
    {
        $livres = $this->_livreManager->getLivres();
        require "views/livres.view.php";
    }

    public function afficherUnLivre($id)
    {
        $livre = $this->_livreManager->getLivreById($id);
        require "views/afficherLivre.view.php";
    }

    public function ajoutLivre()
    {
        require "views/ajoutLivre.view.php";
    }

    public function ajoutLivreValidation()
    {
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImageAjoute = $this->ajoutImage($file,$repertoire);
        $this->_livreManager->ajoutLivreBd($_POST['titre'],$_POST['nbPages'],$nomImageAjoute);

        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Ajout réalisé"
        ];

        header('Location: '. URL . "livres");
    }

    private function ajoutImage($file, $dir)
    {
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        if(!file_exists($dir)) mkdir($dir,0777);

            $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
            $random = rand(0,99999);
            $target_file = $dir.$random."_".$file['name'];

        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif") 
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))    
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");  
        else return ($random."_".$file['name']);
    }

    public function modificationLivre($id)
    {
        $livre = $this->_livreManager->getLivreById($id);
        require "views/modifierLivre.view.php";
    }

    public function modificationLivreValidation()
    {
        $imageActuelle = $this->_livreManager->getLivreById($_POST["identifiant"])->getImage();
        $file = $_FILES['image'];

        if ($file['size'] > 0) {
            unlink("public/images/".$imageActuelle);
            $repertoire = "public/images/";
            $nomNouvelleImage = $this->ajoutImage($file, $repertoire); // upload de l'image
        } else {
            $nomNouvelleImage = $imageActuelle;
        }
        $this->_livreManager->modificationLivreBd($_POST["identifiant"],$_POST["titre"],$_POST["nbPages"],$nomNouvelleImage);

        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Modification réalisée"
        ];

        header('Location: '. URL . "livres");
    }

    public function suppressionLivre($id)
    {
        $nomImage = $this->_livreManager->getLivreById($id)->getImage();
        unlink("public/images/".$nomImage);
        $this->_livreManager->suppressionLivreBd($id);

        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Suppression réalisée"
        ];

        header('Location: '. URL . "livres");
    }

}