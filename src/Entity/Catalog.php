<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog", schema="catalog")
 */
class Catalog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $id_cat;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, nullable=true, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string")
     */
    private $parent_id;

    public function getParentId() {
        return $this->parent_id;
    }

    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
    }

    public function getIdCat() {
        return $this->id_cat;
    }

    public function setIdCat($id_cat) {
        $this->id_cat = $id_cat;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getSlug() {
        return $this->slug;
    }
}