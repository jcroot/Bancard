<?php

namespace Bancard\Operations;

class Operations
{
    // Single buy operations url paths.
    const SINGLE_BUY_URL = "/vpos/api/0.3/single_buy";
    const SINGLE_BUY_PAYMENTS_URL = "/payment/single_buy";
    const SINGLE_BUY_ROLLBACK_URL = "/vpos/api/0.3/single_buy/rollback";
    const SINGLE_BUY_CONFIRM_URL = "/vpos/api/0.3/single_buy/confirmations";
    // Preauthorization operations url paths.
    const PREAUTHORIZATION_URL = "/vpos/api/0.3/preauthorizations";
    const PREAUTHORIZATION_PAYMENTS_URL = "/payment/preauthorization";
    const PREAUTHORIZATION_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback";
    const PREAUTHORIZATION_CONFIRM_URL = "/vpos/api/0.3/preauthorizations/confirm";
    const PREAUTHORIZATION_CANCEL_URL = "/vpos/api/0.3/preauthorizations/abort";
    const PREAUTHORIZATION_CONFIRM_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback-confirm";
    // Single buy operations url paths.
    const MULTI_BUY_URL = "/vpos/api/0.3/multi_buy";
    const MULTI_BUY_PAYMENTS_URL = "/payment/multi_buy";
    const MULTI_BUY_ROLLBACK_URL = "/vpos/api/0.3/multi_buy/rollback";
    const MULTI_BUY_CONFIRM_URL = "/vpos/api/0.3/multi_buy/confirmations";
    const MULTI_BUY_USER_VERIFICATION = "/vpos/api/0.3/verification/credit_card";
    // Operations with cards
    const REQUEST_NEW_CARD = "/vpos/api/0.3/cards/new";
    const REQUEST_NEW_CARD_URL = "/payment/response";
    const REQUEST_LIST_CARDS = "/vpos/api/0.3/users/%d/cards";
    const CHARGE_BUY = "/vpos/api/0.3/charge";
}


