<?php
namespace AppBundle\Model;

class Voivodeship 
{
    const   DOLNOSLASKIE = 1,
            KUJAWSKO_POMORSKIE = 2,
            LUBELSKIE = 3,
            LUBUSKIE = 4,
            LODZKIE = 5,
            MALOPOLSKIE = 6,
            MAZOWIECKIE = 7,
            OPOLSKIE = 8,
            PODKARPACKIE = 9,
            PODLASKIE = 10,
            POMORSKIE = 11,
            SLASKIE = 12,
            SWIETOKRZYSKIE = 13,
            WARMINSKO_MAZURSKIE = 14,
            WIELKOPOLSKIE = 15,
            ZACHODNIOPOMORSKIE = 16;
    
    public static $names = [
        self::DOLNOSLASKIE          => 'dolnośląskie',
        self::KUJAWSKO_POMORSKIE    => 'kujawsko-pomorskie',
        self::LUBELSKIE             => 'lubelskie',
        self::LUBUSKIE              => 'lubuskie',
        self::LODZKIE               => 'łódzkie',
        self::MALOPOLSKIE           => 'małopolskie',
        self::MAZOWIECKIE           => 'mazowieckie',
        self::OPOLSKIE              => 'opolskie',
        self::PODKARPACKIE          => 'podkarpackie',
        self::PODLASKIE             => 'podlaskie',
        self::POMORSKIE             => 'pomorskie',
        self::SLASKIE               => 'śląskie',
        self::SWIETOKRZYSKIE        => 'świętokrzyskie',
        self::WARMINSKO_MAZURSKIE   => 'warmińsko-mazurskie',
        self::WIELKOPOLSKIE         => 'wielkopolskie',
        self::ZACHODNIOPOMORSKIE    => 'zachodniopomorskie'
    ];
}
