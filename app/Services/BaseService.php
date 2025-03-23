<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;

class BaseService
{
    protected function createTextInput(string $name, string $label, bool $required = false, ?int $maxLength = null)
    {
        $input = Forms\Components\TextInput::make($name)
            ->label($label);

        if ($required) {
            $input->required();
        }

        if ($maxLength) {
            $input->maxLength($maxLength);
        }

        return $input;
    }

    protected function createNumberInput(string $name, string $label, bool $required = false, ?int $default = null)
    {
        $input = Forms\Components\TextInput::make($name)
            ->label($label)
            ->numeric();

        if ($required) {
            $input->required();
        }

        if ($default !== null) {
            $input->default($default);
        }

        return $input;
    }

    protected function createTextColumn(string $name, string $label, bool $searchable = false, bool $sortable = false, ?callable $formatStateUsing = null)
    {
        $column = Tables\Columns\TextColumn::make($name)
            ->label($label);

        if ($searchable) {
            $column->searchable();
        }

        if ($sortable) {
            $column->sortable();
        }

        if ($formatStateUsing) {
            $column->formatStateUsing($formatStateUsing);
        }

        return $column;
    }

    protected function createBooleanColumn(string $name, string $label)
    {
        return Tables\Columns\IconColumn::make($name)
            ->label($label)
            ->boolean();
    }
} 