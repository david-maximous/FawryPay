<?php
namespace DavidMaximous\Fawrypay\Traits;

use DavidMaximous\Fawrypay\Exceptions\MissingPaymentInfoException;

trait SetRequiredFields
{
    /**
     * Check required fields and throw Exception if null
     *
     * @param  array $required_fields
     * @return void
     */
    public function checkRequiredFields($required_fields)
    {

        $amount = $this->amount ?? null;
        $user_id = $this->user_id ?? null;
        $user_name = $this->user_name ?? null;
        $user_email = $this->user_email ?? null;
        $user_phone = $this->user_phone ?? null;
        $method = $this->method ?? null;
        $language = $this->language ?? null;
        $item = $this->item ?? null;
        $quantity = $this->quantity ?? null;
        $description = $this->description ?? null;
        $itemImage = $this->itemImage ?? null;
        foreach($required_fields as $field){
            $this->{$field} = $this->{$field} ?? ${$field};
            if (is_null($this->{$field})) throw new MissingPaymentInfoException($field);
        }
    }

}
