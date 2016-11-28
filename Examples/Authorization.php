<?php
/**
 * GETNET
 *
 * Cliente para o Web Service da GETNET.
 *
 * O WebService permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença MIT
 * Baseado na documentação técnica - versão 1.2 de 05/2014
 *
 * @category   Classes
 * @package    Cliente
 * @subpackage GETNET
 * @copyright  Bruno Paz  <brunopaz@azpay.com.br> (c) 2015
 * @license    MIT
 * @see        Classe de utlizada no GATEWAY AZPAY - azpay.com.br
 */


## EXEMPLO DE AUTORIZAÇÃO
$getnet = new Getnet();
$getnet->setEnvironment(1);
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

?>