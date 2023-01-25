<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Models\Beneficiary;
use App\Rules\ValidCNP;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return __('beneficiary.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('beneficiary.label.plural');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withLocation();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Group::make()
                            ->extraAttributes(['class' => 'flex'])
                            ->schema([
                                Select::make('type')
                                    ->label(__('field.beneficiary_type'))
                                    ->options(Type::options()),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->label(__('field.first_name'))
                                    ->placeholder(__('placeholder.first_name'))
                                    ->maxLength(50)
                                    ->required(),
                                TextInput::make('last_name')
                                    ->label(__('field.last_name'))
                                    ->placeholder(__('placeholder.last_name'))
                                    ->maxLength(50)
                                    ->required(),
                                Select::make('gender')
                                    ->label(__('field.gender'))
                                    ->placeholder(__('placeholder.choose'))
                                    ->options(Gender::options())
                                    ->disablePlaceholderSelection()
                                    ->enum(Gender::class),
                                TextInput::make('cnp')
                                    ->label(__('field.cnp'))
                                    ->placeholder(__('placeholder.cnp'))
                                    ->unique()
                                    ->nullable()
                                    ->rule(new ValidCNP),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-location-marker')
                            ->columns(2)
                            ->schema([
                                Location::make(),
                                TextInput::make('address')
                                    ->label(__('field.address'))
                                    ->maxLength(50)
                                    ->required(),
                                TextInput::make('phone')
                                    ->label(__('field.phone'))
                                    ->tel()
                                    ->nullable()
                                    ->maxLength(15),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-annotation')

                            ->schema([
                                Textarea::make('notes')
                                    ->label(__('field.beneficiary_notes'))
                                    ->nullable()
                                    ->maxLength(65535),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $default = new HtmlString('&mdash;');

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('first_name')
                    ->label(__('field.first_name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->default($default),
                TextColumn::make('last_name')
                    ->label(__('field.last_name'))
                    ->suffix(fn (Beneficiary $record) => $record->prior_name ? " ($record->prior_name)" : null)
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->default($default),
                TextColumn::make('cnp')
                    ->label(__('field.cnp'))

                    ->searchable()
                    ->toggleable()
                    ->default($default),
                TextColumn::make('age')
                    ->label(__('field.age'))
                    ->toggleable()
                    ->default($default),
                TextColumn::make('city.name')
                    ->label(__('field.city'))
                    ->description(fn (Beneficiary $record) => $record->county?->name)
                    ->toggleable()
                    ->default($default),

                BadgeColumn::make('status')
                    ->label(__('field.status'))
                    ->enum(Status::options())
                    ->colors([
                        // 'primary' => 'registered',
                        'secondary' => 'catagraphed',
                        'success' => 'active',
                        'warning' => 'inactive',
                        'danger' => 'removed',
                    ])
                    ->default($default),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeneficiaries::route('/'),
            'regular' => Pages\ListRegularBeneficiaries::route('/regular'),
            'ocasional' => Pages\ListOcasionalBeneficiaries::route('/ocasional'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'view' => Pages\ViewBeneficiary::route('/{record}'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),
        ];
    }

    public static function getListRecordsTabs(): array
    {
        return collect(['index', 'regular', 'ocasional'])
            ->mapWithKeys(fn (string $key) => [
                $key => self::getUrl($key),
            ])
            ->all();
    }
}