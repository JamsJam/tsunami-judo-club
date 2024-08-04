<?php

namespace App\Service;

class PaginateService
{


    public function paginateArray(array $array ,int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage; // Calculate the starting index
        return array_slice($array, $offset, $perPage); // Slice the array to get the required page
    }

    public function countItems($array): int
    {
        return count($array);
    }
}