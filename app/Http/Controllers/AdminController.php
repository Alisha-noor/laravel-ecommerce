<?php

namespace App\Http\Controllers;

use App\Models\Review;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function reviews()
    {
        $reviews = \App\Models\Review::latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function approve_review($id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'approved';
        $review->save();

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function delete_review($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    /* =========================
     * Helpers
     * ========================= */

    /**
     * Ensure a directory exists (portable across Laravel versions).
     */
    private function ensureDir(string $path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * Generate a unique slug for products, optionally ignoring a given id.
     */
    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug     = Str::slug($base);
        $original = $slug;
        $i        = 1;

        $exists = Product::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        while ($exists) {
            $slug = $original . '-' . $i++;
            $exists = Product::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
        }

        return $slug;
    }

    /* =========================
     * Dashboard
     * ========================= */
    public function index()
    {
        $totalOrders     = Order::count();
        $pendingOrders   = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $canceledOrders  = Order::where('status', 'canceled')->count();

        $canceledAmount  = Order::where('status', 'canceled')->sum('total');

        // Revenue calculations
        $revenue      = Order::whereIn('status', ['completed', 'delivered'])->sum('total');
        $orderRevenue = Order::sum('total');

        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalBrands     = Brand::count();

        // Recent orders
        $recentOrders = Order::orderBy('created_at', 'DESC')->take(5)->get();

        return view('admin.index', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'deliveredOrders',
            'canceledOrders',
            'canceledAmount',
            'revenue',
            'orderRevenue',
            'totalProducts',
            'totalCategories',
            'totalBrands',
            'recentOrders'
        ));
    }

    /* =========================
     * Brands
     * ========================= */
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function add_brand_store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'nullable|unique:brands,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $brand       = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $this->ensureDir(public_path('uploads/brands'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $fileName);
            $brand->image = $fileName;
        }

        $brand->save();

        return redirect()->route('admin.brands')
            ->with('status', 'Record has been added successfully!');
    }

    // GET /admin/brand/{brand}/edit
    public function edit_brand(Brand $brand)
    {
        return view('admin.brand-edit', compact('brand'));
    }

    // PUT /admin/brand/{brand}
    public function update_brand(Request $request, Brand $brand)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|unique:brands,slug,' . $brand->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $brand->name = $request->name;
        $brand->slug = $request->slug;

        if ($request->hasFile('image')) {
            if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }
            $this->ensureDir(public_path('uploads/brands'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $fileName);
            $brand->image = $fileName;
        }

        $brand->save();

        return redirect()->route('admin.brands')
            ->with('status', 'Record has been updated successfully!');
    }

    // DELETE /admin/brand/{brand}
    public function delete_brand(Brand $brand)
    {
        if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
            File::delete(public_path('uploads/brands/' . $brand->image));
        }
        $brand->delete();

        return redirect()->route('admin.brands')
            ->with('status', 'Record has been deleted successfully!');
    }

    // GET /admin/brand/{brand_slug}/products
    public function brand_products($brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();

        $products = method_exists($brand, 'products')
            ? $brand->products()->orderBy('id', 'DESC')->paginate(10)
            : Product::where('brand_id', $brand->id)->orderBy('id', 'DESC')->paginate(10);

        return view('admin.brand-products', compact('brand', 'products'));
    }

    /* =========================
     * Categories
     * ========================= */
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function add_category_store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'nullable|unique:categories,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $category       = new Category();
        $category->name = $request->name;
        $category->slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $this->ensureDir(public_path('uploads/categories'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $category->image = $fileName;
        }

        $category->save();

        return redirect()->route('admin.categories')
            ->with('status', 'Record has been added successfully!');
    }

    public function edit_category($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category-edit', compact('category'));
    }

    public function update_category(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:categories,id',
            'name'  => 'required|string|max:255',
            'slug'  => 'required|unique:categories,slug,' . $request->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $category       = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            if ($category->image && File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }
            $this->ensureDir(public_path('uploads/categories'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $category->image = $fileName;
        }

        $category->save();

        return redirect()->route('admin.categories')
            ->with('status', 'Record has been updated successfully!');
    }

    public function delete_category($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && File::exists(public_path('uploads/categories/' . $category->image))) {
            File::delete(public_path('uploads/categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('status', 'Record has been deleted successfully!');
    }

    // GET /admin/category/{category_slug}/products
    public function category_products($category_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();

        $products = method_exists($category, 'products')
            ? $category->products()->orderBy('id', 'DESC')->paginate(10)
            : Product::where('category_id', $category->id)->orderBy('id', 'DESC')->paginate(10);

        return view('admin.category-products', compact('category', 'products'));
    }

    /* =========================
     * Products
     * ========================= */
    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_product()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands     = Brand::select('id', 'name')->orderBy('name')->get();

        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|unique:products,slug',
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'required|exists:brands,id',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'regular_price'     => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'SKU'               => 'required|string|max:255|unique:products,SKU',
            'stock_status'      => 'required|in:instock,outofstock',
            'featured'          => 'required|boolean',
            'quantity'          => 'required|integer|min:0',
            'image'             => 'required|mimes:png,jpg,jpeg|max:2048',
            'images.*'          => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $product                    = new Product();
        $product->name              = $request->name;
        $product->slug              = $request->filled('slug')
            ? $this->uniqueSlug($request->slug)
            : $this->uniqueSlug($request->name);
        $product->short_description = $request->short_description;
        $product->description       = $request->description;
        $product->regular_price     = $request->regular_price;
        $product->sale_price        = $request->sale_price;
        $product->SKU               = $request->SKU;
        $product->stock_status      = $request->stock_status;
        $product->featured          = $request->featured;
        $product->quantity          = $request->quantity;
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;

        // main image
        if ($request->hasFile('image')) {
            $this->ensureDir(public_path('uploads/products'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $product->image = $fileName;
        }

        // gallery images
        $gallery = [];
        if ($request->hasFile('images')) {
            $this->ensureDir(public_path('uploads/products'));
            $i = 1;
            foreach ($request->file('images') as $file) {
                $name = time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $name);
                $gallery[] = $name;
                $i++;
            }
        }
        $product->images = implode(',', $gallery);

        $product->save();

        return redirect()->route('admin.products')
            ->with('status', 'Product added successfully!');
    }

    public function edit_product($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands     = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function update_product(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:products,id',
            'name'              => 'required|string|max:255',
            'slug'              => 'required|unique:products,slug,' . $request->id,
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'required|exists:brands,id',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'regular_price'     => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'SKU'               => 'required|string|max:255|unique:products,SKU,' . $request->id,
            'stock_status'      => 'required|in:instock,outofstock',
            'featured'          => 'required|boolean',
            'quantity'          => 'required|integer|min:0',
            'image'             => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'images.*'          => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $product                    = Product::findOrFail($request->id);
        $product->name              = $request->name;
        $product->slug              = $this->uniqueSlug($request->slug ?: $request->name, (int)$request->id);
        $product->short_description = $request->short_description;
        $product->description       = $request->description;
        $product->regular_price     = $request->regular_price;
        $product->sale_price        = $request->sale_price;
        $product->SKU               = $request->SKU;
        $product->stock_status      = $request->stock_status;
        $product->featured          = $request->featured;
        $product->quantity          = $request->quantity;
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;

        // main image replace
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
                File::delete(public_path('uploads/products/' . $product->image));
            }
            $this->ensureDir(public_path('uploads/products'));
            $file     = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $product->image = $fileName;
        }

        // gallery replace (wipe old, save new)
        if ($request->hasFile('images')) {
            $old = array_filter(explode(',', (string)$product->images));
            foreach ($old as $img) {
                $path = public_path('uploads/products/' . trim($img));
                if ($img && File::exists($path)) {
                    File::delete($path);
                }
            }

            $this->ensureDir(public_path('uploads/products'));
            $gallery = [];
            $i       = 1;
            foreach ($request->file('images') as $file) {
                $name = time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $name);
                $gallery[] = $name;
                $i++;
            }
            $product->images = implode(',', $gallery);
        }

        $product->save();

        return redirect()->route('admin.products')
            ->with('status', 'Product updated successfully!');
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);

        // cleanup images
        if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(public_path('uploads/products/' . $product->image));
        }
        $old = array_filter(explode(',', (string)$product->images));
        foreach ($old as $img) {
            $path = public_path('uploads/products/' . trim($img));
            if ($img && File::exists($path)) {
                File::delete($path);
            }
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('status', 'Record has been deleted successfully!');
    }

    /* =========================
     * Coupons
     * ========================= */
    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function add_coupon()
    {
        return view('admin.coupon-add');
    }

    public function add_coupon_store(Request $request)
    {
        $request->validate([
            'code'           => 'required|string|max:255|unique:coupons,code',
            'type'           => 'required|in:fixed,percent',
            'value'          => 'required|numeric|min:0',
            'cart_min_value' => 'required_without:cart_value|nullable|numeric|min:0',
            'cart_value'     => 'required_without:cart_min_value|nullable|numeric|min:0',
            'expiry_date'    => 'required|date|after:today',
        ]);

        $coupon                 = new Coupon();
        $coupon->code           = (string)$request->input('code');
        $coupon->type           = (string)$request->input('type');

        // Assign as strings (formatted) to satisfy decimal casts
        $coupon->value          = number_format((float)$request->input('value', 0), 2, '.', '');
        $coupon->cart_min_value = number_format(
            (float)($request->input('cart_min_value', $request->input('cart_value', 0))),
            2,
            '.',
            ''
        );

        // Assign Carbon instance (if model casts 'date', analyzer is happy)
        $coupon->expiry_date    = Carbon::parse($request->input('expiry_date'));

        $coupon->save();

        return redirect()->route('admin.coupons')
            ->with('status', 'Record has been added successfully!');
    }

    public function edit_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function update_coupon(Request $request)
    {
        $request->validate([
            'id'             => 'required|exists:coupons,id',
            'code'           => 'required|string|max:255|unique:coupons,code,' . $request->id,
            'type'           => 'required|in:fixed,percent',
            'value'          => 'required|numeric|min:0',
            'cart_min_value' => 'required_without:cart_value|nullable|numeric|min:0',
            'cart_value'     => 'required_without:cart_min_value|nullable|numeric|min:0',
            'expiry_date'    => 'required|date|after:today',
        ]);

        $coupon                 = Coupon::findOrFail($request->id);
        $coupon->code           = (string)$request->input('code');
        $coupon->type           = (string)$request->input('type');
        $coupon->value          = number_format((float)$request->input('value', 0), 2, '.', '');
        $coupon->cart_min_value = number_format(
            (float)($request->input('cart_min_value', $request->input('cart_value', 0))),
            2,
            '.',
            ''
        );
        $coupon->expiry_date    = Carbon::parse($request->input('expiry_date'));

        $coupon->save();

        return redirect()->route('admin.coupons')
            ->with('status', 'Record has been updated successfully!');
    }

    public function delete_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons')
            ->with('status', 'Record has been deleted successfully!');
    }

    /* =========================
     * Orders
     * ========================= */
    public function orders(Request $request)
    {
        $q      = trim((string)$request->get('q', ''));
        $status = $request->get('status');
        $from   = $request->get('from'); // YYYY-MM-DD
        $to     = $request->get('to');   // YYYY-MM-DD

        $orders = Order::query()
            ->withCount('items')                            // -> items_count
            ->withSum('items as subtotal', 'total')         // -> subtotal
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('tracking_number', 'like', "%{$q}%")
                        ->orWhere('id', $q);
                });
            })
            ->when($status && $status !== 'all', fn($qq) => $qq->where('status', $status))
            ->when($from, fn($qq) => $qq->whereDate('created_at', '>=', $from))
            ->when($to, fn($qq) => $qq->whereDate('created_at', '<=', $to))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.orders', compact('orders', 'q', 'status', 'from', 'to'));
    }

    // DETAILS
    public function orderItems(Order $order)
    {
        // Correct loadSum signature (relation, column)
        $order->loadCount('items')
            ->loadSum('items as subtotal', 'total');

        $orderitems = OrderItem::where('order_id', $order->id)
            ->orderBy('id', 'asc')
            ->paginate(12)
            ->withQueryString();

        $transaction = Transaction::where('order_id', $order->id)->first();

        return view('admin.order-details', compact('order', 'orderitems', 'transaction'));
    }

    public function orderCreate()
    {
        return view('admin.orders-create');
    }

    public function orderStore(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            // order header
            'name'            => ['nullable', 'string', 'max:255'],
            'email'           => ['nullable', 'email', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'address'         => ['nullable', 'string'],
            'city'            => ['nullable', 'string', 'max:100'],
            'state'           => ['nullable', 'string', 'max:100'],
            'country'         => ['nullable', 'string', 'max:100'],
            'zip'             => ['nullable', 'string', 'max:30'],
            'status'          => ['required', 'in:pending,completed,delivered,canceled'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
            'notes'           => ['nullable', 'string'],
            'tax_percent'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            // items (arrays)
            'items'           => ['required', 'array', 'min:1'],
            'items.*.sku'     => ['nullable', 'string', 'max:255'],
            'items.*.name'    => ['required', 'string', 'max:255'],
            'items.*.qty'     => ['required', 'integer', 'min:1'],
            'items.*.price'   => ['required', 'numeric', 'min:0'],
        ]);

        // Create order + items atomically
        $order = DB::transaction(function () use ($validated) {
            // compute subtotal from items
            $subtotal = 0.0;
            foreach ($validated['items'] as $it) {
                $subtotal += ((int)$it['qty']) * ((float)$it['price']);
            }

            $taxPercent = isset($validated['tax_percent']) ? (float)$validated['tax_percent'] : 0.0;
            $taxAmount  = round($subtotal * ($taxPercent / 100), 2);
            $total      = round($subtotal + $taxAmount, 2);

            // If your Order model casts total => decimal:2, storing string avoids analyzer complaints
            $order = Order::create([
                'name'            => $validated['name'] ?? null,
                'email'           => $validated['email'] ?? null,
                'phone'           => $validated['phone'] ?? null,
                'address'         => $validated['address'] ?? null,
                'city'            => $validated['city'] ?? null,
                'state'           => $validated['state'] ?? null,
                'country'         => $validated['country'] ?? null,
                'zip'             => $validated['zip'] ?? null,
                'status'          => $validated['status'],
                'tracking_number' => $validated['tracking_number'] ?? null,
                'notes'           => $validated['notes'] ?? null,
                'total'           => number_format($total, 2, '.', ''), // string for decimal cast
            ]);

            // create items
            $itemsPayload = [];
            foreach ($validated['items'] as $it) {
                $lineTotal = ((int)$it['qty']) * ((float)$it['price']);
                $itemsPayload[] = [
                    'order_id'   => $order->id,
                    'sku'        => $it['sku'] ?? null,
                    'name'       => $it['name'],
                    'qty'        => (int)$it['qty'],
                    'price'      => number_format((float)$it['price'], 2, '.', ''), // string for decimal cast
                    'total'      => number_format($lineTotal, 2, '.', ''),         // string for decimal cast
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            OrderItem::insert($itemsPayload);

            return $order;
        });

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order created successfully.');
    }
}
