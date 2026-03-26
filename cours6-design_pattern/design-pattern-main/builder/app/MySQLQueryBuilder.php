<?php

namespace App;
// Récuperer dans l'exemple du cours Builder 
class MySQLQueryBuilder implements QueryBuilderInterface
{
    private string $table;
    private array $fields = ['*'];
    private array $conditions = [];

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function select(string ...$columns): self
    {
        $this->fields = $columns ?: ['*'];
        return $this;
    }

    public function where(string $field, string $operator, mixed $value): self
    {
        $value = is_string($value) ? "'" . addslashes($value) . "'" : $value;
        $this->conditions[] = "$field $operator $value";
        return $this;
    }

    public function getQuery(): string
    {
        $query = "SELECT " . implode(', ', $this->fields);
        $query .= " FROM " . $this->table;

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(' AND ', $this->conditions);
        }

        return $query;
    }
}
