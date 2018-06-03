<?php
return [
    '<candidate:(candidate|kandydat)>/<conversation:(conversation|wiadomosci)>/<id:\d+>/<key:[a-f0-9]{32}>' => 'candidate/conversation',

    '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
];