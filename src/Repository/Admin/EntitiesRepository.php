<?php

namespace App\Repository\Admin;

use Symfony\Component\Finder\Finder;

class EntitiesRepository extends Finder
{
    
    public function getEntities()
    {
        $finder = new Finder();
        $finder->files()->in('./../src/Entity/');
        $entities = [];
        foreach ($finder as $file) {
            $filename = str_replace('.php', '', $file->getRelativePathname());
            array_push($entities, strtolower($filename));
        }
        sort($entities);
        return $entities;
    }
    
}
