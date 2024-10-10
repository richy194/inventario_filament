<?php
namespace App\Filament\Resources\CompraResource\Pages;

use App\Filament\Resources\CompraResource;

use App\Models\Producto;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCompra extends EditRecord
{
    protected static string $resource = CompraResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('proveedor_id')
                ->label('proveedor')
                ->relationship('proveedor', 'nombre')
                ->required(),

            Forms\Components\Repeater::make('productos_repeater')
                ->label('Productos')
                ->defaultItems($this->record->productos->map(function ($producto) {
                    return [
                        'producto_id' => $producto->id,
                        'cantidad' => $producto->pivot->cantidad,
                        'precio_compra' => $producto->pivot->precio_compra,
                    ];
                })->toArray())
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

                    Forms\Components\TextInput::make('precio_compra')
                        ->label('Precio de compra')
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $total = 0;
        foreach ($data['productos_repeater'] as $producto) {
            $total += $producto['cantidad'] * $producto['precio_compra'];
        }
    
        // Crear el registro de venta
        $record = $this->record::create([
            'proveedor_id' => $data['proveedor_id'],
            'fecha' => $data['fecha'], // Asegúrate de incluir la fecha
            'total' => $total, // Asegúrate de incluir el total aquí
        ]);
    
        // Actualizar los productos en la tabla pivote
        foreach ($data['productos_repeater'] as $producto) {
            $record->productos()->attach($producto['producto_id'], [
                'cantidad' => $producto['cantidad'],
                'precio_compra' => $producto['precio_compra'],
            ]);
        }
    
        return $record;
    }
}