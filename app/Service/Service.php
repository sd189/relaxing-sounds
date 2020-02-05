<?php

namespace App\Service;

class Service
{
    /**
     * @param $totalRecord
     * @param $page
     * @param $limit
     * @param int $paginate
     *
     * @return array
     */
    public function createPaginationMeta($totalRecord, $page, $limit, $paginate = 1)
    {
        if (0 == $limit) {
            $limit = $totalRecord;
        }

        // Make sure that we won't divide by zero
        $limit = (int) $limit == 0 ? $limit = 25 : $limit;

        $result = [
            'total' => (int) $totalRecord
        ];

        if ($paginate) {
            $result['perPage'] = (int) $limit;
            $result['currentPage'] = (int) $page;
            $result['lastPage'] = ceil($totalRecord / $limit);
        }

        return $result;
    }
}
