<?php namespace Album\Entities;

use CodeIgniter\Entity;

class Album extends Entity
{
    public function setArtist(string $artist)
    {
        $this->attributes['artist'] = ucwords($artist);
        return $this;
    }

    public function setTitle(string $title)
    {
        $this->attributes['title'] = ucwords($title);
        return $this;
    }
}