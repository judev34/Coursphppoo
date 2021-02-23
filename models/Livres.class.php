<?php

class Livre {

    private $_id;
    private $_titre;
    private $_nbPages;
    private $_image;

    

    public function __construct($id, $titre, $nbPages, $image)
    {
        $this->_id = $id;
        $this->_titre = $titre;
        $this->_nbPages = $nbPages;
        $this->_image = $image;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getTitre()
    {
        return $this->_titre;
    }

    public function setTitre($titre)
    {
        $this->_titre = $titre;
    }

    public function getNbPages()
    {
        return $this->_nbPages;
    }

    public function setNbPages($nbPages)
    {
        $this->_nbPages = $nbPages;
    }

    public function getImage()
    {
        return $this->_image;
    }

    public function setImage($image)
    {
        $this->_image = $image;
    }

}

?>