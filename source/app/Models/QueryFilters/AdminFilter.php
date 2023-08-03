<?php

namespace App\Models\QueryFilters;

class AdminFilter extends QueryFilter
{

    public function name($name = null)
    {
        return $this->builder->where('name', 'LIKE', '%' . $name . '%');
    }

    public function email($email = null)
    {
        return $this->builder->where('email', $email);
    }

}
