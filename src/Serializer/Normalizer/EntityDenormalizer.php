<?php

namespace App\Serializer\Normalizer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class EntityDenormalizer implements DenormalizerInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed       $data    Data to restore
     * @param string      $type   The expected class to instantiate
     * @param string|null $format  Format the given data was extracted from
     * @param array       $context Options available to the denormalizer
     *
     * @return mixed
     *
     */
    // ! $data : l'id récupéré dans le json, $type: FQCN de la classe attendue
    public function denormalize($data, string $type, string $format = null, array $context = []) {
        return $this->entityManager->find($type, $data);
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed       $data   Data to denormalize from
     * @param string      $type   The class to which the data should be denormalized
     * @param string|null $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null) {

        if(strpos($type, "App\Entity", 0) === 0 && is_int($data)) {
            return true;
        };
    }
}
