<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUnitPriceByMeasurementRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'categoryId' => 'required|numeric|exists:categories,categoryId',
            'price' => 'required|numeric',
            'effectiveDate' => 'required|date',
            'unitMeasurementId' => 'required|numeric|exists:unit_measurements,unitMeasurementId',
        ];
    }

    protected function rulesPost(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
            'unitMeasurementId' => 'required|numeric|exists:unit_measurements,unitMeasurementId',
            'price' => 'required|numeric',
            'effectiveDate' => 'required|date',
        ];
    }

    protected function rulesPut(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
            'unitMeasurementId' => 'required|numeric|exists:unit_measurements,unitMeasurementId',
            'price' => 'required|numeric',
            'effectiveDate' => 'required|date',
        ];
    }

    protected function rulesDestroy(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
            'unitMeasurementId' => 'required|numeric|exists:unit_measurements,unitMeasurementId',
        ];
    }

    protected function rulesPatch(): array
    {
        return [
            'productId' => 'required|numeric|exists:products,productId',
            'productUnitPriceId' => 'required|numeric|exists:product_unit_price_by_measurements,productUnitPriceId',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'productId.required' => 'El campo productId es obligatorio',
            'productId.numeric' => 'El campo productId debe ser numérico',
            'productId.exists' => 'El campo productId no existe en la tabla products',
            'unitMeasurementId.required' => 'El campo unitMeasurementId es obligatorio',
            'unitMeasurementId.numeric' => 'El campo unitMeasurementId debe ser numérico',
            'unitMeasurementId.exists' => 'El campo unitMeasurementId no existe en la tabla unit_measurements',
            'price.required' => 'El campo price es obligatorio',
            'price.numeric' => 'El campo price debe ser numérico',
            'effectiveDate.required' => 'El campo effectiveDate es obligatorio',
            'effectiveDate.date' => 'El campo effectiveDate debe ser una fecha',
        ];
    }
}
