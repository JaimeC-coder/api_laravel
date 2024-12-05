<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Illuminate\Log\log;
class UnitMeasurementRequest extends FormRequest
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
        return match ($this->method()) {
            'POST' => $this->rulesPost(),
            'PUT' => $this->rulesPut(),
            'DELETE' => $this->rulesDestroy(),
            'PATCH' => $this->rulesPatch(),
            default => [],
        };
    }


    // 'unitMeasurementId'=>$this->unitMeasurementId,
    // 'unitName'=>$this->unitName,
    // 'abbreviation'=>$this->abbreviation,
    // 'description'=>$this->description


    protected function sharedRules(): array
    {
        return [
            'unitName' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function rulesPost(): array
    {
        return array_merge($this->sharedRules(), [
            'unitName' => 'required|string|max:255|unique:unit_measurements,unitName',
            'abbreviation' => 'required|string|max:255|unique:unit_measurements,abbreviation',
        ]);
    }

    public function rulesPut(): array
    {
        return array_merge($this->sharedRules(), [
            'unitName' => 'required|string|max:255|unique:unit_measurements,unitName,' . $this->unitMeasurementId . ',unitMeasurementId',
            'abbreviation' => 'required|string|max:255|unique:unit_measurements,abbreviation,' . $this->unitMeasurementId . ',unitMeasurementId',

        ]);
    }
    public function rulesDestroy(): array
    {
        return [
            'unitMeasurementId' => 'required|numeric|exists:unit_measurements,unitMeasurementId',
        ];
    }



    public function messages(): array
    {
        return [
            'unitName.required' => 'El nombre de la unidad de medida es requerido',
            'unitName.string' => 'El nombre de la unidad de medida debe ser una cadena de texto',
            'unitName.max' => 'El nombre de la unidad de medida debe tener un máximo de 255 caracteres',
            'unitName.unique' => 'El nombre de la unidad de medida ya existe',
            'abbreviation.required' => 'La abreviatura de la unidad de medida es requerida',
            'abbreviation.string' => 'La abreviatura de la unidad de medida debe ser una cadena de texto',
            'abbreviation.max' => 'La abreviatura de la unidad de medida debe tener un máximo de 255 caracteres',
            'abbreviation.unique' => 'La abreviatura de la unidad de medida ya existe',
            'description.required' => 'La descripción de la unidad de medida es requerida',
            'description.string' => 'La descripción de la unidad de medida debe ser una cadena de texto',
            'unitMeasurementId.required' => 'El id de la unidad de medida es requerido',
            'unitMeasurementId.numeric' => 'El id de la unidad de medida debe ser un número',
            'unitMeasurementId.exists' => 'El id de la unidad de medida no existe',
        ];
    }
}
