<?php
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IncludeLostOrFound implements Scope
{
  public function apply(Builder $builder, Model $model): void
{
    $table   = $model->getTable();
    $columns = $builder->getQuery()->columns;

    // CASE 1: no columns chosen yet → select every column
    if ($columns === null) {
        $builder->select("$table.*");
        return;
    }

    // Prepare fully-qualified columns, skipping any non-string expressions
    $flatCols = [];
    foreach ($columns as $c) {
        if (! is_string($c)) {
            // e.g. a Query\Expression or raw select, just ignore here
            continue;
        }
        $flatCols[] = str_contains($c, '.') ? $c : "$table.$c";
    }

    // Ensure lost_or_found is in the select list
    $lfCol = "$table.lost_or_found";
    if (! in_array($lfCol, $flatCols, true)) {
        $builder->addSelect($lfCol);
    }
}

}
