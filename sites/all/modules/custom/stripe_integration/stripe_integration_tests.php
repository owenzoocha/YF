<?php

//\Stripe\Stripe::setApiKey("sk_test_r1WiSqZbxNMycBepOWD4LSol");
//
//$customer = \Stripe\Customer::create(array(
//  "description" => "Test customer for kimberley.cgm@gmail.com",
//  "email" => "kimberley.cgm@gmail.com"
//));
//
//var_dump($customer);


// For one-off payments.
//    // Standard subscription.
//    $markup .= '<form action="/user/stripe-sign-up" method="post">
//      <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
//        data-key="pk_test_8ulZr1Q3aJHNdbLUo7EA8x2s"
//        data-label="' . t('Standard') . '"
//        data-description="' . t('Sign up for a standard account') . '"
//        data-amount="30"
//        data-locale="auto">
//      </script>
//      <input type="hidden" name="amount" value="30">
//    </form>';
//    // Premium subscription.
//    $markup .= '<form action="/user/stripe-sign-up" method="post">
//      <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
//        data-key="pk_test_8ulZr1Q3aJHNdbLUo7EA8x2s"
//        data-label="' . t('Premium') . '"
//        data-description="' . t('Sign up for a premium account') . '"
//        data-amount="60"
//        data-locale="auto">
//      </script>
//      <input type="hidden" name="amount" value="60">
//    </form>';