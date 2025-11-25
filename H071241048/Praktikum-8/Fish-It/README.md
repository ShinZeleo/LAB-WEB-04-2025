# Fish-It Game

Fish-It is a Laravel-based web application for managing a fish database with rarity levels, weights, prices, and catch probabilities. It simulates a fishing game where players can collect and manage various fish species with different characteristics.

## Features

- Full CRUD operations for fish management
- Advanced filtering and sorting capabilities
- Rarity-based fish classification system
- Weight range specifications
- Economic simulation with price per kilogram
- Catch probability mechanics
- Responsive pagination

## PHP Code Structure

### Fish Model (`app/Models/Fish.php`)

The Fish model extends Laravel's Eloquent Model and implements the database structure and business logic for fish entities:

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];
```

- **HasFactory Trait**: Provides model factory capabilities for testing and seeding
- **Table Specification**: Explicitly sets the table name to 'fishes'
- **Fillable Attributes**: Defines mass-assignable fields that can be set during create/update operations

#### Query Scopes

The model implements three query scopes for flexible data retrieval:

**scopeByRarity Method**:
```
public function scopeByRarity($query, $rarity)
{
    if ($rarity) {
        return $query->where('rarity', $rarity);
    }
    return $query;
}
```
- This scope allows filtering fish by their rarity level
- Only applies the filter if a rarity value is provided, otherwise returns the query unchanged
- Uses Laravel's query builder to add a WHERE clause for the rarity field

**scopeSearchByName Method**:
```
public function scopeSearchByName($query, $search)
{
    if ($search) {
        return $query->where('name', 'like', '%' . $search . '%');
    }
    return $query;
}
```
- Implements case-insensitive partial matching on the fish name
- Adds a LIKE clause with wildcard characters on both sides for flexible searching
- Only applies the filter if a search term is provided

**scopeSorted Method**:
```
public function scopeSorted($query, $sortColumn = 'name', $sortDirection = 'asc')
{
    $allowedColumns = ['name', 'rarity', 'sell_price_per_kg', 'catch_probability', 'created_at'];
    
    if (in_array($sortColumn, $allowedColumns)) {
        return $query->orderBy($sortColumn, $sortDirection);
    }
    
    return $query->orderBy('name', 'asc'); // Default sorting
}
```
- Implements safe sorting with a whitelist of allowed columns to prevent SQL injection
- Validates that the requested sort column is in the allowed list
- Falls back to default name sorting if an invalid column is requested

#### Accessors

The model implements several accessors that transform data when accessed:

**getFormattedWeightAttribute**:
```
public function getFormattedWeightAttribute()
{
    return number_format($this->base_weight_min, 2) . ' - ' . number_format($this->base_weight_max, 2) . ' kg';
}
```
- Formats the weight range for display with 2 decimal places and 'kg' unit
- Combines minimum and maximum weights into a user-friendly range string

**getMaxValueAttribute**:
```
public function getMaxValueAttribute()
{
    return $this->base_weight_max * $this->sell_price_per_kg;
}
```
- Calculates the maximum possible value of a fish (maximum weight × price per kg)
- Provides an important economic metric for players

**getFormattedSellPriceAttribute**:
```
public function getFormattedSellPriceAttribute()
{
    return number_format($this->sell_price_per_kg);
}
```
- Formats the sell price with thousand separators for readability

**getFormattedCatchProbabilityAttribute**:
```
public function getFormattedCatchProbabilityAttribute()
{
    return $this->catch_probability . '%';
}
```
- Appends a percentage sign to the catch probability for proper display

**getRarityClassAttribute**:
```
public function getRarityClassAttribute()
{
    return match($this->rarity) {
        'Common' => 'text-secondary',
        'Uncommon' => 'text-success',
        'Rare' => 'text-info',
        'Epic' => 'text-primary',
        'Legendary' => 'text-warning',
        'Mythic' => 'text-danger',
        'Secret' => 'text-dark',
        default => 'text-muted'
    };
}
```
- Returns CSS class names based on rarity for visual styling
- Uses PHP's match expression for efficient value mapping

### Fish Controller (`app/Http/Controllers/FishController.php`)

The FishController extends Laravel's base Controller and handles all HTTP requests related to fish management using RESTful conventions:

```
<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
```

#### Index Method

```
public function index(Request $request)
{
    // Get query parameters for filtering and sorting
    $rarity = $request->input('rarity');
    $search = $request->input('search');
    $sortColumn = $request->input('sort', 'name'); // Default sort by name
    $sortDirection = $request->input('direction', 'asc'); // Default sort direction
    
    // Build the query with scopes
    $fishes = Fish::query()
        ->byRarity($rarity)
        ->searchByName($search)
        ->sorted($sortColumn, $sortDirection)
        ->paginate(10) // Add pagination with 10 items per page
        ->withQueryString(); // Preserve query parameters when paginating
    
    // Get all possible rarity values for the filter dropdown
    $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
    
    return view('fishes.index', compact('fishes', 'rarityOptions', 'rarity', 'search', 'sortColumn', 'sortDirection'));
}
```

- **Query Parameters**: Accepts filters including rarity, search term, sort column, and sort direction
- **Method Chaining**: Uses the Fish model's query scopes to build a complex query with filtering, searching, and sorting
- **Pagination**: Implements pagination with 10 records per page using Laravel's built-in pagination
- **Query String Preservation**: Maintains filter parameters across pagination links
- **View Data**: Passes all necessary data to the view for rendering filters and displaying results

#### Create Method

```
public function create()
{
    $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
    return view('fishes.create', compact('rarityOptions'));
}
```

- **Form Preparation**: Sets up the form for creating a new fish with available rarity options
- **View Rendering**: Returns the create view with the rarity options available

#### Store Method

```
public function store(Request $request)
{
    // Validate the form input
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
        'base_weight_min' => 'required|numeric|min:0.01',
        'base_weight_max' => 'required|numeric|min:0.01|gte:base_weight_min',
        'sell_price_per_kg' => 'required|integer|min:1',
        'catch_probability' => 'required|numeric|min:0.01|max:100.00',
        'description' => 'nullable|string',
    ]);
    
    // Create the new fish
    Fish::create($validated);
    
    return redirect()->route('fishes.index')->with('success', 'Fish created successfully!');
}
```

- **Validation Rules**: Implements comprehensive validation including:
  - Name: required string with max 100 characters
  - Rarity: required with specific allowed values from the enum
  - Weight minimum: required numeric with minimum value of 0.01
  - Weight maximum: required numeric that must be greater than or equal to minimum weight
  - Sell price: required integer with minimum value of 1
  - Catch probability: required numeric between 0.01 and 100.00
  - Description: optional string
- **Data Creation**: Uses the validated data to create a new Fish instance
- **Redirection**: Redirects back to the index with success message

#### Show Method

```
public function show(Fish $fish)
{
    // Get the previous and next fish for navigation
    $previousFish = Fish::where('id', '<', $fish->id)->orderBy('id', 'desc')->first();
    $nextFish = Fish::where('id', '>', $fish->id)->orderBy('id', 'asc')->first();
    
    return view('fishes.show', compact('fish', 'previousFish', 'nextFish'));
}
```

- **Route Model Binding**: Uses Laravel's automatic route model binding to inject the Fish instance
- **Navigation**: Implements previous/next navigation using ID comparisons
- **View Data**: Passes the fish record along with navigation aids to the view

#### Edit Method

```
public function edit(Fish $fish)
{
    $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
    return view('fishes.edit', compact('fish', 'rarityOptions'));
}
```

- **Form Preparation**: Prepares the edit form with the existing fish data and rarity options
- **Route Model Binding**: Uses automatic route model binding to inject the Fish instance

#### Update Method

```
public function update(Request $request, Fish $fish)
{
    // Validate the form input
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
        'base_weight_min' => 'required|numeric|min:0.01',
        'base_weight_max' => 'required|numeric|min:0.01|gte:base_weight_min',
        'sell_price_per_kg' => 'required|integer|min:1',
        'catch_probability' => 'required|numeric|min:0.01|max:100.00',
        'description' => 'nullable|string',
    ]);
    
    // Update the fish
    $fish->update($validated);
    
    return redirect()->route('fishes.index')->with('success', 'Fish updated successfully!');
}
```

- **Validation**: Uses the same validation rules as the store method to ensure data consistency
- **Model Update**: Updates the existing fish instance with validated data
- **Redirection**: Redirects back to the index with success message

#### Destroy Method

```
public function destroy(Fish $fish)
{
    $fish->delete();
    return redirect()->route('fishes.index')->with('success', 'Fish deleted successfully!');
}
```

- **Record Deletion**: Permanently removes the fish from the database
- **Redirection**: Redirects back to the index with success message

### Database Migration (`database/migrations/2025_10_31_122224_create_fishes_table.php`)

The migration class follows Laravel's schema management pattern to create and drop the fishes table:

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fishes', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->string('name', 100); // Nama ikan, max 100 chars
            $table->enum('rarity', ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret']); // Tingkat kelangkaan
            $table->decimal('base_weight_min', 8, 2); // Berat minimum (kg), format: 999999.99
            $table->decimal('base_weight_max', 8, 2); // Berat maksimum (kg), format: 999999.99
            $table->integer('sell_price_per_kg'); // Harga jual per kg (Coins)
            $table->decimal('catch_probability', 5, 2); // Probabilitas tertangkap 0.01 - 100.00
            $table->text('description')->nullable(); // Deskripsi ikan, boleh kosong
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fishes');
    }
};
```

