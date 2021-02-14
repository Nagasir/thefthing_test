<?php


namespace App\Http\CustomFilter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MarriageFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $value = strtolower($value);
        if($value == 'married'){
            return $query->orWhere($property, 1);
        }elseif ($value == 'single'){
            return $query->orWhere($property, 0);
        }else{
            return $query;
        }
    }
}

