<?php

function getDataFromJson(string $fileName): array
{
    $jsonData = file_get_contents($fileName);
    $dataArray = json_decode($jsonData, true);

    return $dataArray;
}

function editJson(string $fileName, $newData)
{
    $newJsonData = json_encode($newData, JSON_PRETTY_PRINT);
    file_put_contents($fileName, $newJsonData);

    return true;
}