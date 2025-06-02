<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\ToolType;


class ProductController extends Controller
{

    
    public function showChainsaws(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.chainsaw', compact('products', 'totalCount', 'brands'));
    }

    //Генераторы
    public function showGenerator(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Генераторы'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Генераторы'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Генераторы'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Генераторы'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.generator', compact('products', 'totalCount', 'brands'));
    }

    //Бензорезы
    public function showBenzorez(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензорезы'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Бензорезы'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензорезы'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензорезы'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.benzorez', compact('products', 'totalCount', 'brands'));
    }

    //Мотопомпы
    public function showPomp(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Мотопомпы'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Мотопомпы'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Мотопомпы'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Мотопомпы'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.pomp', compact('products', 'totalCount', 'brands'));
    }

    //-------------------------Климатическое оборудование-----------------------------------
    //Кондиционеры
    public function showConditioners(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Кондиционеры'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Кондиционеры'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Кондиционеры'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Кондиционеры'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.conditioners', compact('products', 'totalCount', 'brands'));
    }
    //Водонагреватель
    public function showWaterheater(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Водонагреватели'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Водонагреватели'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Водонагреватели'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Водонагреватели'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.waterheater', compact('products', 'totalCount', 'brands'));
    }
    //Обогреватель
    public function showHeater(Request $request)
    {
        $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Обогреватели'))->with('brand');
        ;

        $brands = Brand::whereHas('products', function ($query) {
            $query->whereHas('toolType', fn($q) => $q->where('name', 'Обогреватели'));
        })->orderBy('name')->get();

        // Фильтр по цене
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }


        // Фильтр по бренду
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Фильтр по мощности
        if ($request->power) {
            $power = (float) $request->power;
            if ($power == 1.5) {
                $query->where('power', '<=', 1.5);
            } elseif ($power == 5) {
                $query->where('power', '>', 3.5);
            } else {
                $query->whereBetween('power', [
                    $power - 1,
                    $power
                ]);
            }
        }

        // Фильтр по весу
        if ($request->weight) {
            $weight = (float) $request->weight;
            if ($weight == 4) {
                $query->where('weight', '<=', 4);
            } elseif ($weight == 7) {
                $query->where('weight', '>', 6);
            } else {
                $query->whereBetween('weight', [
                    $weight - 1,
                    $weight
                ]);
            }
        }
        $priceRange = [
            'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Обогреватели'))->min('price'),
            'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Обогреватели'))->max('price')
        ];

        // Получаем общее количество после всех фильтров
        $totalCount = $query->count();

        $products = $query->paginate(12)->appends($request->query());

        return view('products.heater', compact('products', 'totalCount', 'brands'));
    }

    public function add(Request $request, $id)
    {
        // Получаем товар по ID
        $product = Product::findOrFail($id);

        // Проверяем, что товар в наличии
        if ($product->quantity < 1) {
            return response()->json(['error' => 'Товар закончился'], 400);
        }

        // Находим или создаем позицию в корзине
        $cartItem = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $id],
            ['quantity' => 0]
        );

        $cartItem->quantity += 1;
        $cartItem->save();

        // Уменьшаем количество товара на складе
        $product->quantity -= 1;
        $product->save();

        return response()->json(['message' => 'Товар добавлен в корзину']);
    }

    public function show($id)
    {
        $product = Product::with('category', 'brand', 'toolType')->findOrFail($id);
        return view('products.show', compact('product'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('short_description', 'LIKE', "%{$query}%");
        })
            ->with('category', 'brand') // если есть связь с категориями
            ->paginate(12)
            ->appends(['query' => $query]);

        return view('products.search_results', compact('products', 'query'));
    }

    public function byBrand($id)
    {
        $brand = Brand::with([
            'products' => function ($query) {
                $query->with('category'); // если нужно подгрузить категории
            }
        ])->findOrFail($id);

        return view('products.brands', compact('brand'));
    }


    // ДОБАВЛЕНИЕ ТОВАРОВ АДМИН
    public function index(Request $request)
    {
        // Фильтрация по категории
        $categoryFilter = $request->input('category');

        $products = Product::when($categoryFilter, function ($query) use ($categoryFilter) {
            return $query->where('category_id', $categoryFilter);
        })
            ->with(['category', 'brand']) // Загрузка связанных данных
            ->latest()
            ->get();

        $categories = Category::all(); // Для выпадающего списка фильтра

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'power' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'quantity' => 'required|integer|min:0',
            'tool_type_id' => 'required|exists:tool_types,id',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен!');
    }

    public function createProduct()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $toolTypes = ToolType::all();

        return view('admin.products.create', compact('categories', 'brands', 'toolTypes'));
    }

}
