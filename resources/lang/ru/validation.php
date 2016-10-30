<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute должен быть принят.',
    'active_url'           => ':attribute не верный URL.',
    'after'                => ':attribute должна быть дата после :date.',
    'alpha'                => ':attribute должен содержать только буквы.',
    'alpha_dash'           => ':attribute может содержать только буквы, цифры и дефис.',
    'alpha_num'            => ':attribute может содержать только буквы и цифры.',
    'array'                => ':attribute должен быть массивом.',
    'before'               => ':attribute должна быть дата перед :date.',
    'between'              => [
        'numeric' => ':attribute может быть не менее :min, но не более :max.',
        'file'    => ':attribute может быть не менее :min, но не более :max Kb.',
        'string'  => ':attribute может содержать от :min до :max символов.',
        'array'   => ':attribute может содержать не менее :min, но не более :max элементов.',
    ],
    'boolean'              => ':attribute может принимать только true или false.',
    'confirmed'            => ':attribute подтверждение не совпадает.',
    'date'                 => ':attribute это не корректная дата.',
    'date_format'          => ':attribute не соответствует формату :format.',
    'different'            => ':attribute и :other не должны совпадать.',
    'digits'               => ':attribute может быть :digits разряда.',
    'digits_between'       => ':attribute может быть не менее :min, но не более :max разряда.',
    'distinct'             => ':attribute поле содержит повторяющееся значение.',
    'email'                => ':attribute должен быть корректным адресом электронной почты',
    'exists'               => 'Выбранный :attribute является недействительным.',
    'filled'               => ':attribute обязательное для заполнения.',
    'image'                => ':attribute должно быть изображением.',
    'in'                   => 'Выбранный :attribute является недействительным.',
    'in_array'             => ':attribute поле не существует в :other.',
    'integer'              => ':attribute должен быть числом.',
    'ip'                   => ':attribute должен быть корректным IP адресом.',
    'json'                 => ':attribute должна быть корректной JSON строкой.',
    'max'                  => [
        'numeric' => ':attribute не может быть больше, чем :max.',
        'file'    => ':attribute не может быть больше, чем :max Kb.',
        'string'  => ':attribute не может содержать больше :max символов.',
        'array'   => ':attribute не может содержать больше чем :max элементов.',
    ],
    'mimes'                => ':attribute должен быть файлом типа: :values.',
    'min'                  => [
        'numeric' => ':attribute может быть не менее :min.',
        'file'    => ':attribute может быть не менее :min Kb.',
        'string'  => ':attribute может содержать не менее :min символов.',
        'array'   => ':attribute может содержать не менее :min элементов.',
    ],
    'not_in'               => ':attribute является недействительным.',
    'numeric'              => ':attribute может быть только числом.',
    'present'              => ':attribute должно присутствовать.',
    'regex'                => ':attribute неверный формат.',
    'required'             => ':attribute обязательное поле для заполнения',
    'required_if'          => ':attribute поле обязательное для заполнения, если :other имеет значение :value.',
    'required_unless'      => ':attribute поле обязательное для заполнения, если :other не имеет значение :values.',
    'required_with'        => ':attribute обязательное поле для заполнения, если указано :values.',
    'required_with_all'    => ':attribute обязательное поле для заполнения, если указано :values.',
    'required_without'     => ':attribute обязательное поле для заполнения, если не указано :values.',
    'required_without_all' => ':attribute поле обязательное для заполнения, когда ни одно из :values не указано.',
    'same'                 => ':attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => ':attribute должен быть :size.',
        'file'    => ':attribute должен быть :size Kb.',
        'string'  => ':attribute может содержать :size смиволов.',
        'array'   => ':attribute может содержать :size элементов.',
    ],
    'string'               => ':attribute должен быть строкой.',
    'timezone'             => ':attribute должно быть корректной зоной.',
    'unique'               => ':attribute уже используется в системе.',
    'url'                  => ':attribute неверный формат.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
