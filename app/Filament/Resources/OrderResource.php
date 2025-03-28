<?php

namespace App\Filament\Resources;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\URL;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
class OrderResource extends Resource
{
    
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('discount.title')->searchable(),
                Tables\Columns\TextColumn::make('discount.value')->label('Discount Amount(%)')->sortable(),
                Tables\Columns\TextColumn::make('total_amount')->label('Total Amount(₹)')->sortable(),
                Tables\Columns\TextColumn::make('final_amount')->label('Final Amount(₹)')->sortable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Payment Method')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('view_invoice')
                ->label('Invoice')
                ->icon('')
                ->url(fn (Order $record) => URL::to("/admin/invoices/{$record->id}"))
                ->openUrlInNewTab(),

            // Download Invoice Action
            // Action::make('download_invoice')
            //     ->label('Download')
            //     ->icon('')
            //     ->url(fn (Order $record) => URL::to("/admin/invoices/{$record->id}/download")),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                ExportBulkAction::make()->exports([
                    ExcelExport::make()
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                        ->withColumns([
                            Column::make('phone')->heading('Customer Contact'),
                            Column::make('discount.title')->heading('Discount Name'),
                            Column::make('discount.value')->heading('Discount Percentage'),
                            Column::make('total_amount')->heading('Total Amount'),
                            Column::make('final_amount')->heading('Final Amount'),
                            Column::make('payment_method')->heading('Payment Method'),
                            Column::make('created_at')->heading('Created At')
                           
                        ])
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            
        ];
    }
}
