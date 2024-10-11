<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComprasResource\Pages;
use App\Models\Producto;
use App\Models\Compra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('proveedor_id')
                ->label('Proveedor')
                ->relationship('proveedor', 'nombre')
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
        
                    Forms\Components\TextInput::make('precio_compra')
                        ->label('Precio de Compra')
                        ->required()
                        ->numeric()
                        ->minValue(0.01),
                ])
                ->createItemButtonLabel('Agregar Producto')
                ->minItems(1)
                ->maxItems(10)
                ->afterStateUpdated(function ($state, callable $set) {
                    $total = 0;
                    foreach ($state as $producto) {
                        $total += $producto['cantidad'] * $producto['precio_compra'];
                    }
                    $set('total', $total);
                }),
        
            Forms\Components\DatePicker::make('fecha')
                ->label('Fecha')
                ->required()
                ->default(now()),
        
            Forms\Components\TextInput::make('total')
                ->label('Total')
                ->required()
                ->disabled()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('productos_list')
                    ->label('Productos')
                    ->getStateUsing(function (Compra $record) {
                        return $record->productos->pluck('nombre')->join(', ');
                    }),

                Tables\Columns\TextColumn::make('fecha')
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

    public static function getPages(): array
    {
        return [
            'index' => CompraResource\Pages\ListCompras::route('/'),
            'create' => CompraResource\Pages\CreateCompra::route('/create'),
            'edit' => CompraResource\Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
