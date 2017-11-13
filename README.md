Edebex test
==========

A Symfony project created on November 13, 2017, 10:04 am.

Usage :
Un fichier de test contenant les examples proposés dans le mail ainsi qu'un évènement interférant avec le calendrier est disponible
$ phpunit tests/AppBundle/Service/BusinessHoursManagementTest.php

Notes :

J'ai utilisé un package de gestion des heures d'ouverture (https://github.com/spatie/opening-hours), que j'ai étendu dans le fichier: src/AppBundle/CustomOpeningHours
J'ai utilisé le package https://github.com/u01jmg3/ics-parser pour la lecture du calendrier

L'outil est géré sous la forme d'un service
