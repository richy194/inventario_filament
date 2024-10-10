<?php
namespace App\Filament\Resources\VentasResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Filament\Resources\VentasResource;
use App\Models\Producto;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateVentas extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('cliente_id')
                ->label('Cliente')
                ->relationship('cliente', 'nombre')
                ->required(),

            Forms\Components\Repeater::make('productos_repeater')
                ->label('Productos')
                ->schema([
                    Forms\Components\Select::make('producto_id')
                        ->label('Producto')
                        ->options(Producto::all()->pluck('nombre', 'id'))
                        ->required(),

                    Forms\Components\TextInput::make('cantidad')
                        ->label('Cantidad')
                        ->required()
                        ->numeric()
                        ->minValue(1),

                    Forms\Components\TextInput::make('precio_venta')
                        ->label('Precio de Venta')
                        ->required()
                        ->numeric()
                        ->minValue(0.01),
                ])
                ->createItemButtonLabel('Agregar Producto')
                ->minItems(1)
                ->maxItems(10),

            Forms\Components\TextInput::make('total')
                ->label('Total')
                ->disabled(), // Este campo será calculado y no se puede editar
        ];
    }

    protected function afterSave(Model $record): void
    {
        $total = 0;

        foreach ($record->productos_repeater as $producto) {
            $total += $producto['cantidad'] * $producto['precio_venta'];
        }
    
        // Actualizar el total en el registro
        $record->update(['total' => $total]);
    }
}
