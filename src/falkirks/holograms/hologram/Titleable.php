<?php
namespace falkirks\holograms\hologram;

/**
 * Holograms implementing this interface have
 * a concept of a "title". This means that their
 * title can be changed through the console.
 *
 * Interface Titleable
 */
interface Titleable{
    public function setTitle($title);
    public function getTitle();
}