<?php

namespace CategoriesBundle\DataObject;

use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Type;

/**
 * @AccessType("public_method")
 */
class ParametersDto
{
    /**
     * @Type("string")
     *
     * @var string|null
     **/
    private $slug;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     *
     * @return self
     */
    public function setSlug($slug = null): self
    {
        $this->slug = $slug;

        return $this;
    }
}
