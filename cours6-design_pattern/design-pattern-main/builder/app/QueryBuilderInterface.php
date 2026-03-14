<?php

namespace App;
//Créez une interface QueryBuilder
interface QueryBuilderInterface
{
    public function select(string ...$columns): self;
    public function from(string $table): self;
    public function where(string $column, string $operator, mixed $value): self;
    public function getQuery(): string;
}
