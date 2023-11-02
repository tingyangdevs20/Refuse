<?php

namespace App\Http\Requests;

use App\Model\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $contact = $this->route('contact'); // Get the contact being updated
        $contactId = $contact->id;

        return [
            'name' => 'required|string',
            'number' => [
                'nullable',
                Rule::unique('contacts')->where(function ($query) use ($contactId) {
                    return $query->where(function ($query) {
                        $query->where('number', $this->number)
                            ->orWhere('number2', $this->number)
                            ->orWhere('number3', $this->number);
                    })->where('id', '!=', $contactId)->exists();
                }),
            ],
            // Add similar rules for 'number2', 'number3', 'email1', and 'email2'
            'number2' => [
                'nullable',
                Rule::unique('contacts')->where(function ($query) use ($contactId) {
                    return $query->where(function ($query) {
                        $query->where('number', $this->number2)
                            ->orWhere('number2', $this->number2)
                            ->orWhere('number3', $this->number2);
                    })->where('id', '!=', $contactId)->exists();
                }),
            ],
            'number3' => [
                'nullable',
                Rule::unique('contacts')->where(function ($query) use ($contactId) {
                    return $query->where(function ($query) {
                        $query->where('number', $this->number3)
                            ->orWhere('number2', $this->number3)
                            ->orWhere('number3', $this->number3);
                    })->where('id', '!=', $contactId)->exists();
                }),
            ],
            'email1' => [
                'nullable',
                Rule::unique('contacts')->where(function ($query) use ($contactId) {
                    return $query->where(function ($query) {
                        $query->where('email1', $this->email1)
                            ->orWhere('email2', $this->email1);
                    })->where('id', '!=', $contactId)->exists();
                }),
            ],
            'email2' => [
                'nullable',
                Rule::unique('contacts')->where(function ($query) use ($contactId) {
                    return $query->where(function ($query) {
                        $query->where('email1', $this->email2)
                            ->orWhere('email2', $this->email2);
                    })->where('id', '!=', $contactId)->exists();
                }),
            ],
        ];
    }
}
