<?php namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Contact extends Model
{
    use PresentableTrait;

    protected $presenter = 'Modules\Contact\Presenters\ContactPresenter';
    protected $table     = 'contacts';
    protected $fillable  = ['ip'];

    public function __construct(array $attributes = [])
    {
        $this->fillable = array_merge($this->fillable, array_keys(config('asgard.contact.config.fields')));
        parent::__construct($attributes);
    }

    public function getFullNameAttribute()
    {
        return $this->getAttribute('first_name') . ' ' . $this->getAttribute('last_name');
    }
}
