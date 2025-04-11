<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Pagination extends ResourceCollection
{
    private function getPaginationTemplate($total = 0, $per_page = 15, $current_page = 1, $last_page = 1, $collection = [])
    {
        return [
            'pagination' => [
                'total' => $total,
                'per_page' => $per_page,
                'current_page' => $current_page,
                'last_page' => $last_page,
            ],
            'items' => $collection,
        ];
    }

    public function __construct($resource = null, $view = null, $callback = null)
    {
        parent::__construct($resource);

        if ($callback !== null) {
            $this->collection = $callback($this->collection);
        }

        if ($view !== null) {
            $this->collection = $view::collection($resource);
        }
    }

    public function toArray($request)
    {
        return $this->getPaginationTemplate(
            $this->total(),
            $this->perPage(),
            $this->currentPage(),
            $this->lastPage(),
            $this->collection
        );
    }
}
