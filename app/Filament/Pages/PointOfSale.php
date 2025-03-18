<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class PointOfSale extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Point Of Sale';
    protected static string $view = 'filament.pages.point-of-sale';

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function getTitle(): string
    {
        return '';  // Better to return a title
    }
}
