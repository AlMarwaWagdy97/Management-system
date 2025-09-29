<?php

namespace App\Models;

use App\Models\Vendor;
use App\Models\TagProduct;
use App\Models\AttributeSet;
use App\Models\ProductVariances;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductAttributesVales;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'sort',
        'sku',
        'image',
        'quantity',
        'start_at',
        'end_at',
        'price',
        'vendor_price',
        'is_variance',
        'feature',
        'status',
        'cover_image',
        'sale_price',
        'is_cheacked',
        'vendor_id',
        'category_id',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'product_id';

    public $translatedAttributes = [
        'product_id',
        'locale',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'content',
    ];


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', "published");
    }
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
    public function scopeLang($query)
    {
        return $query->trans->where('locale',  app()->getLocale())->first();
    }
    public function scopeVariance($query)
    {
        return $query->where('is_variance', 1);
    }
    public function scopeProduct($query)
    {
        return $query->where('is_variance', 0);
    }


    // relations ------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function Category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagProduct::class, 'product_tag_pivots', 'product_id', 'tag_id')->with('trans');
    }

    public function attributeSet()
    {
        return $this->belongsToMany(AttributeSet::class, 'product_attribute_sets', 'product_id', 'attribute_id')->with('trans', 'attribute');
    }

    public function productAttributeSet()
    {
        return $this->hasMany(ProductAttributeSet::class, 'product_id');
    }

    public function variances()
    {
        return $this->hasOne(ProductVariances::class, 'variance_id')->with('attributeValue');
    }

    public function product()
    {
        return $this->hasMany(ProductVariances::class, 'product_id')->with('attributeValue', 'productVariance');
    }

    public function groupedProduct()
    {
        return $this->belongsToMany(Product::class, 'product_variances', 'product_id', 'variance_id');
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


    protected static function boot()
    {
        parent::boot();

        self::creating(function (Product $product) {
            $product->created_by = Auth::check() ? Auth::id() : 0;
        });

        self::deleting(function (Product $product) {
            // get Variance
            $varianceProduct = $product->product;
            // delete Product variance value
            foreach ($varianceProduct as $variance) {
                $variance->productAttributeVariance()->delete();
            }
            // delete Product variance value
            $product->productAttributeSet()->delete();
            // delete Product variance
            $product->groupedProduct()->delete();
            // get variance
            $product->product()->delete();
        });
    }
}
