<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Domain\User\Model\UserRole;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

#[Icon('heroicons.outline.bookmark')]
class MoonShineUserRoleResource extends ModelResource
{
    public string $model = UserRole::class;

    public string $column = 'name';

    protected bool $isAsync = true;

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    public function title(): string
    {
        return __('moonshine::ui.resource.role');
    }

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                Text::make(__('moonshine::ui.resource.role_name'), 'name')
                    ->required()
                    ->showOnExport(),
                Text::make(__('moonshine::ui.resource.role_slug'), 'slug')
                    ->required()
                    ->showOnExport(),
            ]),
        ];
    }

    /**
     * @return array{name: string}
     */
    public function rules($item): array
    {
        return [
            'name' => 'required|min:5|max:50',
            'slug' => 'required|min:5|max:50',
        ];
    }

    public function search(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
