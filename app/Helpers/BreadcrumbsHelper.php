<?php
namespace App\Helpers;

use App\Models\Category;

class BreadcrumbsHelper
{
    public static function forProduct($product)
    {
        $crumbs = [
            ['url' => url('/'), 'title' => 'Главная']
        ];

        if ($product->category) {
            $category = $product->category;
            $parents = [];
            
            while ($category) {
                $parents[] = $category;
                $category = $category->parent;
            }
            
            foreach (array_reverse($parents) as $cat) {
                $crumbs[] = [
                    'url' => route('categories.show', $cat->slug),
                    'title' => $cat->name
                ];
            }
        }

        $crumbs[] = ['url' => null, 'title' => $product->name];
        
        return $crumbs;
    }
}