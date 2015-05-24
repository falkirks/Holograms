<?php
/**
 * Holograms implementing this interface have
 * a concept of "text". This means that their
 * text content can be changed through the console.
 *
 * Interface Textable
 */
interface Textable{
    public function setText($text);
    public function getText();
}