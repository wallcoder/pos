<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PointOfSale extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Point Of Sale';

    protected static string $view = 'filament.pages.point-of-sale';
    public function getTitle(): string
    {
        return '';  
    }
}
