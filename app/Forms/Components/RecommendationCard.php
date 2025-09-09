<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Filament\Resources\Recommendations\RecommendationResource;
use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RecommendationCard extends Section
{
    protected string $view = 'forms.components.recommendation-card';

    protected array | Closure $modalChildComponents = [];

    public function modalChildComponents(array | Closure $components): static
    {
        $this->modalChildComponents = $components;

        return $this;
    }

    public function getModalChildComponents(): array
    {
        return $this->evaluate($this->modalChildComponents);
    }

    public function getModalChildComponentContainer(): Schema
    {
        return Schema::make($this->getLivewire())
            ->parentComponent($this)
            ->components($this->getModalChildComponents());
    }

    public function getModalChildComponentContainers(bool $withHidden = false): array
    {
        if (! $this->hasModalChildComponentContainer($withHidden)) {
            return [];
        }

        return [$this->getModalChildComponentContainer()];
    }

    public function hasModalChildComponentContainer(bool $withHidden = false): bool
    {
        if ((! $withHidden) && $this->isHidden()) {
            return false;
        }

        if ($this->getModalChildComponents() === []) {
            return false;
        }

        return true;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan(null);

        $this->extraAttributes([
            'class' => 'shadow-lg',
        ]);

        $this->schema([
            VulnerabilityChips::make('vulnerabilities')
                ->disableLabel(),

            Value::make('title')
                ->extraAttributes(['class' => 'text-lg font-semibold'])
                ->disableLabel(),

            Value::make('description')
                ->extraAttributes(['class' => 'text-gray-500 line-clamp-2'])
                ->disableLabel(),

            Hidden::make('services.name')
                ->loadStateFromRelationshipsUsing(function ($component) {
                    $component->state(
                        $component->getModelInstance()->services->pluck('name')
                    );
                }),
        ]);

        $this->modalChildComponents(RecommendationResource::getViewFormSchema());
    }
}
