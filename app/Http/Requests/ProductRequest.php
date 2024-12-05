<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Illuminate\Log\log;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
        log($this->method());
        log($this);
        log("------------------");
        log($this->productId);
        log("------------------");
        log($this->route('productId'));

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
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'categoryId' => 'required|numeric|exists:categories,categoryId',
            'productStock' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'unitMeasurementId' => 'numeric|exists:unit_measurements,unitMeasurementId',
            'effectiveDate' => 'date|date_format:Y-m-d',
        ];
    }

    public function rulesPost(): array
    {
        return array_merge($this->sharedRules(), [
            'productName' => 'required|string|max:255|unique:products',  // Reglas específicas para POST
        ]);
    }

    public function rulesPut(): array
    {
        return array_merge($this->sharedRules(), [
            'productName' => 'required|string|max:255|unique:products,productName,' . $this->productId . ',productId',
        ]);
    }
    public function rulesDestroy(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
        ];
    }

    public function rulesPatch(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
            'productStock' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'productName.required' => 'El nombre del producto es requerido',
            'productName.string' => 'El nombre del producto debe ser una cadena de texto',
            'productName.max' => 'El nombre del producto no debe exceder los 255 caracteres',
            'productName.unique' => 'El nombre del producto ya existe',
            'productDescription.required' => 'La descripción del producto es requerida',
            'productDescription.string' => 'La descripción del producto debe ser una cadena de texto',
            'categoryId.required' => 'La categoría del producto es requerida',
            'categoryId.numeric' => 'La categoría del producto debe ser un número',
            'categoryId.exists' => 'La categoría del producto no existe',
            'productStock.required' => 'El stock del producto es requerido',
            'productStock.numeric' => 'El stock del producto debe ser un número',
            'price.numeric' => 'El precio del producto debe ser un número',
            'price.min' => 'El precio del producto no debe ser menor a 0',
            'price.required_with' => 'El precio del producto es requerido',
            'unitMeasurementId.numeric' => 'La unidad de medida del producto debe ser un número',
            'unitMeasurementId.exists' => 'La unidad de medida del producto no existe',
            'effectiveDate.date' => 'La fecha de efectividad del precio del producto debe ser una fecha',
            'effectiveDate.date_format' => 'La fecha de efectividad del precio del producto debe tener el formato Y-m-d',
            'effectiveDate.required_with' => 'La fecha de efectividad del precio del producto es requerida',
        ];
    }
}
