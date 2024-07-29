<?php

function view(string $filename, array $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once __DIR__ . '/../includes/' . $filename . '.php';
}
