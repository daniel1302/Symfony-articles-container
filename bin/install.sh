#!/bin/bash

echo "Instalacja ...";
composer update;

echo "Nadaje uprawnienia";
chmod 777 ./var/cache -R;
echo "."
chmod 777 ./var/logs -R;
echo "."
chmod 777 ./var/sessions -R
echo "."
echo "\nKoniec"