**Up Method**:
- **Schema::create()**: Creates the 'fishes' table with the specified columns
- **$table->id()**: Creates an auto-incrementing primary key ID field (BIGINT UNSIGNED)
- **$table->string('name', 100)**: Creates a variable character field with maximum 100 characters for fish names
- **$table->enum('rarity', [...])**: Creates an ENUM field restricting values to predefined rarity options, ensuring data integrity
- **$table->decimal('base_weight_min', 8, 2)**: Creates a decimal field with 8 total digits, 2 after the decimal point, suitable for precise weight measurements (max 999999.99 kg)
- **$table->decimal('base_weight_max', 8, 2)**: Same as base_weight_min but for maximum weight
- **$table->integer('sell_price_per_kg')**: Creates an integer field for price per kilogram, suitable for game currency
- **$table->decimal('catch_probability', 5, 2)**: Creates a decimal field for catch probability with range 0.01-999.99, allowing precise probability values
- **$table->text('description')->nullable()**: Creates a text field for descriptions that can be null, allowing optional entries
- **$table->timestamps()**: Automatically creates created_at and updated_at timestamp columns

**Down Method**:
- **Schema::dropIfExists()**: Safely drops the 'fishes' table if it exists, enabling rollback of the migration

### Database Seeder (`database/seeders/FishSeeder.php`)

