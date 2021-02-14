<?php


namespace App\Http\CustomFilter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class NameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
       return $query->orWhere($property, 'like', '%'.$value.'%');
    }
}

