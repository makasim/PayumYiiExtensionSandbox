<?php

class PaypalController extends CController
{
    public function actionPrepare()
    {
        $paymentName = 'paypal_ec';

        $payum = $this->getPayum();

        $storage = $payum->getRegistry()->getStorage(
            'PaymentDetails',
            $paymentName
        );

        $details = $storage->createModel();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';
        $details['PAYMENTREQUEST_0_AMT'] = 1.23;
        $storage->updateModel($details);

        $captureToken = $payum->getTokenFactory()->createCaptureToken($paymentName, $details, 'paypal/done');

        $this->redirect($captureToken->getTargetUrl());
    }

    public function actionDone()
    {
        $token = $this->getPayum()->getHttpRequestVerifier()->verify($_REQUEST);
        $payment = $this->getPayum()->getRegistry()->getPayment($token->getPaymentName());

        $status = new \Payum\Core\Request\GetHumanStatus($token);
        $payment->execute($status);

        echo CHtml::tag('h3', array(), 'Payment status is ' . $status->getValue());
        echo CHtml::tag('pre', array(), json_encode(iterator_to_array($status->getModel()), JSON_PRETTY_PRINT));
        Yii::app()->end();
    }

    /**
     * @return \Payum\YiiExtension\PayumComponent
     */
    private function getPayum()
    {
        return Yii::app()->payum;
    }
}