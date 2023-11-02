<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'slug' => 'required|max:255',
            'subtitle' => 'max:255',
            'presentation' => 'max:6000',
            'image' => 'max:1024',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Introduceți numele categorie!',
            'title.max' => 'Numele categoriei nu poate avea mai mult de 50 de caractere!',
            'slug.required' => 'Adresa slug a categoriei este obligatorie!',
            'slug.max' => 'Adresa slug a categoriei nu poate avea mai mult de 255 de caractere!',
            'subtitle.max' => 'Subtitlul categoriei nu poate avea mai mult de 255 caractere!',
            'presentation.max' => 'Prezentarea categoriei nu poate avea mai mult de 6000 caractere!',
            'image.max' => 'Imaginea categoriei nu poate să ocupe mai mult de 1MB!',
            'meta_title.max' => 'Tag-ul meta_title al categoriei nu poate avea mai mult de 255 caractere!',
            'meta_description.max' => 'Tag-ul meta_description al categoriei nu poate avea mai mult de 255 caractere!',
            'meta_keywords.max' => 'Tag-ul meta_keywords al categoriei nu poate avea mai mult de 255 caractere!',
        ];
    }
}
