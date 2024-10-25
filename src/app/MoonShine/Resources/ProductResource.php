<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Domain\Product\Model\Product;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Enum;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;
use Support\Enum\Status;

/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Products';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                Tabs::make([
                    Tab::make('Main info', [
                        ID::make()->sortable(),
                        Enum::make('Status', 'status')
                            ->attach(Status::class)
                            ->sortable(),
                        Image::make('Thumbnail', 'image')
                            ->removable()
                            ->disk('images'),

                        Text::make('Name', 'name'),
                        Slug::make('Slug', 'slug')
                            ->hideOnIndex(),
                        Number::make('Sort', 'sort')
                            ->sortable(),
                        Number::make('amount', 'amount')
                            ->default(0)
                            ->sortable(),
                        Number::make('price', 'price')
                            ->sortable(),


                        Number::make('weight', 'weight')
                            ->sortable()
                            ->hideOnIndex(),
                        Number::make('length', 'length')
                            ->sortable()
                            ->hideOnIndex(),
                        Number::make('width', 'width')
                            ->sortable()
                            ->hideOnIndex(),
                        Number::make('height', 'height')
                            ->sortable()
                            ->hideOnIndex(),

                        File::make('instructions', 'instructions')
                            ->removable()
                            ->disk('public')
                            ->dir('instructions')
                            ->hideOnIndex(),

                        Textarea::make('Preview text', 'preview')
                            ->hideOnIndex(),
                        TinyMce::make('Description', 'description')
                            ->hideOnIndex()
                            ->removePlugins('autoresize'),

                    ]),
                    Tab::make('Categories', [
                        BelongsToMany::make(
                            'Category',
                            'categories',
                            fn($item) => $item->name . ' (' . $item->id . ')',
                            new ProductCategoryResource()
                        )->tree('parent_id')
                        ->hideOnIndex(),

                    ]),

                    Tab::make('Brand', [
                        HasOne::make(
                            'Brand',
                            'brand',
                            fn($item) => $item->name . ' (' . $item->id . ')',
                            new BrandResource()
                        )->hideOnIndex(),

                    ]),
                ]),
            ]),
        ];
    }

    /**
     * @param Product $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
