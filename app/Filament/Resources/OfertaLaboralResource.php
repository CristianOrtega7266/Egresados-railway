<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfertaLaboralResource\Pages;
use App\Filament\Resources\OfertaLaboralResource\RelationManagers;
use App\Models\OfertaLaboral;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;


class OfertaLaboralResource extends Resource
{
    protected static ?string $model = OfertaLaboral::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Ofertas laborales';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Información General de la Oferta
            Section::make('Información General')
                ->schema([
                    Grid::make(2) // Agrupar Título y Fecha de Publicación en dos columnas
                        ->schema([
                            TextInput::make('titulo')
                                ->required()
                                ->maxLength(255)
                                ->label('Título'),

                            DatePicker::make('fecha_publicacion')
                                ->required()
                                ->label('Fecha de Publicación')
                                ->placeholder('Selecciona la fecha de publicación'),
                        ]),

                    TextInput::make('empresa')
                        ->required()
                        ->label('Empresa'),

                    TextInput::make('ubicacion')
                        ->required()
                        ->label('Ubicación'),

                    TextInput::make('salario')
                        ->numeric()
                        ->required()
                        ->label('Salario')
                ])
                ->columns(1), // Todo en una sola columna dentro de esta sección

            // Descripción de la Oferta
            Section::make('Descripción')
                ->schema([
                    RichEditor::make('descripcion')
                        ->required()
                        ->label('Descripción')
                        ->placeholder('Escribe la descripción de la oferta laboral'),
                ])
                ->columns(1), // Descripción en una sola columna
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo')->sortable()->searchable(),
                TextColumn::make('empresa')->sortable()->searchable(),
                TextColumn::make('ubicacion')->sortable(),
                TextColumn::make('fecha_publicacion')->date()->sortable(),
                TextColumn::make('salario')->sortable()->formatStateUsing(function ($state) {
                    // Eliminar decimales y agregar separadores de miles
                    return 'COP ' . number_format($state, 0, ',', '.');
                }),
            ])



            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOfertaLaborals::route('/'),
            'create' => Pages\CreateOfertaLaboral::route('/create'),
            'edit' => Pages\EditOfertaLaboral::route('/{record}/edit'),
        ];
    }
}
