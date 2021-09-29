<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionTranslation extends Model
{
    protected $table = 'promotions_translation';

    protected $fillable = [ 'promotion_id',
                            'lang_id',
                            'banner',
                            'banner_mob',
                            'name',
                            'description',
                            'body',
                            'field_1',
                            'field_2',
                            'field_3',
                            'field_4',
                            'field_5',
                            'seo_text',
                            'seo_title',
                            'seo_description',
                            'seo_keywords'
                        ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
