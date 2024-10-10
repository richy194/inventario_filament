<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentasResource\Pages;
use App\Models\Producto;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                ->maxItems(10)
                ->afterStateUpdated(function ($state, callable $set) {
                    // Calcular el total cuando se actualiza el repeater
                    $total = 0;
        
                    foreach ($state as $producto) {
                        $total += $producto['cantidad'] * $producto['precio_venta'];
                    }
        
                    // Establecer el total
                    $set('total', $total);
                }),
        
            // Campo para la fecha
            Forms\Components\DatePicker::make('fecha')
                ->label('Fecha')
                ->required()
                ->default(now()), // Establecer la fecha actual como valor predeterminado
        
            // Campo para el total
            Forms\Components\TextInput::make('total')
                ->label('Total')
                ->required()
                ->disabled() // Deshabilitado porque se calculará automáticamente
                ->default(0), // Establecer valor predeterminado en cero
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->sortable(),
    
                // Columna para mostrar los productos asociados
                Tables\Columns\TextColumn::make('productos_list')
                    ->label('Productos')
                    ->getStateUsing(function (Venta $record) {
                        // Obtener los nombres de los productos y concatenarlos con comas
                        return $record->productos->pluck('nombre')->implode(', ');
                    }),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
    
                // Columna para mostrar el total de la venta
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('USD') // Formato de dinero
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVentas::route('/create'),
            'edit' => Pages\EditVentas::route('/{record}/edit'),
        ];
    }










    public static function canViewAny(): bool
{
    return auth()->user()->hasRole(['admin', 'admin_ventas']);
}

}
