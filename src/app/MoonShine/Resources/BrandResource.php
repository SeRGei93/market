<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Domain\Brand\Model\Brand;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Attributes\Icon;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;
use Support\Enum\Status;

/**
 * @extends ModelResource<Brand>
 */
#[Icon('heroicons.globe-alt')]
class BrandResource extends ModelResource
{
    protected string $model = Brand::class;

    protected string $title = 'Brands';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Image::make('Thumbnail', 'image')
                    ->removable()
                    ->disk('images'),
                Text::make('Name', 'name'),
                Slug::make('Slug', 'slug'),
                Number::make('Sort', 'sort')
                    ->sortable(),
                Enum::make('Status', 'status')
                    ->attach(Status::class),
                TinyMce::make('Description', 'description')
                    ->removePlugins('autoresize'),
            ]),
        ];
    }

    /**
     * @param Brand $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
