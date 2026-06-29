<?php

namespace App\Filament\Resources\Houses\Schemas;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Illuminate\Support\HtmlString; 
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\FileUpload;

class HouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                        TextInput::make('name')
                            ->required()
                            ->placeholder('e.g. Blue Waters Apartments'),
                        
                        TextInput::make('contact_number')
                            ->tel()
                            ->required()
                            ->placeholder('07...'),

                        // Automatically captures the logged-in scout's ID
                        Hidden::make('scout_id')
                            ->default(auth()->id())
                            ->required(),
                  
                        TextInput::make('lat')
                            ->numeric()
                            ->required()
                            ->id('location-lat') // Give it an ID for JS access
                            ->live()
                            ->suffixAction(
                                Action::make('fetchLocation')
                                    ->icon('heroicon-m-map-pin')
                                    ->color('primary')
                                    ->tooltip('Get current location')
                                    ->action(function () {
                                        // This stays empty because the logic happens in the extraAttributes (JS)
                                    })
                                    ->extraAttributes([
                                        'onclick' => "
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition(function(position) {
                                                    document.getElementById('location-lat').value = position.coords.latitude;
                                                    document.getElementById('location-long').value = position.coords.longitude;
                                                    
                                                    // Trigger Livewire to save the new values
                                                    document.getElementById('location-lat').dispatchEvent(new Event('input'));
                                                    document.getElementById('location-long').dispatchEvent(new Event('input'));
                                                    
                                                    new Notification().title('Location captured!').success().send();
                                                }, function(error) {
                                                    alert('Error getting location: ' + error.message);
                                                });
                                            } else {
                                                alert('Geolocation is not supported by this browser.');
                                            }
                                        "
                                    ])
                            ),

                        TextInput::make('long')
                            ->numeric()
                            ->required()
                            ->id('location-long')
                            ->live(),

                        Placeholder::make('map_preview')
                            ->label('Map Preview')
                            ->columnSpanFull()
                            ->content(function ($get) {
                                $lat = $get('lat');
                                $lng = $get('long');

                                if (!$lat || !$lng) {
                                    return 'Enter coordinates to see the map preview.';
                                }

                                // We use OpenStreetMap via an Iframe (Free, no API key needed)
                                return new HtmlString("
                                    <div style='width: 100%; height: 300px; border-radius: 10px; overflow: hidden; border: 1px solid #ccc;'>
                                        <iframe 
                                            width='100%' 
                                            height='100%' 
                                            frameborder='0' 
                                            scrolling='no' 
                                            marginheight='0' 
                                            marginwidth='0' 
                                            src='https://www.openstreetmap.org/export/embed.html?bbox=" . ($lng - 0.005) . "," . ($lat - 0.005) . "," . ($lng + 0.005) . "," . ($lat + 0.005) . "&layer=mapnik&marker=$lat,$lng'>
                                        </iframe>
                                    </div>
                                    <small><a href='https://www.google.com/maps/search/?api=1&query=$lat,$lng' target='_blank' style='color: #3b82f6;'>View on Google Maps</a></small>
                                    ");
                            }),
                    
   
                        Repeater::make('units')
                            ->schema([
                                Select::make('size')
                                    ->options([
                                        'bedsitter' => 'Bedsitter',
                                        'studio' => 'Studio',
                                        'one_bedroom' => '1 Bedroom',
                                        'two_bedroom' => '2 Bedroom',
                                        'three_bedroom' => '3 Bedroom',
                                        'four_bedroom' => '4 Bedroom',
                                    ])
                                    ->required()
                                    ->live(), // Ensures price field visibility updates immediately

                                Select::make('status')
                                    ->options([
                                        'vacant' => 'Vacant',
                                        'occupied' => 'Occupied',
                                        'pending' => 'Pending',
                                    ])
                                    ->default('vacant')
                                    ->required()
                                    ->selectablePlaceholder(false),

                                TextInput::make('price')
                                    ->numeric()
                                    ->prefix('KES')
                                    ->required()
                                    ->label(fn ($get) => $get('size') 
                                        ? ucfirst(str_replace('_', ' ', $get('size'))) . ' Price' 
                                        : 'Price')
                                    ->visible(fn ($get) => filled($get('size'))), 
                                FileUpload::make('images')
                                    ->label('Unit Gallery')
                                    ->image() // Ensures only image files
                                    ->multiple() // This allows selecting more than one file
                                    ->disk('public')
                                    ->reorderable() // Scouts can drag to set the "main" photo
                                    ->appendFiles() // Keeps existing images when adding new ones
                                    ->directory('house-units') // Saved in storage/app/public/house-units
                                    ->visibility('public')
                                    ->imageEditor() // Helpful for scouts to crop on the fly
                                    ->panelLayout('grid') // Shows photos in a grid instead of a long list
                                    ->maxFiles(10) // Prevents scouts from uploading too many
                                    ->columnSpanFull(),
                                 FileUpload::make('virtual_tour_images')
                                    ->label('Virtual Tour')
                                    ->maxSize(102400)
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png'
                                    ])
                                    ->multiple() // This allows selecting more than one file
                                    ->disk('public')
                                    ->reorderable() // Scouts can drag to set the "main" photo
                                    ->appendFiles() // Keeps existing images when adding new ones
                                    ->directory('virtual-tours') // Saved in storage/app/public/house-units
                                    ->visibility('public')
                                    ->panelLayout('grid') // Shows photos in a grid instead of a long list
                                    ->maxFiles(10) // Prevents scouts from uploading too many
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            // This makes the repeater items look clean when collapsed
                            ->itemLabel(fn (array $state): ?string => ($state['size'] ?? null) 
                                ? ucfirst(str_replace('_', ' ', $state['size'])) . ' - KES ' . ($state['price'] ?? 0)
                                : null)
                            ->collapsible()
                            ->defaultItems(1)
                            ->addActionLabel('Add Another House Type')
                    // ]),
            ]);
    }
}