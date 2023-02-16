<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrievanceResource\Pages;
use App\Filament\Resources\GrievanceResource\RelationManagers;
use App\Models\Grievance;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\GrievanceResource\Pages\EditUser;
use App\Filament\Resources\GrievanceResource\Pages\ListUsers;
use App\Filament\Resources\GrievanceResource\Pages\CreateUser;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use App\Filament\Resources\GrievanceResource\RelationManagers\PlaceRelationManager;
use Filament\Forms\Components\Textarea;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class GrievanceResource extends Resource
{
    protected static ?string $model = Grievance::class;


    protected static ?string $navigationGroup = 'Student Management';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('name')
                        ->maxLength(255)
                        ->default(auth()->user()->name)->disabled()->hiddenOn('edit'),
                    TextInput::make('email')
                        ->maxLength(255)
                        ->default(auth()->user()->email)->disabled()->hiddenOn('edit'),
                    Select::make('place')
                        ->relationship('Place', 'name')
                        ->preload()
                        ->required(),
                    TextInput::make('subject')
                        ->maxLength(255)
                        ->required(),
                    TextArea::make('desc')
                        ->maxLength(255)
                        ->required(),
                    FileUpload::make('image'),
                    Toggle::make('is_completed')->hiddenOn('create'),
                    TextArea::make('remark')
                        ->maxLength(255)->hiddenOn('create')
                        ->required(),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
            return $table
                ->columns([

                    // TextColumn::make('name')->sortable()->searchable(),
                    TextColumn::make('Place.name')->sortable()->searchable(),
                    TextColumn::make('subject'),
                    ImageColumn::make('image'),
                    BooleanColumn::make('is_completed')->sortable(),
                    TextColumn::make('remark'),
                ])
                ->filters([
                    Filter::make('Completed')
                        ->query(fn (Builder $query): Builder => $query->where('is_completed', true)),
                    Filter::make('Un Completed')
                        ->query(fn (Builder $query): Builder => $query->where('is_completed', false)),
                    SelectFilter::make('Place')->relationship('Place', 'name')
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
                ]);

    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole(['user'])){
            return parent::getEloquentQuery()->where('email', auth()->user()->email);
        }
        else {
            return parent::getEloquentQuery();
        }
    }

    public static function getRelations(): array
    {
        return [
            PlaceRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrievances::route('/'),
            'create' => Pages\CreateGrievance::route('/create'),
            'edit' => Pages\EditGrievance::route('/{record}/edit'),
        ];
    }
}
