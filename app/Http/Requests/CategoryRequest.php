<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Illuminate\Log\log;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function typeMetodo(): string
    {
        switch ($this->method()) {
            case 'POST':
                $this->rulesPost();
                break;
            case 'PUT':
                $this->rulesPut();
                break;
            case 'DELETE':
                $this->rulesDestroy();
                break;
            case 'PATCH':
                $this->rulesPatch();
                break;
            default:
                return 'index';
                break;
        }
    }

    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->rulesPost(),
            'PUT' => $this->rulesPut(),
            'DELETE' => $this->rulesDestroy(),
            'PATCH' => $this->rulesPatch(),
            default => [],
        };
    }

    protected function sharedRules(): array
    {
        return [
            'categoryName' => 'required|string|max:255',
            'categorydescription' => 'required|string',
            'parentCategoryId' => 'nullable|numeric|exists:categories,categoryId',
        ];
    }

    protected function rulesPost(): array
    {
        return array_merge($this->sharedRules(), [
            'categoryName' => 'required|string|max:255|unique:categories,categoryName',
        ]);
    }

    protected function rulesPut(): array
    {
        log($this);
       return array_merge($this->sharedRules(), [
            'categoryName' => 'required|string|max:255|unique:categories,categoryName,' . $this->category->categoryId . ',categoryId',
        ]);
    }

    protected function rulesDestroy(): array
    {
        return [
            'categoryId' => 'required|numeric|exists:categories,categoryId',
        ];
    }

    protected function rulesPatch(): array
    {
        return [
            'categoryId' => 'required|numeric|exists:categories,categoryId',
            'categoryName' => 'required|string|max:255',
            'categoryDescription' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'categoryName.required' => 'El nombre de la categoría es requerido',
            'categoryName.string' => 'El nombre de la categoría debe ser una cadena de texto',
            'categoryName.max' => 'El nombre de la categoría no debe exceder los 255 caracteres',
            'categorydescription.required' => 'La descripción de la categoría es requerida',
            'categorydescription.string' => 'La descripción de la categoría debe ser una cadena de texto',
            'parentCategoryId'=>''
        ];
    }
}
