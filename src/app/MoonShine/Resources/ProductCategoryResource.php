<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Domain\Product\Model\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Attributes\Icon;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
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
 * @extends ModelResource<ProductCategory>
 */
#[Icon('heroicons.square-3-stack-3d')]
class ProductCategoryResource extends ModelResource
{
    protected string $model = ProductCategory::class;

    protected string $title = 'Product Categories';

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
                    ->attach(Status::class)
                    ->sortable(),
                Checkbox::make('Show in menu', 'show_in_menu'),
                TinyMce::make('Description', 'description')
                    ->removePlugins('autoresize'),

                BelongsTo::make(
                    'ParentCategory',
                    'parent',
                    fn($item) => $item->name . ' (' . $item->id . ')',
                    new ProductCategoryResource()
                ),

                HasMany::make(
                    'Children',
                    'children',
                    resource: new ProductCategoryResource(),
                )->hideOnIndex()
                ->readonly(),
            ]),
        ];
    }

    /**
     * @param ProductCategory $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
