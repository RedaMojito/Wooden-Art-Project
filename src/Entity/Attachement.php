<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\AttachementRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @ORM\Table(name="attachements")
 * @ORM\Entity(repositoryClass=AttachementRepository::class)
 * @Vich\Uploadable
 */
class Attachement 
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"attachement"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"attachement"})
     */
    private $image;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="attachements", fileNameProperty="image")
     * 
     * @var File|null
     * @Groups({"attachement"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"attachement"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="attachements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

      /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

   
    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

   public function serializer(){
        $encoder = new JsonEncoder();
        
         $normalizer = new ObjectNormalizer();
         //$attach = $normalizer->normalize($this, null, ['groups' => 'attachement']);
       $serializer = new Serializer([$normalizer], [$encoder]);
    return $serializer->serialize($this, 'json', [
        'circular_reference_handler' => function () {
            return $this->getId();
        }
    ]) ;
    }
}
