<?php

namespace Jdkweb\FilamentFileManager\Livewire;

use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;
use Jdkweb\FilamentFileManager\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\HttpKernel\Tests\Controller\Post;

class TrixMediaEditResource extends Component implements HasForms
{
    use InteractsWithForms;

    public ?int $doc_id;

    public ?int $width = null;
    public ?int $height = null;
    public ?int $start_width = null;
    public ?int $start_height = null;
    public ?bool $ratio = true;
    public ?string $alt = '';
    public ?string $figcaption = '';
    public ?int $trix_id = null;


    /**
     * Fill form with settings form the DOM
     *
     * @param $id
     * @param $width
     * @param $height
     * @param $alt
     * @param $figcaption
     * @return void
     */
    #[On('fill-modal')]
    public function fillModal($id, $width, $height, $alt = '', $figcaption = '', $trix_id)
    {
        if($id == 'filament-file-edit') {
            $this->width = $width;
            $this->height = $height;
            $this->start_width = $width;
            $this->start_height = $height;
            $this->ratio = true;
            $this->alt = $alt;
            $this->figcaption = $figcaption;
            $this->trix_id = $trix_id;
        }
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make('')
                ->columns(7)
                ->schema([
                    TextInput::make('width')
                        ->label(__('filament-file-manager::image_settings.width'))
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if($get('ratio')) {
                                $height = round($state/$this->start_width * $this->start_height);
                                $set('height', $height);
                                $this->start_height = $height;
                                $this->start_width = $state;
                            }
                        })
                        ->columnSpan(3)
                        ->numeric(),
                    Toggle::make('ratio')
                        ->label(fn () => new HtmlString("<div style='margin-top: 30px'></div>"))
                        ->default(true)
                        ->inline(false)
                        ->onIcon('heroicon-m-lock-closed')
                        ->offIcon('heroicon-m-lock-open'),
                    TextInput::make('height')
                        ->label(__('filament-file-manager::image_settings.height'))
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if($get('ratio')) {
                                $width = round($state/$this->start_height * $this->start_width);
                                $set('width', $width);
                                $this->start_height = $state;
                                $this->start_width = $width;
                            }
                        })
                        ->columnSpan(3)
                        ->numeric(),
                    TextInput::make('alt')
                        ->label(__('filament-file-manager::image_settings.alttext'))
                        ->columnSpanFull(),
                    TextInput::make('figcaption')
                        ->label(__('filament-file-manager::image_settings.figcaption'))
                        ->columnSpanFull(),
                ])
        ];
    }

    #[On('submit')]
    public function submit()
    {
        $this->dispatch('settings', [
            'width' => $this->width,
            'height' => $this->height,
            'alt' => $this->alt,
            'figcaption' => $this->figcaption,
            'trix_id' => $this->trix_id,
        ]);
    }

    public function render()
    {
        return view('filament-file-manager::livewire.trix-media-edit-resource');
    }
}
