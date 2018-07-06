<?php

namespace AdminBundle\Entity;

/**
 * Images
 */
class Images
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var int
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Bloc" )
     * @ORM\JoinColumn(name="bloc", referencedColumnName="id")
     */
    private $bloc;
    
    /**
     * @var string
     */
    private $type;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Images
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param integer $description
     *
     * @return Images
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return int
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set bloc
     *
     * @param integer $bloc
     *
     * @return Images
     */
    public function setBloc($bloc)
    {
        $this->bloc = $bloc;

        return $this;
    }

    /**
     * Get bloc
     *
     * @return int
     */
    public function getBloc()
    {
        return $this->bloc;
    }
    /**
     * Set type
     *
     * @param string $type
     *
     * @return Images
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