The seeder class populates the database with initial fish data using Laravel's seeding functionality:

```
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fishes = [
            // Common Fishes
            [
                'name' => 'Goldfish',
                'rarity' => 'Common',
                'base_weight_min' => 0.10,
                'base_weight_max' => 0.50,
                'sell_price_per_kg' => 100,
                'catch_probability' => 50.00,
                'description' => 'A common freshwater fish often kept in aquariums. Easy to catch for beginners.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // ... more fish entries
        ];

        foreach ($fishes as $fish) {
            DB::table('fishes')->insert($fish);
        }
    }
}
```

- **WithoutModelEvents Trait**: This trait prevents model events from firing during seeding, improving performance
- **$fishes Array**: Contains a comprehensive collection of fish data organized by rarity tiers:
  - **Common Fishes**: Easier to catch (higher probability) and lower value
  - **Uncommon Fishes**: Moderate catch probability and value
  - **Rare Fishes**: Lower catch probability and higher value
  - **Epic Fishes**: Much lower catch probability and significantly higher value
  - **Legendary Fishes**: Very rare catches with extremely high value
  - **Mythic Fishes**: Extremely rare catches with very high value
  - **Secret Fishes**: The rarest catches with the highest value
- **Data Structure**: Each fish entry includes:
  - Name: Human-readable fish name
  - Rarity: Corresponds to the ENUM values in the database
  - Weight Range: Minimum and maximum weight for realistic variation
  - Sell Price: Value per kilogram in game currency
  - Catch Probability: Percentage chance to catch (0.01-100.00)
  - Description: Informational text about the fish
  - Timestamps: Creation and update times using Laravel's `now()` helper
- **DB::table()->insert()**: Uses Laravel's query builder to directly insert data, which is more efficient than Eloquent models for bulk operations
- **Game Balance**: The seeded data creates a balanced progression system where rarer fish are harder to catch but more valuable, encouraging player engagement

### Routes (`routes/web.php`)

Implements Laravel's resource routing pattern for RESTful URLs:

- **Resource Route**: Uses `Route::resource()` to automatically generate all standard CRUD routes for fish management.
- **Home Redirect**: Redirects the root URL to the fish index page.

## Setup Instructions

1. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
3. **Database Setup**:
   ```bash
   # Configure database credentials in .env
   php artisan migrate --seed
   ```

4. **Run the Application**:
   ```bash
   php artisan serve
   ```

## How the Game Works

The Fish-It game simulates fishing with realistic mechanics:

- **Rarity System**: Fish are categorized from Common to Secret with increasing value and decreasing catch probability
- **Weight Variation**: Each fish has a minimum and maximum weight, affecting its total value
- **Economic Mechanics**: Value is calculated based on weight and price per kilogram
- **Catch Probability**: Different fish have different chances of being caught

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
