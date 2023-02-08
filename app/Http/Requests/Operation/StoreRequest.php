<?php

namespace App\Http\Requests\Operation;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
        return [
            'amount' => 'numeric|required',
            'comment' => 'nullable',
//            'category_id' => 'integer|nullable',
            'account_id' => 'integer|required',
            'type' => 'in:income,expense'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->validated();
            $accounts = Auth::user()->accounts()->get()->toArray();
            if (!in_array($data['account_id'], array_column($accounts, 'id'))) $validator->errors()->add('account_id', 'Account_id not found');
            $account = Account::find($data['account_id']);
            if ($data['type'] === 'expense' && $account->balance < floatval($data['amount'])) {
                $validator->errors()->add('amount', $account->balance . ' on balance');
            }
        });
    }
}
