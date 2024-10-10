<?php

namespace App\Filament\Resources\VentasResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Filament\Resources\VentasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVentas extends ListRecords
{
    protected static string $resource = VentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
