<?php

require_once 'DAO.class.php';
require_once 'Livres.class.php';

class LivreManager extends DAO{
    private $_livres; // Tableau de livres

    public function ajoutLivre($livre){
        $this->_livres[] = $livre;
    }

    public function getLivres(){
        return $this->_livres;
    }

    public function chargementLivres()
    {
        $req = $this->getBdd()->prepare("SELECT * FROM livres");
        $req->execute();
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // print_r($mesLivres);
        // echo '</pre>';
        $req->closeCursor();

        foreach ($mesLivres as $livre) {
            $monLivre = new Livre($livre['id'],$livre['titre'],$livre['nbPages'],$livre['image']);
            $this->ajoutLivre($monLivre);
        }
    }

    public function getLivreById($id)
    {
        // for($i=0; $i < count($this->_livres[$i]); $i++){
        //     if ($this->_livres[$i]->getId() === $id) {
        //         return $this->_livres[$i];
        //     }
        // }
        foreach (($this->_livres) as $livre) {
            if ($livre->getId() === $id) {
                return $livre;
            }
        }
        throw new Exception("Le livre n'existe pas");
        
    }

    public function ajoutLivreBd($titre, $nbPages, $image)
    {
        $req = "
        INSERT INTO livres (titre, nbPages, image) 
        VALUES (:titre, :nbPages, :image)";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":titre",$titre,PDO::PARAM_STR);
        $statement->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
        $statement->bindValue(":image",$image,PDO::PARAM_STR);
        $resultat = $statement->execute();
        $statement->closeCursor();

        if ($resultat > 0 ) {
            $livre = new Livre($this->getBdd()->lastInsertId(),$titre,$nbPages,$image);
            $this->ajoutLivre($livre);
        }
    }

    public function modificationLivreBd($id,$titre,$nbPages,$image)
    {
        $req = '
        UPDATE livres
        SET titre = :titre, nbPages = :nbPages, image = :image 
        WHERE id = :id
        ';

        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        $statement->bindValue(":titre",$titre,PDO::PARAM_STR);
        $statement->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
        $statement->bindValue(":image",$image,PDO::PARAM_STR);
        $resultat = $statement->execute();
        $statement->closeCursor();
        if ($resultat > 0) {
            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setNbPages($nbPages);
            $this->getLivreById($id)->setImage($image);
        }
    }

    public function suppressionLivreBd($id)
    {
        $req = "
        DELETE FROM livres WHERE id = :idLivre
        ";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":idLivre",$id,PDO::PARAM_INT);
        $resultat = $statement->execute();
        $statement->closeCursor();

        if ($resultat > 0) {
            $livre = $this->getLivreById($id);
            unset($livre);
        }
    }


}