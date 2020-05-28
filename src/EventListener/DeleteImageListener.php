<?php

namespace App\EventListener;

use App\Entity\Image;
use App\Service\UploaderHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DeleteImageListener
{
    private $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        
        $entity = $args->getObject();

        if(!$entity instanceof Image) {
            return;
        } else {
            $url = $entity->getUrl();
            $this->uploaderHelper->deleteFile($url);
        }
    }
}