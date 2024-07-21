<?php
namespace DavidMaximous\Fawrypay\Traits;

trait SetVariables
{
    public $user_id = null;
    public $user_name = null;
    public $user_email = null;
    public $user_phone = null;
    public $method = null;
    public $amount = null;
    public $language = null;
    public $item = null;
    public $quantity = null;
    public $description = null;
    public $itemImage = null;


    /**
     * Sets user ID
     *
     * @param  integer  $value
     * @return $this
     */
    public function setUserId($value)
    {
        $this->user_id = $value;
        return $this;
    }

    /**
     * Sets user name
     *
     * @param  string  $value
     * @return $this
     */
    public function setUserName($value)
    {
        $this->user_name = $value;
        return $this;
    }

    /**
     * Sets user email
     *
     * @param  string  $value
     * @return $this
     */
    public function setUserEmail($value)
    {
        $this->user_email = $value;
        return $this;
    }

    /**
     * Sets user phone
     *
     * @param  string  $value
     * @return $this
     */
    public function setUserPhone($value)
    {
        $this->user_phone = $value;
        return $this;
    }

    /**
     * Sets Method
     *
     * @param  string  $value
     * @return $this
     */
    public function setMethod($value)
    {
        $this->method = $value;
        return $this;
    }

    /**
     * Sets Language
     *
     * @param  string  $value
     * @return $this
     */
    public function setLanguage($value)
    {
        $this->language = $value;
        return $this;
    }

    /**
     * Sets amount per item
     *
     * @param  double  $value
     * @return $this
     */
    public function setAmount($value)
    {
        $this->amount = $value;
        return $this;
    }

    /**
     * Sets item
     *
     * @param  string  $value
     * @return $this
     */
    public function setItem($value)
    {
        $this->item = $value;
        return $this;
    }

    /**
     * Sets Item Quantity
     *
     * @param  int  $value
     * @return $this
     */
    public function setQuantity($value)
    {
        $this->quantity = $value;
        return $this;
    }

    /**
     * Sets Item Description
     *
     * @param  string  $value
     * @return $this
     */
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Sets Item Image
     *
     * @param  string  $value
     * @return $this
     */
    public function setItemImage($value)
    {
        $this->itemImage = $value;
        return $this;
    }


    /**
     * set passed vaiables to pay function to be global
     * @param $amount
     * @param null $user_id
     * @param null $user_name
     * @param null $user_email
     * @param null $user_phone
     * @param null $language
     * @param null $method
     * @param null $item
     * @param null $quantity
     * @param null $description
     * @param null $itemImage
     * @return void
     */
    public function setPassedVariablesToGlobal($amount = null, $user_id = null, $user_name = null, $user_email = null, $user_phone = null, $language = null, $method = null, $item = null, $quantity = null, $description = null, $itemImage = null)
    {
        if($amount!=null)$this->setAmount($amount);
        if($user_id!=null)$this->setUserId($user_id);
        if($user_name!=null)$this->setUserName($user_name);
        if($user_email!=null)$this->setUserEmail($user_email);
        if($user_phone!=null)$this->setUserPhone($user_phone);
        if($language!=null)$this->setLanguage($language);
        if($method!=null)$this->setMethod($method);
        if($item!=null)$this->setItem($item);
        if($quantity!=null)$this->setQuantity($quantity);
        if($description!=null)$this->setDescription($description);
        if($itemImage!=null)$this->setItemImage($itemImage);
    }


}
