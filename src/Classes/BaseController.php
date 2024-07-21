<?php

namespace DavidMaximous\Fawrypay\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DavidMaximous\Fawrypay\Traits\SetVariables;
use DavidMaximous\Fawrypay\Traits\SetRequiredFields;

class BaseController
{
	use SetVariables,SetRequiredFields;
}
