<?php

include 'YouTube.php';
include 'Curl.php';

header('Content-Type: application/json');

$looptoprolletjes = new YouTube('UCjYLJecVacgZKtEWdddsS9A', 'AIzaSyDU81r7KOc77DlCeLICB71RrJCxTKlPy8k');

echo count($looptoprolletjes->asdf());