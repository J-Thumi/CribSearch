<?php

namespace App\Filament\Resources\Houses\Tables;

use App\Models\House;
use App\Services\TikTokPostService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HousesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scout.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('contact_number')
                    ->searchable(),
                TextColumn::make('lat')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('long')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                Action::make('connectTikTok')
                ->label(fn () => auth()->user()->tiktok_access_token ? 'TikTok Connected' : 'Connect TikTok')
                ->icon('heroicon-o-link')
                ->color(fn () => auth()->user()->tiktok_access_token ? 'success' : 'primary')
                ->url(route('tiktok.redirect'))
                ->openUrlInNewTab(),
                Action::make('postToTikTok')
                    ->label('Post to TikTok')
                    ->icon('heroicon-o-share')
                    ->color('success')
                    ->form([
                        TextInput::make('title')
                            ->default(fn (House $record) => $record->name ?? 'House for Rent in Juja')
                            ->required(),
                            
                        Textarea::make('description')
                            ->default(function (House $record) {
                                // Calculate starting price from units repeater
                                $prices = collect($record->units ?? [])->pluck('price')->filter();
                                $minPrice = $prices->min();
                                $priceText = $minPrice ? "Starting from KES " . number_format($minPrice) : "Contact for Pricing";
                                
                                return "📍 {$record->name} ({$record->approximate_area})\n"
                                     . "🚪 Near: {$record->nearest_gate}\n"
                                     . "💰 {$priceText}\n"
                                     . "⏱️ Distance: {$record->estimated_time_to_school}\n\n"
                                     . ($record->description ?? '');
                            })
                            ->rows(5)
                            ->required(),
                            
                        Select::make('privacy_level')
                            ->options([
                                'PUBLIC_TO_EVERYONE' => 'Public (Everyone)',
                                'MUTUAL_FOLLOW_FRIENDS' => 'Friends Only',
                                'SELF_ONLY' => 'Private (Draft / Self Only)',
                            ])
                            ->default('PUBLIC_TO_EVERYONE')
                            ->required(),
                    ])
                    ->action(function (House $record, array $data, TikTokPostService $tikTokService) {
                        try {
                            // Automatically returns a valid access_token (refreshes if expired)
                            $accessToken = $tikTokService->getValidUserToken(auth()->user());

                            // Extract unit photos
                           $imageUrls = collect($record->units ?? [])
                            ->flatMap(function ($unit) {
                                // 1. Prefer explicitly generated tiktok_images if available
                                if (!empty($unit['tiktok_images'])) {
                                    return $unit['tiktok_images'];
                                }

                                // 2. Fallback: derive tiktok/ directory path from images or virtual tour images
                                $originalPaths = array_merge($unit['images'] ?? [], $unit['virtual_tour_images'] ?? []);
                                
                                return array_map(function ($path) {
                                    // Converts 'house-units/abc/01.webp' -> 'tiktok/house-units/abc/01.jpg'
                                    $jpgPath = preg_replace('/\.webp$/i', '.jpg', $path);
                                    return str_starts_with($jpgPath, 'tiktok/') ? $jpgPath : 'tiktok/' . $jpgPath;
                                }, $originalPaths);
                            })
                            ->filter()
                            ->map(fn ($path) => url(Storage::url($path)))
                            ->unique()
                            ->take(35)
                            ->values()
                            ->toArray();

                        Log::info('Posting to TikTok', [
                            'house_id' => $record->id,
                            'image_count' => count($imageUrls),
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'privacy_level' => $data['privacy_level'],
                            'image_urls' => $imageUrls,
                        ]);

                            if (empty($imageUrls)) {
                                Notification::make()->title('No images found')->warning()->send();
                                return;
                            }

                            $publishId = $tikTokService->postPhotoSlideshow(
                                accessToken: $accessToken,
                                imageUrls: $imageUrls,
                                title: $data['title'],
                                description: $data['description'],
                                privacyLevel: $data['privacy_level']
                            );
                            Log::info("Successfully posted to TikTok. Publish ID: {$publishId}");

                            Notification::make()
                                ->title('Posted to TikTok!')
                                ->body("Publish ID: {$publishId}")
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('TikTok Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }
}
