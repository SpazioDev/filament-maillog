<?php

namespace Tapp\FilamentMailLog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Closure;

class FilamentMailLogPlugin implements Plugin
{
    protected Closure|bool $accessible;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public function accessibleIf(Closure|bool $condition): static
    {
        $this->accessible = $condition;
        return $this;
    }

    public function getId(): string
    {
        return 'filament-maillog';
    }

    public function isAccessible(): bool
    {
        if (!is_callable($this->accessible)) { return $this->accessible; }
        $accessible = $this->accessible;
        return $accessible(auth()->user());
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources(
                config('filament-maillog.resources')
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
