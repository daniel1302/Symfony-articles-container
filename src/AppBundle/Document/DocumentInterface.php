<?php
namespace AppBundle\Document;


interface DocumentInterface
{
    public function setId(string $id);
    public function getId(): ?string;
}