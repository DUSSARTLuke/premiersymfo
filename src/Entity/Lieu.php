<?php
namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=60)
   */
  private $nom;

  /**
   * @ORM\Column(type="string", length=60)
   */
  private $ville;

  /**
   * @ORM\OneToMany(targetEntity="Employe", mappedBy="lieu")
   */
  private $lesEmployes;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNom(): ?string
  {
    return $this->nom;
  }

  public function setNom(string $nom): self
  {
    $this->nom = $nom;

    return $this;
  }

  public function getVille(): ?string
  {
    return $this->ville;
  }

  public function setVille(string $ville): self
  {
    $this->ville = $ville;

    return $this;
  }
  
  function getLesEmployes()
  {
    return $this->lesEmployes;
  }


}
