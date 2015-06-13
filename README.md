# SDK-PHP-Getnet-Santander
SDK em PHP para integração com o webservice da adquirente GETNET do grupo Santander.

```php
## EXEMPLO DE AUTORIZAÇÃO
$getnet = new Getnet();
$getnet->setUsername("azpay");
$getnet->setPassword("#password#");
$getnet->setMerchantID("1234567");
$getnet->setTerminalID("D12345699");
$getnet->setMerchantTrackID("127");
$getnet->setAmount("1.00");
$getnet->setCurrencycode("986");
$getnet->setInstType("SGL");
$getnet->setInstNum("none");
$getnet->setNumber("4444333322221111");
$getnet->setCvv2("123");
$getnet->setExpiryMonth("12");
$getnet->setExpiryYear("2015");
$getnet->setHolderName("Bruno Paz");
$getnet->setUdf1("none");
$getnet->setUdf2("none");
$getnet->setUdf3("none");
$getnet->setUdf4("none");
$getnet->setUdf5("none");
$getnet->setTranMCC("none");
$getnet->setSoftDescriptor("none");
$getnet->AuthorizationService();
```


Desenvolvido pela equipe AZPAY - www.azpay.com.br
Documentação técnica para integração com o AZPAY - doc.azpay.com.br
