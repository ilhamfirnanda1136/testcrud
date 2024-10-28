<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UniqueWithoutSoftDeleted implements Rule
{
    protected $table;
    protected $column;
    protected $ignoreIdColumn;
    protected $ignoreIdValue;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string $column
     * @param string|null $ignoreIdColumn
     * @param mixed|null $ignoreIdValue
     */
    public function __construct($table, $column, $ignoreIdColumn = null, $ignoreIdValue = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreIdColumn = $ignoreIdColumn;
        $this->ignoreIdValue = $ignoreIdValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)->where($this->column, $value);

        if ($this->ignoreIdColumn && $this->ignoreIdValue) {
            $query->where($this->ignoreIdColumn, '!=', $this->ignoreIdValue);
        }

        $exists = $query->whereNull('deleted_at')->exists();

        return !$exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
