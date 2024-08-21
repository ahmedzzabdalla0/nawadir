<?php
namespace App\Traits;

use Illuminate\Support\Facades\App;

trait MultiLanguage
{

    public function __construct()
    {
        parent::__construct();

        $langs=['ar','en'];
        $fieldsToHide=[];
        if(!isset($this->multi_lang)){
            $this->multi_lang=[];
        }
        foreach ($this->multi_lang as $field){
            foreach ($langs as $l){
                $fieldsToHide[]=$field.'_'.$l;
            }
        }
        $this->hidden=array_merge($fieldsToHide, $this->hidden);

    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->multi_lang) && in_array($key, $this->multi_lang)) {
            $key = $key . '_' . App::getLocale();
        }
        return is_string(parent::__get($key))?htmlspecialchars_decode(parent::__get($key)):parent::__get($key);
    }


    public function attributesToArray()
    {


        // If an attribute is a date, we will cast it to a string after converting it
        // to a DateTime / Carbon instance. This is so we will get some consistent
        // formatting while accessing attributes vs. arraying / JSONing a model.
        $attributes = $this->addDateAttributesToArray(
            $attributes = $this->getArrayableAttributes()
        );

        $attributes = $this->addMutatedAttributesToArray(
            $attributes, $mutatedAttributes = $this->getMutatedAttributes()
        );

        // Next we will handle any casts that have been setup for this model and cast
        // the values to their appropriate type. If the attribute has a mutator we
        // will not perform the cast on those attributes to avoid any confusion.
        $attributes = $this->addCastAttributesToArray(
            $attributes, $mutatedAttributes
        );

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        foreach ($this->multi_lang as $key) {
            $attributes[$key] = $this->$key;
        }


        return $attributes;
    }
}
