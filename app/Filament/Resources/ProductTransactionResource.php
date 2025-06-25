<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Models\ProductTransaction;
use App\Models\Shoe;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductTransactionResource extends Resource
{
    protected static ?string $model = ProductTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Product and Price')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Forms\Components\Select::make('shoe_id')
                                        ->relationship('shoe', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $shoe = Shoe::find($state);
                                            $price = $shoe ? $shoe->price : 0;
                                            $quantity = $get('quantity') ?? 1;
                                            $subTotalAmount = $price * $quantity;

                                            $set('price', $price);
                                            $set('sub_total_amount', $subTotalAmount);

                                            $discount = $get('discount_amount') ?? 0;
                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);

                                            $sizes = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                            $set('shoe_sizes', $sizes);
                                        })
                                        ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                            $shoeId = $state;
                                            if ($shoeId) {
                                                $shoe = Shoe::find($shoeId);
                                                $sizes = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                                $set('shoe_sizes', $sizes);
                                            }
                                        }),

                                    Forms\Components\Select::make('shoe_size')
                                        ->label('Shoe Size')
                                        ->options(function (callable $get) {
                                            $sizes = $get('shoe_sizes');
                                            return is_array($sizes) ? $sizes : [];
                                        })
                                        ->required()
                                        ->live(),

                                    Forms\Components\TextInput::make('quantity')
                                        ->required()
                                        ->numeric()
                                        ->prefix('Qty')
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $price = $get('price');
                                            $quantity = $state;
                                            $subTotalAmount = $price * $quantity;

                                            $set('sub_total_amount', $subTotalAmount);

                                            $discount = $get('discount_amount') ?? 0;
                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);
                                        }),

                                    Forms\Components\Select::make('promo_code_id')
                                        ->relationship('promoCode', 'code')
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $subTotalAmount = $get('sub_total_amount');
                                            $promoCode = PromoCode::find($state);
                                            $discount = $promoCode ? $promoCode->discount_amount : 0;

                                            $set('discount_amount', $discount);

                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);
                                        }),

                                    Forms\Components\TextInput::make('sub_total_amount')
                                        ->required()
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    Forms\Components\TextInput::make('grand_total_amount')
                                        ->required()
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    Forms\Components\TextInput::make('discount_amount')
                                        // ->readOnly()
                                        ->required()
                                        ->numeric()
                                        ->prefix('IDR'),
                                ]),
                        ]),


                        Forms\Components\Wizard\Step::make('Customer Information')
                            ->schema([
                                Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('phone')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('email')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextArea::make('address')
                                        ->rows(5)
                                        ->required(),

                                    Forms\Components\TextInput::make('city')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('post_code')
                                        ->required()
                                        ->maxLength(255),
                                ]),
                            ]),

                            Forms\Components\Wizard\Step::make('Payment Information')
                                ->schema([
                                    Forms\Components\TextInput::make('booking_trx_id')
                                        ->required()
                                        ->maxLength(255),

                                    ToggleButtons::make('is_paid')
                                        ->label('Apakah sudah membayar?')
                                        ->boolean()
                                        ->grouped()
                                        ->icons([
                                            true => 'heroicon-o-pencil',
                                            false => 'heroicon-o-clock',
                                        ])
                                        ->required(),

                                    Forms\Components\FileUpload::make('proof')
                                        ->image()
                                        ->required(),
                                ]),

                ])
                ->columnSpan('full')
                ->columns(1)
                ->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('shoe.thumbnail'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi'),

            ])
            ->filters([
                // 
                SelectFilter::make('shoe_id')
                ->label('shoe')
                    ->relationship('shoe', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),


                Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function (ProductTransaction $record) {
                    $record->is_paid = true;
                    $record->save();

                    // Trigger the custom notification
                    Notification::make()
                    ->title('Order Approved')
                    ->success()
                    ->body('The order has been successfully approved.')
                    ->send();

            })
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (ProductTransaction $record) => !$record->is_paid),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProductTransactions::route('/'),
            'create' => Pages\CreateProductTransaction::route('/create'),
            'edit' => Pages\EditProductTransaction::route('/{record}/edit'),
        ];
    }
}
