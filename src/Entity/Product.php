<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="product", schema="catalog")
 */
class Product
{

    private static $thingsYouCanLift = [
        'Freight Agent' => 44,
        'Safety Engineer' => 93,
        'Civil Engineer' => 33,
        'Carver' => 37,
        'Athletic Trainer' => 62,
        'Irradiated-Fuel Handler' => 96,
        'Legal Secretary' => 9
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Serializer\Groups({"Default"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="The field can not be empty!")
     */
    private $price;

    /**
     * @Serializer\Groups({"Default"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="The field can not be empty!")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function getId() {
        return $this->id;
    }

    /**
     *  @ORM\PrePersist
     */
    public function setCreatedAt() {
        $this->createdAt = new \DateTime('now');
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public static function getThingsYouCanLiftChoices() {
        $things = array_keys(self::$thingsYouCanLift);
        $choices = [];

        foreach ($things as $thingKey) {
            $choices[$thingKey] = $thingKey;
        }

        return $choices;
    }

}