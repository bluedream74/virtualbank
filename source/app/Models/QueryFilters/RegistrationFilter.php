<?php

namespace App\Models\QueryFilters;

class RegistrationFilter extends QueryFilter
{
    public function status($status = null)
    {
        if (!empty($status)) {
            if ($status === true || $status == 'true') {
                return $this->builder->where('status', 10);
            }
        }
    }

}
